<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

include_once('../model/toursCategories.php');

$methods = $_SERVER['REQUEST_METHOD'];

switch ($methods) {
    case 'GET':
        $path = explode('=', $_SERVER['REQUEST_URI']);

        $objToursCategories = new ToursCategories();

        if (isset($path[1]) && is_numeric($path[1])) {
            $payload = new stdClass;
            $payload->id = $path[1];
            $result = $objToursCategories->fetchToursCategoriesById($payload);
        } else
            $result = $objToursCategories->fetchToursCategories();

        echo json_encode($result);
        break;

    default:
        # code...
        break;
}

?>