<?php

namespace Efrogg\Db\Adapters\Pdo;

use efrogg\Db\Adapters\DbAdapter;
use efrogg\Db\Adapters\DbResultAdapter;
use efrogg\Db\Adapters\AbstractDbAdapter;
use efrogg\Db\Exception\DbException;
use efrogg\Db\Adapters\Mysql\MysqlDbResult;
use efrogg\Db\Adapters\Pdo\PdoDbResult;

class PdoDbAdapter extends AbstractDbAdapter{
    /** @var  \PDO */
    protected $db;
    /** @var  PdoDbResult */
    protected $lastResult;
    /** @var  \PDOStatement */
    protected $lastStmt;


    /**
     * PrestashopDbAdapter constructor.
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }


    /**
     * @param $query
     * @param array $params
     * @param bool $forceMaster
     * @return DbResultAdapter
     * @throws DbException
     */
    public function execute($query, $params = array(), $forceMaster = false)
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        $result = new PdoDbResult($stmt);

        if($this->throws_exceptions && !$result->isValid()) {
//            var_dump($result->getErrorMessage(),$result->getErrorCode());
            throw new DbException($result->getErrorMessage(),$result->getErrorCode());
        }
        $this->lastResult = $result;
        $this->lastStmt = $stmt;
        return $result;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->db->errorInfo();
    }

    /**
     * @return int
     */
    public function getInsertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * @return int
     */
    public function getAffectedRows()
    {
        return $this->lastStmt->rowCount();
    }

}