<?php
/**
 * User: tothm
 * Date: 05-Aug-19
 */

namespace api\orm;
require_once 'DBInterface.php';


use mysqli;
use function mysqli_num_rows;

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

    }

    public function insert($tableName, $columns, $values){

    }

    public function update($tableName, $columns, $values, $conditions){

    }

    public function select($tableName, $columns, $conditions, $limit, $offset){

    }

    public function delete($tableName, $conditions){

    }

    public function fetchFields($tableName){

    }

    public function checkTables(){

        if(mysqli_num_rows($this->mysqli->query("SHOW TABLES LIKE '" . MySqlAdapter::USERS . "''")) == 0)
            $this->createUsers();
        if(mysqli_num_rows($this->mysqli->query("SHOW TABLES LIKE '" . MySqlAdapter::SERVICES . "''")) == 0)
            $this->createServices();
        if(mysqli_num_rows($this->mysqli->query("SHOW TABLES LIKE '" . MySqlAdapter::SUBSCRIPTIONS . "''")) == 0)
            $this->createSubscriptions();


    }

    private function createUsers(){
        $this->mysqli->query("
            CREATE TABLE " . MySqlAdapter::USERS ." (
                user_id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30) NOT NULL,
                email VARCHAR(30) NOT NULL
            )
        ");

    }

    private function createServices(){
        $this->mysqli->query("
            CREATE TABLE " . MySqlAdapter::SERVICES ." (
                service_id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                service VARCHAR(30) NOT NULL,
                min_duration int(8),
                price int(20)
            )
        ");

    }

    private function createSubscriptions(){
        $this->mysqli->query("
            CREATE TABLE " . MySqlAdapter::SUBSCRIPTIONS ." (
                subcription_id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id INT(8),
                service_id INT(8),
                FOREIGN KEY (user_id) REFERENCES " . MySqlAdapter::USERS ." (user_id),
                FOREIGN KEY (service_id) REFERENCES " . MySqlAdapter::SERVICES ." (service_id)
            )
        ");

    }
}