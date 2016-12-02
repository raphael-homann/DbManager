<?php
namespace Efrogg\Db\Adapters\Pdo;


use Efrogg\Db\Adapters\DbAdapter;
use Efrogg\Db\Adapters\DbResultAdapter;

class PdoDbResult implements DbResultAdapter {

    /**
     * @var resource
     */
    private $statement = false;

    public function __construct(\PDOStatement $statement) {
        $this->statement = $statement;
    }

    public function fetch($type=self::FETCH_TYPE_ASSOC)
    {
        return $this -> statement -> fetch($this->getFetchStyle($type));
    }

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

    /**
     * @param $class_name
     * @param array $params
     * @return array
     */
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
}