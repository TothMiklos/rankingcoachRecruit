<?php
/**
 * User: tothm
 * Date: 05-Aug-19
 */

use api\Service;
use api\Subscription;
use api\User;
use api\orm\MySqlAdapter;
use utils\Router;

require_once 'utils/Router.php';
require_once 'api/orm/MySqlAdapter.php';
require_once 'api/User.php';
require_once 'api/Subscription.php';
require_once 'api/Service.php';

$config = file_get_contents(__DIR__ . "/.conf");
$configs = array();
$configs = explode(",",$config);
$host = (isset($configs[1])) ? $configs[1] : null;
$username = (isset($configs[2])) ? $configs[2] : null;
$password = (isset($configs[3])) ? $configs[3] : null;
$dbName = (isset($configs[4])) ? $configs[4] : null;
$port = (isset($configs[5])) ? $configs[5] : 3308;
$socket = (isset($configs[6])) ? $configs[6] : null;


$dataBase = MySqlAdapter::getInstance($host, $username, $password, $dbName, $port, $socket);



Router::route($_SERVER['REQUEST_URI']);