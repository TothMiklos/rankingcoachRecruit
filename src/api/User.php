<?php
/**
 * User: tothm
 * Date: 08-Aug-19
 */

namespace api;


use api\orm\MySqlAdapter;
use function array_keys;
use function in_array;
use function is_int;

class User {

    const TABLE = "users";
    const FIELDS = array(
        "name" => "VARCHAR(30) NOT NULL",
        "email" => "VARCHAR(30) NOT NULL",
        "birth_date" => "VARCHAR(30)",
    );



    public static function create($columns, $values){

        foreach ($columns as $column) {
            if (!in_array($column, array_keys(self::FIELDS))) {
                return false;
            }
        }

        $dataBase = MySqlAdapter::getInstance();

        return $dataBase->create(self::TABLE, array_keys(self::FIELDS), $values);
    }

    public static function update($columns, $values, $id){

        foreach ($columns as $column) {
            if (!in_array($column, array_keys(self::FIELDS)) || $column == "birth_date") {
                return false;
            }
        }

        $dataBase = MySqlAdapter::getInstance();

        return $dataBase->update(self::TABLE, $columns, $values, $id);
    }

    public static function get($columns = null, $conditions = null, $limit = null, $offset = null){
        $dataBase = MySqlAdapter::getInstance();

        return $dataBase->get(self::TABLE, $columns, $conditions, $limit, $offset);
    }

    public static function delete($id){
        if (!is_int($id)) {
            return false;
        }

        $dataBase = MySqlAdapter::getInstance();

        return $dataBase->delete(self::TABLE, $id);
    }



}