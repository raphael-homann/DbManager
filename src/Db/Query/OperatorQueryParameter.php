<?php
/**
 * Created by PhpStorm.
 * User: raph
 * Date: 09/11/17
 * Time: 12:52
 */

namespace Efrogg\Db\Query;



use Efrogg\Db\Tools\DbTools;

class OperatorQueryParameter extends QueryParameter
{
    protected $operator='=';

    public function __construct($key, $value,$operator='=',$prefix = '')
    {
        $this->operator=$operator;
        parent::__construct($key, $value,$prefix);
    }

    public function getQueryString():string {
        return $this->getKeyWithPrefix().$this->operator.DbTools::protegeParam($this->value);
    }
}