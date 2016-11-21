<?php
/**
 * Created by PhpStorm.
 * User: raph
 * Date: 30/08/16
 * Time: 10:05
 */

namespace Efrogg\Db\Migration;


class ColumnType
{
    const NULL = "NULL";
    const NOT_NULL = "NOT NULL";

    const DEFAULT_NULL = "DEFAULT NULL";

    const TYPE_VARCHAR = "VARCHAR";
    const TYPE_INT = "INT";
    const TYPE_TINYINT = "TINYINT";
    /**
     * @var string
     * VARCHAR|INT
     */
    private $type;

    /**
     * @var string
     */
    private $length = null;

    /**
     * @var string
     */
    private $null;

    /**
     * @var string
     */
    private $default;

    /**
     * @var string
     */
    private $complement;

    /**
     * @var string
     */
    private $after;

    /**
     * ColumnType constructor.
     * @param string $type
     * @param string $length
     * @param string $null
     * @param string $default
     * @param string $complement
     * "VARCHAR",255,ColumnType::NOT_NULL,"DEFAULT ''"
     */
    public function __construct($type, $length, $null = self::NOT_NULL, $default='',$complement='',$after=null)
    {
        $this->type = $type;
        $this->length = $length;
        $this->null = $null;
        $this->default = $default;
        $this->complement = $complement;
        $this->after = $after;
    }

    public function toSql()
    {
        return $this->type.
        (is_null($this->length)?" ":"(".$this->length.") ").
        $this->null.' '.
        $this->default.' '.
        (is_null($this->after)?' ':'AFTER '.$this->after).
        $this->complement.' ';
    }

    /**
     * @param string $default
     * @return ColumnType
     */
    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }

    /**
     * @param string $complement
     * @return ColumnType
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;
        return $this;
    }

    /**
     * @param string $after
     * @return ColumnType
     */
    public function setAfter($after)
    {
        $this->after = $after;
        return $this;
    }

    /**
     * @param string $null
     * @return ColumnType
     */
    public function setNull($null)
    {
        $this->null = $null;
        return $this;
    }
}