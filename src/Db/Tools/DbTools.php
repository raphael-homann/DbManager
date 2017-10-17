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
                throw new \Exception("unprotected parameter");
//                return "$key = '".self::escape($value)."'"; // todo : remplacer ça !!
            },array_keys($conditions),array_values($conditions)));
        }
    }

    public static function protegeRequete($req,$params = null) {

        // découpe entre les paramètres nommés et les non nommés (?)
        $named_parameters = [];
        $parameters = [];
        foreach($params as $key => $parameter_value) {
            if(is_string($key)) {
                $named_parameters[$key] = self::protegeParam($parameter_value);
            } else {
                $parameters[$key] = ($parameter_value);

            }
        }

        // remplacement des paramètres nommés
        $req = str_replace(array_keys($named_parameters),array_values($named_parameters),$req);

        // remplacement des paramètres ?
        $req =  preg_replace_callback('/\?/',
            function($dummy) use (&$parameters) {
                if(is_array($parameters)) {
                    if(!empty($parameters)) {
                        $p=array_shift($parameters);
                        return self::protegeParam($p);
                    }
                } else {
                    if(!is_null($parameters)) {
                        return self::protegeParam($parameters);
                    }
                }
                return "?";
            }
            , $req);

        // retour :)
        return $req;
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