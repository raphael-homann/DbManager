<?php
/**
 * Created by PhpStorm.
 * User: raph
 * Date: 14/10/16
 * Time: 17:19
 */

namespace Efrogg\Db\Adapters;


use Efrogg\Db\Event\DatabaseEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

abstract class AbstractDbAdapter extends EventDispatcher implements DbAdapter
{

    /** @var  bool */
    protected $throws_exceptions = false;

    protected $name = "database";
    /**
     * @var array<callable>
     */
    private $sqlDecorators=[];

    public function throwsExceptions($throws = true)
    {
        $this->throws_exceptions = $throws;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function dispatchError($queryString, $params, $error)
    {
        $event = new DatabaseEvent();
        $event->query = $queryString;
        $event->parameters = $params;
        $event->error = $error;
        $event->time = 0;
        $event->hostname = $this->getName();
        $this->dispatch(DatabaseEvent::ERROR, $event);
    }

    public function addSqlDecorator(callable $sqlDecorator)
    {
        $this->sqlDecorators[]=$sqlDecorator;
    }

    public function decorateSql($sql)
    {
        foreach ($this->sqlDecorators as $sqlDecorator) {
            $sql = $sqlDecorator($sql);
        }
        return $sql;
    }

}