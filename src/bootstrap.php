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


$dataBase = MySqlAdapter::getInstance();

//User::create(array("name", "email", "birth_date"), array("'aaa1'", "'bbb1'", "'01-01-1981'"));
//User::create(array("name", "email", "birth_date"), array("'aaa2'", "'bbb2'", "'02-02-1982'"));
//User::update(array("name", "email"), array("'xxxx'", "'yyyy'"), 2);


//echo $dataBase->createTable(User::TABLE, User::FIELDS) . "<br>";
//echo $dataBase->createTable(Subscription::TABLE, Subscription::FIELDS) . "<br>";
//echo $dataBase->createTable(Service::TABLE, Service::FIELDS) . "<br>";


//echo "<br>" . var_dump(User::FIELDS) . "<br>";
//echo "<br>" . var_dump(Subscription::FIELDS) . "<br>";
//echo "<br>" . var_dump(Service::FIELDS) . "<br>";


Router::route($_SERVER['REQUEST_URI']);