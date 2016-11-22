<?php
/**
 * Created by PhpStorm.
 * User: raph
 * Date: 30/08/16
 * Time: 09:58
 */

namespace Efrogg\Db\Migration;


use Efrogg\Db\Adapters\DbAdapter;
use Efrogg\Db\Adapters\DbResultAdapter;
use Efrogg\Db\Exception\DbException;

class Table
{

    /**
     * @var string
     */
    protected $table_name;

    /**
     * @var DbAdapter
     */
    protected $db;

    /**
     * MigrationTable constructor.
     * @param $table_name
     */
    public function __construct($table_name)
    {
        $this->table_name = $table_name;
    }


    public function exists() {
        static $exists = null;
        if(null === $exists) {
            $exists=(bool)$this -> db -> execute("SHOW TABLES LIKE '".$this->table_name."'") -> fetch();
        }
        return $exists;
    }

    public function create($createString) {
        if(!$this->exists()) {
            try {
                $res = $this->db->execute($createString);
                if($res -> isValid()) {
                    var_dump($res->getErrorMessage());
                    // everything is ok
                } else {
                    var_dump($res->getErrorMessage());
                    // TODO : erreur ?
                }
            } catch(DbException $e) {
                var_dump($e);
            }
        } else {
            // TODO : erreur ?
        }
        return $this;
    }

    public function delete() {
        if($this -> exists()) {
            $sql = "DROP TABLE `".$this->table_name."`";
            $this -> db -> execute($sql);
        }
            // TODO : erreur ?
    }

    public function truncate() {
            // TODO : erreur ?
    }

    public function removeColumn($columnName) {
        if($this->exists() && $this->columnExists($columnName)) {
            $sql = "ALTER TABLE `".$this->table_name."` DROP `$columnName` ";
            $res = $this -> db -> execute($sql);
            return $res->isValid();
        }
        return true;
    }
    public function addColumn($columnName,ColumnType $columnType,Key $keyType = null) {
        if($this->exists() && !$this->columnExists($columnName)) {
            $sql = "ALTER TABLE `".$this->table_name."` ADD `$columnName` ".$columnType->toSql();
            $res = $this -> db -> execute($sql);
            if(!$res->isValid()) return false;
            if(!is_null($keyType)) {
                return $this -> addIndex($columnName,$keyType);
            }
            return $res->isValid();
        }
        return true;
    }

    public function setDb(DbAdapter $db)
    {
        $this -> db = $db;
    }

    protected function columnExists($columnName)
    {
        $column = $this -> db
            -> execute("SHOW COLUMNS FROM `".$this->table_name."` LIKE '$columnName'")
            ->fetch();
        return (bool)$column;
    }

    protected function addIndex($index_name, Key $keyType,$columns=null)
    {
        if($this->exists() && !$this->columnExists($index_name)) {
            if(null===$columns) $columns=$index_name;
            $sql = "ALTER TABLE `".$this->table_name."` ADD $keyType `$index_name` (".$columns.")";
            $res = $this -> db -> execute($sql);
            return $res->isValid();
        }
        return true;
    }
}