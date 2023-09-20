<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

include_once('../model/fetchAPI.php');

$methods = $_SERVER['REQUEST_METHOD'];
switch($methods) {
    case "GET":
        $path = explode('=', $_SERVER['REQUEST_URI']);
        $objFetch = new FetchAPI();

        if(isset($path[1]) && is_numeric($path[1])) {
            $payload = new stdClass;
            $payload->id = $path[1];

            $resultFetch = $objFetch->fetchTopicById($payload);
        }
        else
            $resultFetch = $objFetch->fetchTopic();

        echo json_encode($resultFetch);
        break;
}
?>