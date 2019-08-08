<?php
/**
 * User: tothm
 * Date: 05-Aug-19
 */

namespace utils;


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

                if(User::create($columns, $values)) {
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

                if(User::update($columns, $values, $id)) {
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

                if(User::delete($id)) {
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

                $result = User::get($columns, $conditions, $limit, $offset);
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
                echo "subscription create";
                //TODO handle subscription create
                break;


            case '/subscription/update/':
                echo "subscription update";
                //TODO handle subscription update
                break;


            case '/subscription/get/':
                echo "subscription get";
                //TODO handle subscription get
                break;


            default:
                echo "<br>404 not found";
                //TODO handle bad uris
                break;
        }
    }

}