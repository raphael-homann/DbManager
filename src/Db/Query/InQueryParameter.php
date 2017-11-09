<?php
/**
 * Created by PhpStorm.
 * User: raph
 * Date: 09/11/17
 * Time: 12:52
 */

namespace Efrogg\Db\Query;



use Efrogg\Db\Tools\DbTools;

class InQueryParameter extends QueryParameter
{

    public function __construct($key, array $values,$prefix='')
    {
        parent::__construct($key, $values,$prefix);
    }

    public function getQueryString():string {
        $values = array_map(DbTools::class."::protegeParam",$this->value);
        return $this->getKeyWithPrefix().' IN('.implode(',',$values).')';
    }
}