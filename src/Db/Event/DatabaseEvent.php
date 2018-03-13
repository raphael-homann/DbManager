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
    public function __construct()
    {
        ob_start();
        debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $this->stack = ob_get_clean();
    }

    const ERROR = "ERROR";
    const QUERY = "QUERY";

    public $hostname;
    public $time;
    public $query;
    public $error;
    public $parameters;
    public $stack;

}