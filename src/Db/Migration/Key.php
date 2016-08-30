<?php
/**
 * Created by PhpStorm.
 * User: raph
 * Date: 30/08/16
 * Time: 10:09
 */

namespace efrogg\Db\Migration;


class Key
{
    const UNIQUE = "UNIQUE";
    private $key_type;

    /**
     * Key constructor.
     * @param $UNIQUE
     */
    public function __construct($key_type)
    {
        $this->key_type = $key_type;
    }
}