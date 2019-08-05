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
                //TODO handle account create
                break;
            case '/account/update':
                echo "account update";
                //TODO handle account update
                break;
            case '/account/delete':
                echo "account delete";
                //TODO handle account delete
                break;
            case '/account/get':
                echo "account get";
                //TODO handle account get
                break;
            case '/subscription/create':
                echo "subscription create";
                //TODO handle subscription create
                break;
            case '/subscription/update':
                echo "subscription update";
                //TODO handle subscription update
                break;
            case '/subscription/get':
                echo "subscription get";
                //TODO handle subscription get
                break;
            default:
                echo "404 not found";
                //TODO handle bad uris
                break;
        }
    }

}