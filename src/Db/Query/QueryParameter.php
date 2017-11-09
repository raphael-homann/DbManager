<?php
/**
 * Created by PhpStorm.
 * User: raph
 * Date: 09/11/17
 * Time: 12:56
 */

namespace Efrogg\Db\Query;


abstract class QueryParameter
{
    protected $prefix='';
    protected $value;
    protected $key;

    /**
     * RawParameter constructor.
     * @param $key
     * @param $value
     * @param string $prefix
     */
    public function __construct($key,$value,$prefix='')
    {
        $this->value = $value;
        $this->key = $key;
        $this->prefix=$prefix;
    }


    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    abstract public function getQueryString():string;

    public function setPrefix($prefix)
    {
        $this->prefix=$prefix;
    }

    public function getKeyWithPrefix() {
        return $this->prefix.$this->key;
}

}