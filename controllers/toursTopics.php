<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

include_once('../model/toursTopics.php');

$methods = $_SERVER['REQUEST_METHOD'];
switch ($methods) {
    case 'GET':
        $path = explode('=', $_SERVER['REQUEST_URI']);

        $objTopicsTours = new ToursTopics;
        $result;

        if(isset($path[1]) && is_numeric($path[1])) {
            $result = $objTopicsTours->fetchToursTopicsById($path[1]);
        }

        echo json_encode($result);
        break;
    
    default:
        # code...
        break;
}

?>