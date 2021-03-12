<?php

namespace Efrogg\Db\Adapters;




use Efrogg\Db\Context\DbQueryContextInterface;
use Efrogg\Db\Query\DbQueryBuilder;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

interface DbAdapter extends EventDispatcherInterface{
    /**
     * @param string|DbQueryBuilder $query
     * @param array $params
     * @param DbQueryContextInterface $context
     * @return DbResultAdapter
     */
    public function execute($query,$params=array(), DbQueryContextInterface $context = null);

    /**
     * @return string
     */
    public function getError();

    /**
     * @return int
     */
    public function getInsertId();

    /**
     * @return int
     */
    public function getAffectedRows();

    public function throwsExceptions($throws = true);

    public function getName();

    public function addSqlDecorator(callable $sqlDecorator);
}