<?php
/**
 * Created by PhpStorm.
 * User: raph
 * Date: 06/10/17
 * Time: 11:47
 */

namespace Efrogg\Db\Adapters;



abstract class AbstractDbResultAdapter implements DbResultAdapter
{
    protected $adapter;

    /**
     * @param DbAdapter $adapter
     * @return $this
     */
    public function setAdapter(DbAdapter $adapter): self
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * @return DbAdapter
     */
    public function getAdapter(): DbAdapter
    {
        return $this->adapter;
    }
}