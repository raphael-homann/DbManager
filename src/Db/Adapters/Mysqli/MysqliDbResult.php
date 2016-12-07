<?php
namespace Efrogg\Db\Adapters\Mysqli;


use Efrogg\Db\Adapters\DbResultAdapter;

class MysqliDbResult implements DbResultAdapter  {

    /**
     * @var \mysqli_result
     */
    private $resource = false;

    public function __construct($resource) {
        $this->resource = $resource;
    }

    public function fetch($type=self::FETCH_TYPE_ASSOC)
    {
        if(false === $this -> resource) {
            return false;
        }

        if(self::FETCH_TYPE_ASSOC === $type) {
            return $this -> resource -> fetch_assoc();
        } else {
            return $this -> resource -> fetch_array();
        }

    }

    // cache nécessaire pour effectuer plusieurs fois le fetchAll
    protected $__fetch_all = [];
    public function fetchAll($type=self::FETCH_TYPE_ASSOC)
    {
        if(false === $this->resource) {
            return [];
        }
        if(!array_key_exists($type,$this->__fetch_all)) {
            $this->__fetch_all[$type] = $this -> resource -> fetch_all($this->getFetchType($type));
        }
        return $this->__fetch_all[$type];
        }

    public function fetchColumn($column = 0)
    {
        if(is_int($column)) $fetchType = self::FETCH_TYPE_ARRAY;
        else $fetchType = self::FETCH_TYPE_ASSOC;

        $all = $this -> fetchAll($fetchType);

        $result=array();
        foreach($all as $value) {
            $result[]=$value[$column];
        }
        return $result;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this -> resource !== false;
    }

    /**
     * @param $class_name
     * @param array $params
     * @return array
     */
    public function fetchObject($class_name = null, array $params = null)
    {
        if(!is_null($params)) {
            return $this->resource -> fetch_object($class_name , $params);
        } else {
            return $this->resource -> fetch_object($class_name);
        }
    }

    public function fetchAllObject($class_name = "stdClass", array $params = null)
    {
        $result=array();
        if($this -> resource) {
            if($this -> resource -> num_rows > 0) $this -> resource -> data_seek(0); // repart du debut

            while($res=$this -> fetchObject($class_name ,  $params))
                $result[]=$res;

            if($this -> resource -> num_rows>0) $this -> resource -> data_seek(0);
        }
        return $result;    }




    public function getErrorCode()
    {
        // TODO: Implement getErrorCode() method.
    }


    public function getErrorMessage()
    {
        // TODO: Implement getErrorMessage() method.
    }

    private function getFetchType($type)
    {
        if(self::FETCH_TYPE_ASSOC === $type) {
            return MYSQLI_ASSOC;
        } elseif(self::FETCH_TYPE_BOTH === $type) {
            return MYSQLI_BOTH;
        }
        return MYSQLI_NUM;

    }

    /**
     * @return int
     */
    public function rowCount()
    {
        return $this->resource->num_rows;
    }
}