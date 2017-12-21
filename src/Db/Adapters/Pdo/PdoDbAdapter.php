<?php

namespace Efrogg\Db\Adapters\Pdo;

use Efrogg\Db\Adapters\DbAdapter;
use Efrogg\Db\Adapters\DbResultAdapter;
use Efrogg\Db\Adapters\AbstractDbAdapter;
use Efrogg\Db\Context\DbQueryContextInterface;
use Efrogg\Db\Exception\DbException;
use Efrogg\Db\Adapters\Mysql\MysqlDbResult;
use Efrogg\Db\Adapters\Pdo\PdoDbResult;
use Efrogg\Db\Query\DbQueryBuilder;
use Efrogg\Db\Tools\DbTools;

class PdoDbAdapter extends AbstractDbAdapter {
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
     * @param DbQueryContextInterface $context
     * @return DbResultAdapter
     * @throws DbException
     */
    public function execute($query, $params = array(), DbQueryContextInterface $context = null)
    {
        if($query instanceof DbQueryBuilder) $query = $query->buildQuery();

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        $result = new PdoDbResult($stmt);
        $result->setInsertId($this->db->lastInsertId());
        $result->setAffectedRows($stmt->rowCount());

        if($this->throws_exceptions && !$result->isValid()) {
//            var_dump($result->getErrorMessage(),$result->getErrorCode());
            throw new DbException($result->getErrorMessage(),$result->getErrorCode());
        }
        $this->lastResult = $result;
        $this->lastStmt = $stmt;
        $result->setErrorQuery($query);

        $result->setAdapter($this);

        return $result;
    }

    /**
     * @deprecated
     * @see PdoDbResult::getErrorMessage()
     * @return string
     */
    public function getError()
    {
        return $this->db->errorInfo();
    }

    /**
     * @deprecated
     * @see PdoDbResult::getInsertId()
     * @return int
     */
    public function getInsertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * @deprecated
     * @see PdoDbResult::getAffectedRows()
     * @return int
     */
    public function getAffectedRows()
    {
        return $this->lastStmt->rowCount();
    }

}