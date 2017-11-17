<?php
/**
 * Created by PhpStorm.
 * User: raph
 * Date: 16/11/16
 * Time: 17:57
 */

namespace Efrogg\Db\Tools;


use Efrogg\Db\Query\QueryParameter;
use Efrogg\Db\Query\RawQueryParameter;

class DbTools
{
    public static function parseValuesToWhere($conditions,$use_secure = true,$prefixe='')
    {
        if(empty($conditions)) {
            return "1";
        } else {
            return implode(' AND ',array_map(function($key,$value) use($use_secure,$prefixe) {
                if($value instanceof QueryParameter) return "$prefixe".$value->getQueryString();
                if(is_null($value)) return "$prefixe$key IS NULL";
                if(is_array($value)) return "$prefixe$key = ".implode(" ",$value);
                if($use_secure) return "$prefixe$key = ".self::protegeParam($value);
                throw new \Exception("unprotected parameter");
//                return "$key = '".self::escape($value)."'"; // todo : remplacer ça !!
            },array_keys($conditions),array_values($conditions)));
        }
    }

    public static function protegeRequete($req,$params = null) {

        if(is_array($params)) {
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
        } else {
            $parameters = [$params];
        }

        // remplacement des paramètres ?
        $iparam=0;
        $req =  preg_replace_callback('/\?/',
            function($dummy) use (&$parameters,&$iparam) {
                if(!empty($parameters)) {
                    $p=$parameters[min($iparam,count($parameters)-1)];
                    $iparam++;
                    return self::protegeParam($p);
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

    /**
     * encode un chaine en hexadécimal
     * @param $string
     * @return string
     */
    public static function stringtohex($string)
    {
        $res=unpack('H*', $string);
        return '0x'.$res[1];
    }

    /**
     * renvoie le hash limité à un entier 32 bits d'une chaine
     * @param $str
     * @return number
     */
    public static function getHash32($str)
    {
        return self::hashToInt(md5($str));

    }

    /**
     * réduit un hash (md5) à un entier sur 32 bits
     * @param $hash
     * @return number
     */
    public static function hashToInt($hash) {
        return hexdec("0x".substr($hash,0,8));
    }


}