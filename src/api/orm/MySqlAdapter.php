<?php
/**
 * User: tothm
 * Date: 05-Aug-19
 */

namespace api\orm;
require_once 'DBInterface.php';


use mysqli;
use function mysqli_close;
use function mysqli_num_rows;
use function sizeof;

class MySqlAdapter implements DBInterface {

    const USERS = "users";
    const SERVICES = "services";
    const SUBSCRIPTIONS = "subscriptions";

    private $host;
    private $username;
    private $password;
    private $dbName;
    private $port;
    private $socket;
    private $mysqli;

    function __construct($host, $username, $password, $dbName, $port = null, $socket = null){
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbName = $dbName;
        $this->port = $port;
        $this->socket = $socket;

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

        return $this->mysqli->query($sql);
    }

    public function get($tableName, $columns = null, $conditions = null, $limit = -1, $offset = -1){
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
        if ($limit >= 0) {
            $sql .= " LIMIT " . $limit;
            if ($offset >= 0) {
                $sql .= ", " . $offset;
            }
        }

        echo $sql;

    }

    public function delete($tableName, $id){
        $sql = "DELETE FROM " .$tableName . " WHERE id=" . $id;

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

    public function checkTables(){
        if(mysqli_num_rows($this->mysqli->query("SHOW TABLES LIKE '" . MySqlAdapter::USERS . "'")) == 0)
            $this->createUsers();
        if(mysqli_num_rows($this->mysqli->query("SHOW TABLES LIKE '" . MySqlAdapter::SERVICES . "'")) == 0)
            $this->createServices();
        if(mysqli_num_rows($this->mysqli->query("SHOW TABLES LIKE '" . MySqlAdapter::SUBSCRIPTIONS . "'")) == 0)
            $this->createSubscriptions();


    }

    private function createUsers(){
        $this->mysqli->query("
            CREATE TABLE " . MySqlAdapter::USERS ." (
                id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30) NOT NULL,
                email VARCHAR(30) NOT NULL
            )
        ");

    }

    private function createServices(){
        $this->mysqli->query("
            CREATE TABLE " . MySqlAdapter::SERVICES ." (
                id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                service VARCHAR(30) NOT NULL,
                min_duration int(8),
                price int(20)
            )
        ");

    }

    private function createSubscriptions(){
        $this->mysqli->query("
            CREATE TABLE " . MySqlAdapter::SUBSCRIPTIONS ." (
                id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id INT(8),
                service_id INT(8),
                FOREIGN KEY (user_id) REFERENCES " . MySqlAdapter::USERS ." (id),
                FOREIGN KEY (service_id) REFERENCES " . MySqlAdapter::SERVICES ." (id)
            )
        ");

    }
}