<?php
/**
 * User: tothm
 * Date: 05-Aug-19
 */

use utils\Router;

require_once 'utils/Router.php';



Router::route($_SERVER['REQUEST_URI']);