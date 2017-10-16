<?php
namespace Efrogg\Db\Adapters\Pdo;


use Efrogg\Db\Adapters\AbstractDbResultAdapter;
use Efrogg\Db\Adapters\DbResultAdapter;

class PdoDbResult extends AbstractDbResultAdapter {

    /**
     * @var resource
     */
    private $statement = false;

    protected $affected_rows;

    protected $insert_id;


    public function __construct(\PDOStatement $statement) {
        $this->statement = $statement;
    }

    public function fetch($type=self::FETCH_TYPE_ASSOC)
    {
        return $this -> statement -> fetch($this->getFetchStyle($type));
    }

    // cache nécessaire pour effectuer plusieurs fois le fetchAll
    protected $__fetch_all = [];
    public function fetchAll($type=self::FETCH_TYPE_ASSOC)
    {
        if(!array_key_exists($type,$this->__fetch_all)) {
            $this->__fetch_all[$type] = $this -> statement -> fetchAll($this->getFetchStyle($type));
        }
        return $this->__fetch_all[$type];

    }

    public function fetchColumn($column = 0)
    {
        if(is_int($column)) {
            return $this -> statement -> fetchColumn($column);
        } else {
            return array_column($this->fetchAll(),$column);
        }
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return intval($this -> statement->errorCode())==0;
    }

    public function fetchObject($class_name = "stdClass", array $params = null)
    {
        if(is_null($params)) {
            return $this -> statement -> fetchObject($class_name);
        } else {
            return $this -> statement -> fetchObject($class_name,$params);
        }
    }

    public function fetchAllObject($class_name = "stdClass", array $params = null)
    {
        $result=array();
        while($line = $this->fetchObject($class_name,$params)) {
            $result[]=$line;
        }
        return $result;
    }

    public function getErrorCode()
    {
        $info = $this -> statement->errorInfo();
        return $info[1];
//        return $this -> statement->errorCode();
    }

    public function getErrorMessage()
    {
        $info = $this -> statement->errorInfo();
        return $info[2];
    }

    private function getFetchStyle($type)
    {
        if($type == DbResultAdapter::FETCH_TYPE_ASSOC) {
            return \PDO::FETCH_ASSOC;
        } elseif($type == DbResultAdapter::FETCH_TYPE_ARRAY) {
            return \PDO::FETCH_NUM;
        } else {
            return \PDO::FETCH_BOTH;
        }
    }

    /**
     * @return int
     */
    public function rowCount()
    {
        return $this->statement->rowCount();
    }

    public function getResource()
    {
        return $this->statement;
    }

    /**
     * @return int
     */
    public function getInsertId()
    {
        return $this->insert_id;
    }

    /**
     * @return int
     */
    public function getAffectedRows()
    {
        return $this->affected_rows;
    }

    /**
     * @param mixed $affected_rows
     * @return PdoDbResult
     */
    public function setAffectedRows($affected_rows)
    {
        $this->affected_rows = $affected_rows;

        return $this;
    }

    /**
     * @param mixed $insert_id
     * @return PdoDbResult
     */
    public function setInsertId($insert_id)
    {
        $this->insert_id = $insert_id;

        return $this;
    }

}