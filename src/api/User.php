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

require_once "Api.php";

class User extends Api {

    const TABLE = "users";
    const FIELDS = array(
        "name" => "VARCHAR(30) NOT NULL",
        "email" => "VARCHAR(30) NOT NULL",
        "birth_date" => "VARCHAR(30)",
    );


    public static function update($columns, $values, $table, $id){

        foreach ($columns as $column) {
            if (!in_array($column, array_keys(self::FIELDS)) || $column == "birth_date") {
                return false;
            }
        }

        $dataBase = MySqlAdapter::getInstance();

        return $dataBase->update(self::TABLE, $columns, $values, $id);
    }



}