<?php
namespace Efrogg\Db\Adapters\Mysqli;


use Efrogg\Db\Adapters\AbstractDbAdapter;
use Efrogg\Db\Exception\DbException;
use Efrogg\Db\Query\DbQueryBuilder;
use Efrogg\Db\Tools\DbTools;
use mysqli;

class MysqliDbAdapter extends AbstractDbAdapter  {

    /** @var mysqli  */
    protected $db;

    public function __construct(mysqli $db) {
        $this -> db = $db;
    }
    public function execute($query,$params=array(), $forceMaster = false)
    {
        // protection des param�tres
        if($query instanceof DbQueryBuilder) $sql = $query->buildQuery();
        else $sql = DbTools::protegeRequete($query,$params);

        // execution de la requete
        $result = new MysqliDbResult($this -> db->query($sql));

        if($this->throws_exceptions && !$result->isValid()) {
//            var_dump($result->getErrorMessage(),$result->getErrorCode());
            throw new DbException($this->db->error,$this->db->errno);
        }
        return $result;

    }

    public function getError() {
        return $this->db->error;
    }

    public function getInsertId() {
        return $this -> db->insert_id;
    }

    public function getAffectedRows() {
        return $this -> db->affected_rows;
    }
}