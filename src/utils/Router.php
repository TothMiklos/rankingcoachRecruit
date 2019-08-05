<?php
/**
 * User: tothm
 * Date: 05-Aug-19
 */

namespace utils;


class Router {

    public static function route($uri){
        switch ($uri) {
            case '/account/create':
                echo "account create";
                break;
            case '/account/update':
                echo "account update";
                break;
            case '/account/delete':
                echo "account delete";
                break;
            case '/account/get':
                echo "account get";
                break;
            case '/subscription/create':
                echo "subscription create";
                break;
            case '/subscription/update':
                echo "subscription update";
                break;
            case '/subscription/get':
                echo "subscription get";
                break;
            default:
                echo "404 not found";
                break;
        }
    }

}