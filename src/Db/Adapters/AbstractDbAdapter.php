<?php
/**
 * Created by PhpStorm.
 * User: raph
 * Date: 14/10/16
 * Time: 17:19
 */

namespace Efrogg\Db\Adapters;


abstract class AbstractDbAdapter implements DbAdapter
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

}