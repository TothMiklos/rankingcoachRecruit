<?php
/**
 * User: tothm
 * Date: 05-Aug-19
 */

namespace api\orm;


interface DBInterface {

    function connect();

    function disconnect();

    function create($tableName, $columns, $values);

    function update($tableName, $columns, $values, $id);

    function get($tableName, $columns, $conditions, $limit, $offset);

    function delete($tableName, $conditions);

    function fetchFields($tableName);


}