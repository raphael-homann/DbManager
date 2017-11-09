<?php
/**
 * Created by PhpStorm.
 * User: raph
 * Date: 09/11/17
 * Time: 12:52
 */

namespace Efrogg\Db\Query;


class RawQueryParameter extends QueryParameter
{
    public function getQueryString():string {
        return $this->getKeyWithPrefix().' '.$this->value;
    }
}