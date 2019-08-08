<?php
/**
 * User: tothm
 * Date: 08-Aug-19
 */

namespace api;


use api\orm\MySqlAdapter;
use function array_keys;
use function array_slice;
use function array_values;
use function var_dump;

class Api {


    public static function create($columns, $values, $fields, $table){

        foreach ($columns as $column) {
            if (!in_array($column, array_keys($fields))) {
                return false;
            }
        }

        $dataBase = MySqlAdapter::getInstance();

        $fields = array_keys($fields);

        return $dataBase->create($table, array_slice(array_values($fields), 0,4), $values);
    }

    public static function update($columns, $values, $table, $id){

        $dataBase = MySqlAdapter::getInstance();

        return $dataBase->update($table, $columns, $values, $id);
    }

    public static function get($table, $columns = null, $conditions = null, $limit = null, $offset = null){
        $dataBase = MySqlAdapter::getInstance();

        return $dataBase->get($table, $columns, $conditions, $limit, $offset);
    }

    public static function delete($table, $id){
        if (!is_int($id)) {
            return false;
        }

        $dataBase = MySqlAdapter::getInstance();

        return $dataBase->delete($table, $id);
    }
}