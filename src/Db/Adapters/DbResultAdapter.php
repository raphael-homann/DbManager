<?php
namespace efrogg\Db\Adapters;

interface DbResultAdapter {

    const FETCH_TYPE_ASSOC = "FETCH_ASSOC";
    const FETCH_TYPE_ARRAY = "FETCH_ARRAY";
    const FETCH_TYPE_BOTH = "FETCH_BOTH";
    /**
     * @return bool
     */
    public function isValid();

    /**
     * @param string $type
     * @return array|false
     */
    public function fetch($type=self::FETCH_TYPE_ASSOC);

    /**
     * @param null $class_name
     * @param array $params
     * @return array
     */
    public function fetchObject($class_name = null, array $params = null);

    /**
     * @return array[]
     */
    public function fetchAll($type=self::FETCH_TYPE_ASSOC);

    /**
     * @param $column_name
     * @return array
     */
    public function fetchColumn($column_name);

    public function fetchAllObject($class_name = null, array $params = null);

    public function getErrorCode();

    public function getErrorMessage();
}