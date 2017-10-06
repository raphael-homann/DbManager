<?php
/**
 * Created by PhpStorm.
 * User: raph
 * Date: 16/11/16
 * Time: 17:57
 */

namespace Efrogg\Db\Tools;


class DbTools
{
    public static function parseValuesToWhere($conditions,$use_secure = true)
    {
        if(empty($conditions)) {
            return "1";
        } else {
            return implode(' AND ',array_map(function($key,$value) use($use_secure) {
                if(is_null($value)) return "$key IS NULL";
                if(is_array($value)) return "$key = ".implode(" ",$value);
                if($use_secure) return "$key = ".self::protegeParam($value);
                return "$key = '".pSQL($value)."'";
            },array_keys($conditions),array_values($conditions)));
        }
    }

    public static function protegeRequete($req,$params = null) {

        $named_parameters = [];
        $params = array_filter(function($parameter,$key) use(&$named_parameters) {
            if(is_string($key)) {
                $named_parameters[$key] = self::protegeParam($parameter);
                return false;
            }
            return true;
        },$params);

        $req = str_replace(array_keys($named_parameters),array_values($named_parameters));

        dd($named_parameters,$params,$req);

        $retour =  preg_replace_callback('/\?/',
            function($dummy) use (&$params) {
                if(is_array($params)) {
                    if(!empty($params)) {
                        $p=array_shift($params);
                        return self::protegeParam($p);
                    }
                } else {
                    if(!is_null($params)) {
                        return self::protegeParam($params);
                    }
                }
                return "?";
            }
            , $req);

        return $retour;
    }

    public static function protegeParam($p) {
        if(is_int($p)) return $p;
        if(is_float($p)) return $p;
        if(is_numeric($p)) return "'$p'"; // sécurité
        if(is_null($p)) return 'NULL';
        if($p==='') return "''";
        return self::stringtohex($p);
    }

    public static function stringtohex($string)
    {
        $res=unpack('H*', $string);
        return '0x'.$res[1];
    }

    public static function getHash32($str)
    {
        return hexdec("0x" . substr(md5($str), 0, 8));
    }
}