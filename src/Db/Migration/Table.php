<?php
/**
 * Created by PhpStorm.
 * User: raph
 * Date: 30/08/16
 * Time: 09:58
 */

namespace efrogg\Db\Migration;


use efrogg\Db\Adapters\DbAdapter;
use efrogg\Db\Adapters\DbResultAdapter;
use efrogg\Db\Exception\DbException;

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
        $result = $this -> db -> execute("SHOW TABLES LIKE '".$this->table_name."'") -> fetch();
        return (bool)$result;
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
        echo "todo : removeColumn $columnName";
    }
    public function addColumn($columnName,ColumnType $columnType,Key $keyType = null) {
        if(!$this->columnExists($columnName)) {
            $sql = "ALTER TABLE `".$this->table_name."` ADD `$columnName` ".$columnType->toSql();
            $this -> db -> execute($sql);
            //TODO : erreur
            if(!is_null($keyType)) {
                $this -> addKey($columnName,$keyType);
            }
        }
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

    private function addKey($columnName, Key $keyType)
    {
        echo "TODO : add key";
        //TODO
    }
}