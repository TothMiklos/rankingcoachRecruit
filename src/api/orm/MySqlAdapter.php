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
require_once '../logger/Subject.php';
require_once '../logger/Observer.php';


use api\Service;
use api\Subscription;
use api\User;
use function array_keys;
use function array_values;
use function file_get_contents;
use logger\observer\Observer;
use logger\observer\Subject;
use mysqli;
use function mysqli_close;
use function mysqli_num_rows;
use function sizeof;

class MySqlAdapter implements DBInterface, Subject {

    private $host;
    private $username;
    private $password;
    private $dbName;
    private $port;
    private $socket;
    private $mysqli;
    private $sql = "";
    private $observers = array();

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
        $this->sql = "INSERT INTO " . $tableName . " (";
        for ($i = 0; $i < sizeof($columns); $i++) {
            $this->sql .= $columns[$i];
            if ($i + 1 < sizeof($columns)){
                $this->sql .=", ";
            }
        }
        $this->sql .= ") VALUES (";
        for ($i = 0; $i < sizeof($values); $i++) {
            $this->sql .= $values[$i];
            if ($i + 1 < sizeof($values)){
                $this->sql .=", ";
            }
        }
        $this->sql .= ")";
        $this->notity();

        return $this->mysqli->query($this->sql);
    }

    public function update($tableName, $columns, $values, $id){
        if (sizeof($columns) != sizeof($values)){
            return false;
        }
        $this->sql = "UPDATE " . $tableName . " SET ";
        for ($i = 0; $i < sizeof($columns); $i++) {
            $this->sql .= $columns[$i] . "=" . $values[$i];
            if ($i + 1 < sizeof($columns)){
                $this->sql .=", ";
            }
        }
        $this->sql .=" WHERE id=" . $id;
        $this->notity();

        return $this->mysqli->query($this->sql);
    }

    public function get($tableName, $columns = null, $conditions = null, $limit = null, $offset = null){
        $this->sql = "SELECT ";
        if ($columns) {
            for ($i = 0; $i < sizeof($columns); $i++) {
                $this->sql .= $columns[$i];
                if ($i + 1 < sizeof($columns)){
                    $this->sql .= ",";
                }
            }
        } else {
            $this->sql .= "*";
        }
        $this->sql .= " FROM " . $tableName;
        if ($conditions) {
            $this->sql .= " WHERE ";
            $i = 0;
            foreach ($conditions as $key => $value) {
                $this->sql .= $key . "=" .$value;
                if (++$i != sizeof($conditions)) {
                    $this->sql .= " AND ";
                }
            }
        }
        if ($limit) {
            $this->sql .= " LIMIT " . $limit;
            if ($offset) {
                $this->sql .= ", " . $offset;
            }
        }
        $this->notity();

        return $this->mysqli->query($this->sql);

    }

    public function delete($tableName, $id){
        $this->sql = "DELETE FROM " .$tableName . " WHERE id=" . $id;
        $this->notity();

        return ($this->mysqli->query($this->sql) != null) && ($this->mysqli->affected_rows > 0);
    }

    public function createTable($tableName, $columns){
        $this->sql = "CREATE TABLE " .$tableName . " ( id int(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ";
        $i = 0;
        foreach ($columns as $key => $value) {
            $this->sql .= $key . " " . $value;
            if (++$i < sizeof($columns)) {
                $this->sql .= ", ";
            }
        }
        $this->sql .= ")";
        $this->notity();

        return $this->mysqli->query($this->sql);
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

        if(mysqli_num_rows($this->mysqli->query("SHOW TABLES LIKE '" . Service::TABLE . "'")) == 0) {
            $this->createTable(Service::TABLE, Service::FIELDS);
            $file = file_get_contents(__DIR__ . "\..\..\services.txt");
            $data = json_decode($file, true);
            foreach ($data as $row) {
                Service::create(array_keys($row), array_values($row), Service::FIELDS, Service::TABLE);
            }
        }

        if(mysqli_num_rows($this->mysqli->query("SHOW TABLES LIKE '" . Subscription::TABLE . "'")) == 0)
            $this->createTable(Subscription::TABLE, Subscription::FIELDS);


    }

    public function attach(Observer $observer){
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer){
        for ($i = 0; $i < sizeof($this->observers); $i++){
            if ($this->observers[$i] == $observer){
                unset($this->observers[$i]);
                return;
            }
        }
    }

    public function notity(){
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function message(){
        return $this->sql;
    }

}