<?php

namespace Efrogg\Db\Adapters\Prestashop;

use Efrogg\Db\Adapters\DbAdapter;
use Efrogg\Db\Adapters\DbResultAdapter;
use Efrogg\Db\Adapters\Mysql\MysqlDbResult;
use Efrogg\Db\Adapters\Pdo\PdoDbResult;
use Efrogg\Db\Query\DbQueryBuilder;
use Efrogg\Db\Tools\DbTools;

class PrestashopDbAdapter implements DbAdapter{
    /** @var  \Db */
    protected $db;

    /** @var  bool */
    protected $throws_exception = false;


    /**
     * PrestashopDbAdapter constructor.
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }


    /**
     * @param $query
     * @param array $params
     * @param bool $forceMaster
     * @return DbResultAdapter
     * @throws \Exception
     */
    public function execute($query, $params = array(), $forceMaster = false)
    {
        if($query instanceof DbQueryBuilder) $sql = $query->buildQuery();
        else $sql = DbTools::protegeRequete($query,$params);

        if($this->db instanceof \MySQL) {
            return new MysqlDbResult($this->db -> query($sql));
        } elseif($this->db instanceof \DbPDOCore) {
            return new PdoDbResult($this->db -> query($sql));
        } else {
            throw new \Exception("datapase type unknown : ".get_class($this->db));
        }
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->db->getMsgError();
    }

    /**
     * @return int
     */
    public function getInsertId()
    {
        $this->db->Insert_ID();
    }

    /**
     * @return int
     */
    public function getAffectedRows()
    {
        $this->db->Affected_Rows();
    }

    public function throwsExceptions($throws = true)
    {
        $this->throws_exception = $throws;
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }
}