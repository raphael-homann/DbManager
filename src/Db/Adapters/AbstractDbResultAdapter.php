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
    protected $query;

    /**
     * requete qui a levé l'erreur
     * @var
     */
    protected $error_query;


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

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }


    /**
     * @return mixed
     */
    public function getErrorQuery()
    {
        return $this->error_query;
    }

    /**
     * @param mixed $error_query
     */
    public function setErrorQuery($error_query)
    {
        $this->error_query = $error_query;
    }

}