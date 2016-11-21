<?php
namespace Efrogg\Db\Query\Decorator;

use Efrogg\Db\Query\DbQueryBuilder;
use Efrogg\Db\Query\DbQueryDecorator;

/**
 * Created by PhpStorm.
 * User: raph
 * Date: 22/11/16
 * Time: 00:19
 */
class DbLimitDecorator extends DbQueryDecorator
{

    public function __construct($limitStart = null, $limitEnd = null)
    {
        parent::__construct(function(DbQueryBuilder $query) use($limitStart, $limitEnd) {
            $query->limit($limitStart, $limitEnd);
        });
    }
}