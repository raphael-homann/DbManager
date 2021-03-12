<?php

namespace Efrogg\Db\Adapters\Mysql;

use Efrogg\Db\Adapters\AbstractDbAdapter;
use Efrogg\Db\Adapters\DbAdapter;
use Efrogg\Db\Adapters\DbResultAdapter;
use Efrogg\Db\Context\DbQueryContextInterface;
use Efrogg\Db\Query\DbQueryBuilder;
use Efrogg\Db\Tools\DbTools;

class MysqlDbAdapter extends AbstractDbAdapter {
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
    public function execute($query,$params=array(), DbQueryContextInterface $context = null)
    {
        if($query instanceof DbQueryBuilder) $sql = $query->buildQuery();
        else $sql = DbTools::protegeRequete($query,$params);

        // decoration éventuelle
        $sql = $this->decorateSql($sql);

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