<?php
/**
 * User: tothm
 * Date: 05-Aug-19
 */

use api\orm\MySqlAdapter;
use utils\Router;

require_once 'utils/Router.php';
require_once 'api/orm/MySqlAdapter.php';


$dataBase = new MySqlAdapter("localhost", "rest_api", "CRUD_PASS_19", "t_miklos", 3308 );
$dataBase->connect();
$dataBase->checkTables();


Router::route($_SERVER['REQUEST_URI']);