<?php
/**
 * User: tothm
 * Date: 05-Aug-19
 */

namespace utils;


use api\Subscription;
use api\User;
use function array_keys;
use function array_values;
use function file_get_contents;
use function json_decode;
use function json_encode;
use function var_dump;

class Router {

    public static function route($uri){
        switch ($uri) {
            case '/account/create/':
                if ($_SERVER["REQUEST_METHOD"] != "POST") {
                    http_response_code(404);
                    break;
                }
                $data = json_decode(file_get_contents('php://input'), true);
                $columns = array_keys($data);
                $values = array_values($data);

                if(User::create($columns, $values, User::FIELDS, User::TABLE)) {
                    http_response_code(200);
                } else {
                    http_response_code(404);
                }

                break;


            case '/account/update/':
                if ($_SERVER["REQUEST_METHOD"] != "POST") {
                    http_response_code(404);
                    break;
                }
                $data = json_decode(file_get_contents('php://input'), true);
                $id = (isset($data["id"])) ? $data["id"] : null;
                unset($data["id"]);
                $columns = array_keys($data);
                $values = array_values($data);

                if(User::update($columns, $values, User::TABLE, $id)) {
                    http_response_code(200);
                } else {
                    http_response_code(404);
                }

                break;


            case '/account/delete/':
                if ($_SERVER["REQUEST_METHOD"] != "DELETE") {
                    http_response_code(404);
                    break;
                }
                $data = json_decode(file_get_contents('php://input'), true);
                $id = (isset($data["id"])) ? $data["id"] : null;

                if(User::delete(User::TABLE, $id)) {
                    http_response_code(200);
                } else {
                    http_response_code(404);
                }

                break;


            case '/account/get/':
                if ($_SERVER["REQUEST_METHOD"] != "GET") {
                    http_response_code(404);
                    break;
                }
                $data = json_decode(file_get_contents('php://input'), true);
                $columns = (isset($data["columns"])) ? $data["columns"] : null;
                $conditions = (isset($data["conditions"])) ? $data["conditions"] : null;
                $limit = (isset($data["limit"])) ? $data["limit"] : null;
                $offset = (isset($data["offset"])) ? $data["offset"] : null;

                $result = User::get( User::TABLE, $columns, $conditions, $limit, $offset);
                if($result) {
                    http_response_code(200);
                    header('Content-type: application/json');

                    $resultArray = array();
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)){
                        $resultArray[] = $row;
                    }

                    echo json_encode($resultArray);
                } else {
                    http_response_code(404);
                }

                break;


            case '/subscription/create/':
                if ($_SERVER["REQUEST_METHOD"] != "POST") {
                    http_response_code(404);
                    break;
                }
                $data = json_decode(file_get_contents('php://input'), true);
                $columns = array_keys($data);
                $values = array_values($data);

                if(Subscription::create($columns, $values, Subscription::FIELDS, Subscription::TABLE)) {
                    http_response_code(200);
                } else {
                    http_response_code(404);
                }

                break;


            case '/subscription/update/':
                if ($_SERVER["REQUEST_METHOD"] != "POST") {
                    http_response_code(404);
                    break;
                }
                $data = json_decode(file_get_contents('php://input'), true);
                $id = (isset($data["id"])) ? $data["id"] : null;
                unset($data["id"]);
                $columns = array_keys($data);
                $values = array_values($data);

                if(Subscription::update($columns, $values, Subscription::TABLE, $id)) {
                    http_response_code(200);
                } else {
                    http_response_code(404);
                }

                break;


            case '/subscription/get/':
                if ($_SERVER["REQUEST_METHOD"] != "GET") {
                    http_response_code(404);
                    break;
                }
                $data = json_decode(file_get_contents('php://input'), true);
                $columns = (isset($data["columns"])) ? $data["columns"] : null;
                $conditions = (isset($data["conditions"])) ? $data["conditions"] : null;
                $limit = (isset($data["limit"])) ? $data["limit"] : null;
                $offset = (isset($data["offset"])) ? $data["offset"] : null;

                $result = Subscription::get(Subscription::TABLE, $columns, $conditions, $limit, $offset);
                if($result) {
                    http_response_code(200);
                    header('Content-type: application/json');

                    $resultArray = array();
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)){
                        $resultArray[] = $row;
                    }

                    echo json_encode($resultArray);
                } else {
                    http_response_code(404);
                }

                break;


            default:
                http_response_code(404);
                break;
        }
    }

}