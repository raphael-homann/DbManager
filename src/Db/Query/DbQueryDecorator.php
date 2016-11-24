<?php
/**
 * Created by PhpStorm.
 * User: raph
 * Date: 22/11/16
 * Time: 00:11
 */

namespace Efrogg\Db\Query;


class DbQueryDecorator implements DecoratorInterface
{
    /** @var  callable */
    protected $decorate_function;

    /**
     * DbQueryDecorator constructor.
     * @param callable $decorate_function
     */
    public function __construct(callable $decorate_function)
    {
        $this->decorate_function = $decorate_function;
    }

    public static function __factory(callable $decorate_function) {
        return new static($decorate_function);
    }

    public function decorate($query)
    {
        if(null !== $this->decorate_function) {
            call_user_func($this->decorate_function,$query);
        }
    }
}