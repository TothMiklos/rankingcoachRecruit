<?php
/**
 * User: tothm
 * Date: 08-Aug-19
 */

namespace api;
require_once "User.php";
require_once "Service.php";
require_once "Api.php";


class Subscription extends Api {

    const TABLE = "subscriptions";
    const FIELDS = array(
        "user_id" =>  "int(8)",
        "service_id" =>  "int(8)",
        "start_date" =>  "VARCHAR(30)",
        "end_date" =>  "VARCHAR(30)",
        "FOREIGN KEY (user_id)" => "REFERENCES " . User::TABLE ." (id)",
        "FOREIGN KEY (service_id)" => "REFERENCES " . Service::TABLE ." (id)",
    );




}