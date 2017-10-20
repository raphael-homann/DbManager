<?php
namespace Efrogg\Db\Adapters;

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
     * @return array|\stdClass|false
     */
    public function fetch($type=self::FETCH_TYPE_ASSOC);

    /**
     * renvoie la prochaine ligne de résultat sous forme d'objet standard
     * @param null $class_name
     * @param array $params
     * @return \stdClass
     */
    public function fetchObject($class_name = null, array $params = null);

    /**
    * renvoie tous les résultats sous forme d'un tableau d'objets standards
     * @param string $type
     * @return \array[]
     */
    public function fetchAll($type=self::FETCH_TYPE_ASSOC);

    /**
     * @param $column_name
     * @return array
     */
    public function fetchColumn($column_name);

    /**
     * renvoie tous les résultats sous forme d'un tableau de tableaux associatifs
     * @param null $class_name
     * @param array|null $params
     * @return \stdClass[]
     */
    public function fetchAllObject($class_name = null, array $params = null);

    /**
     * @return int
     */
    public function getErrorCode();

    /**
     * @return String
     */
    public function getErrorMessage();

    /**
     * @return int
     */
    public function getInsertId();

    /**
     * @return int
     */
    public function getAffectedRows();

    /**
     * @return int
     */
    public function rowCount();

    public function getResource();

    public function setAdapter(DbAdapter $adapter);

    public function getAdapter();

    /**
     * @return string|DbQueryBuilder
     */
    public function getQuery();

    /**
     * @param string|DbQueryBuilder $query
     */
    public function setQuery($query);

}