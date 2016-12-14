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
        $this->dispatch(DatabaseEvent::ERROR,$event);
    }

}