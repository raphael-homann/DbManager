<?php
namespace Efrogg\Db\Adapters\Mysqli;


use Efrogg\Db\Adapters\AbstractDbAdapter;
use Efrogg\Db\Context\DbQueryContextInterface;
use Efrogg\Db\Exception\DbException;
use Efrogg\Db\Query\DbQueryBuilder;
use Efrogg\Db\Tools\DbTools;
use mysqli;

class MysqliDbAdapter extends AbstractDbAdapter  {

    /** @var mysqli  */
    protected $db;
    protected $error_message;
    protected $insert_id;
    protected $affected_rows;

    public function __construct(mysqli $db) {
        $this -> db = $db;
    }
    public function execute($query,$params=array(), DbQueryContextInterface $context = null)
    {
//echo($this->getName());
        // protection des paramètres
        if($query instanceof DbQueryBuilder) $sql = $query->buildQuery();
        else $sql = DbTools::protegeRequete($query,$params);

        // execution de la requete
        $result = new MysqliDbResult($this -> db->query($sql));

        $result->setAffectedRows($this->db->affected_rows);
        $result->setInsertId($this->db->insert_id);

        if(!$result->isValid()) {
            $result->setErrorDetail($this->db->errno,$this->db->error);
            $this->dispatchError($query,$params,$this->db->error);
            if($this->throws_exceptions ) {
    //            var_dump($result->getErrorMessage(),$result->getErrorCode());
                throw new DbException($this->db->error,$this->db->errno);
            }
        }
        $result->setAdapter($this);
        $result -> setQuery($query);
        return $result;

    }

    /**
     * @deprecated
     * @see  MysqliDbResult::getErrorMessage()
     * @return string
     */
    public function getError() {
        return $this->db->error;
    }

    /**
     * @deprecated
     * @see  MysqliDbResult::getInsertId()
     * @return string
     */
    public function getInsertId() {
        return $this -> db->insert_id;
    }

    /**
     * @deprecated
     * @see  MysqliDbResult::getAffectedRows()
     * @return string
     */
    public function getAffectedRows() {
        return $this -> db->affected_rows;
    }
}