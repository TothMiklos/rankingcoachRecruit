<?php
/**
 * User: tothm
 * Date: 08-Aug-19
 */

namespace api;
require_once "User.php";
require_once "Service.php";


class Subscription {

    const TABLE = "subscriptions";
    const FIELDS = array(
        "user_id" =>  "int(8)",
        "service_id" =>  "int(8)",
        "FOREIGN KEY (user_id)" => "REFERENCES " . User::TABLE ." (id)",
        "FOREIGN KEY (service_id)" => "REFERENCES " . Service::TABLE ." (id)",
    );




}