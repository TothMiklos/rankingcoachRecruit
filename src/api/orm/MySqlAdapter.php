<?php
/**
 * User: tothm
 * Date: 05-Aug-19
 */

namespace api\orm;
require_once 'DBInterface.php';
require_once '../api/User.php';
require_once '../api/Service.php';
require_once '../api/Subscription.php';


use api\Service;
use api\Subscription;
use api\User;
use mysqli;
use function mysqli_close;
use function mysqli_num_rows;
use function sizeof;

class MySqlAdapter implements DBInterface {

    private $host;
    private $username;
    private $password;
    private $dbName;
    private $port;
    private $socket;
    private $mysqli;

    private static $instance = null;

    public static function getInstance($host = "localhost", $username = "rest_api", $password = "CRUD_PASS_19", $dbName = "t_miklos", $port = 3308, $socket = null) {
        if (self::$instance == null) {
            self::$instance = new MySqlAdapter($host, $username, $password, $dbName, $port, $socket);
        }

        return self::$instance;
    }


    private function __construct($host, $username, $password, $dbName, $port = null, $socket = null){
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbName = $dbName;
        $this->port = $port;
        $this->socket = $socket;

        $this->connect();
        $this->checkTables();
    }


    public function connect(){
        $this->mysqli = new mysqli($this->host, $this->username, $this->password, $this->dbName, $this->port, $this->socket);
        if ($this->mysqli->connect_error)
            die("MySQL DB connection failed: " . $this->mysqli->connect_error);

    }

    public function disconnect(){
        mysqli_close($this->mysqli);
    }

    public function create($tableName, $columns, $values){
        $sql = "INSERT INTO " . $tableName . " (";
        for ($i = 0; $i < sizeof($columns); $i++) {
            $sql .= $columns[$i];
            if ($i + 1 < sizeof($columns)){
                $sql .=", ";
            }
        }
        $sql .= ") VALUES (";
        for ($i = 0; $i < sizeof($values); $i++) {
            $sql .= $values[$i];
            if ($i + 1 < sizeof($values)){
                $sql .=", ";
            }
        }
        $sql .= ")";

        return $this->mysqli->query($sql);
    }

    public function update($tableName, $columns, $values, $id){
        if (sizeof($columns) != sizeof($values)){
            return false;
        }
        $sql = "UPDATE " . $tableName . " SET ";
        for ($i = 0; $i < sizeof($columns); $i++) {
            $sql .= $columns[$i] . "=" . $values[$i];
            if ($i + 1 < sizeof($columns)){
                $sql .=", ";
            }
        }
        $sql .=" WHERE id=" . $id;

//        echo "<br>".$sql."<br>";
        return $this->mysqli->query($sql);
    }

    public function get($tableName, $columns = null, $conditions = null, $limit = null, $offset = null){
        $sql = "SELECT ";
        if ($columns) {
            for ($i = 0; $i < sizeof($columns); $i++) {
                $sql .= $columns[$i];
                if ($i + 1 < sizeof($columns)){
                    $sql .= ",";
                }
            }
        } else {
            $sql .= "*";
        }
        $sql .= " FROM " . $tableName;
        if ($conditions) {
            $sql .= " WHERE ";
            $i = 0;
            foreach ($conditions as $key => $value) {
                $sql .= $key . "=" .$value;
                if (++$i != sizeof($conditions)) {
                    $sql .= " AND ";
                }
            }
        }
        if ($limit) {
            $sql .= " LIMIT " . $limit;
            if ($offset) {
                $sql .= ", " . $offset;
            }
        }

        return $this->mysqli->query($sql);

    }

    public function delete($tableName, $id){
        $sql = "DELETE FROM " .$tableName . " WHERE id=" . $id;

        return ($this->mysqli->query($sql) != null) && ($this->mysqli->affected_rows > 0);
    }

    public function createTable($tableName, $columns){
        $sql = "CREATE TABLE " .$tableName . " ( id int(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ";
        $i = 0;
        foreach ($columns as $key => $value) {
            $sql .= $key . " " . $value;
            if (++$i < sizeof($columns)) {
                $sql .= ", ";
            }
        }
        $sql .= ")";

        return $this->mysqli->query($sql);
    }


    public function fetchFields($tableName){
        $resultQuery = $this->mysqli->query(" SHOW COLUMNS FROM " . $tableName);
        $i = 0;
        $result = array();
        while ($row = $resultQuery->fetch_row()) {
            $result[$i++] = $row[0];
        }

        return $result;
    }

    private function checkTables(){
        if(mysqli_num_rows($this->mysqli->query("SHOW TABLES LIKE '" . User::TABLE . "'")) == 0)
            $this->createTable(User::TABLE, User::FIELDS);

        if(mysqli_num_rows($this->mysqli->query("SHOW TABLES LIKE '" . Service::TABLE . "'")) == 0)
            $this->createTable(Service::TABLE, Service::FIELDS);

        if(mysqli_num_rows($this->mysqli->query("SHOW TABLES LIKE '" . Subscription::TABLE . "'")) == 0)
            $this->createTable(Subscription::TABLE, Subscription::FIELDS);


    }

}