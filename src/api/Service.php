<?php
/**
 * User: tothm
 * Date: 08-Aug-19
 */

namespace api;


class Service {

    const TABLE = "services";
    const FIELDS = array(
        "service" => "VARCHAR(30) NOT NULL",
        "min_duration" => "int(8)",
        "price" => "int(20)",
    );




}