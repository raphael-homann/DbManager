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

abstract class AbstractDbResultAdapter implements DbResultAdapter
{
    /**
     * @var DbAdapter
     */
    protected $adapter;

    /**
     * @param DbAdapter $adapter
     * @return $this
     */
    public function setAdapter(DbAdapter $adapter)
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * @return DbAdapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

}