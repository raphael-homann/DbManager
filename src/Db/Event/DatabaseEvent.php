<?php

namespace Efrogg\Db\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Created by PhpStorm.
 * User: raph
 * Date: 14/12/16
 * Time: 05:02
 */
class DatabaseEvent extends Event
{

    const ERROR = "ERROR";
    const QUERY = "ERROR";

    public $query;
    public $error;
    public $parameters;

}