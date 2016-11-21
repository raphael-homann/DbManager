<?php

namespace Efrogg\Db\Adapters\Mysql;

use efrogg\Db\Adapters\DbAdapter;
use efrogg\Db\Adapters\DbResultAdapter;
use efrogg\Db\Tools;
use efrogg\Db\Tools\DbTools;

class MysqlDbAdapter implements DbAdapter{
    /** @var  resource */
    protected $db;


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
     */
    public function execute($query, $params = array(), $forceMaster = false)
    {
        if($query instanceof Tools\DbQueryBuilder) $sql = $query->buildQuery();
        else $sql = DbTools::protegeRequete($query,$params);

        return new MysqlDbResult(mysql_query($sql,$this->db));
    }

    /**
     * @return string
     */
    public function getError()
    {
        return mysql_error($this->db);
    }

    /**
     * @return int
     */
    public function getInsertId()
    {
        return mysql_insert_id($this->db);
    }

    /**
     * @return int
     */
    public function getAffectedRows()
    {
        return mysql_affected_rows($this->db);
    }

    public function throwsExceptions($throws = true)
    {
        // TODO: Implement throwsExceptions() method.
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }
}