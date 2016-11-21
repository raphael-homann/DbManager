<?php

namespace Efrogg\Db\Adapters\Prestashop;

use efrogg\Db\Adapters\DbAdapter;
use efrogg\Db\Adapters\DbResultAdapter;
use efrogg\Db\Adapters\Mysql\MysqlDbResult;
use efrogg\Db\Adapters\Pdo\PdoDbResult;
use efrogg\Db\Tools\DbTools;

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
        $sql = DbTools::protegeRequete($query,$params);
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