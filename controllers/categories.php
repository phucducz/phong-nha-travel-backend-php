<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

include_once('../model/categories.php');

$methods = $_SERVER['REQUEST_METHOD'];

switch ($methods) {
    case 'GET':
        $objCategories = new Categories();
        $result = $objCategories->fetchCategories();

        echo json_encode($result);
        break;
    
    default:
        # code...
        break;
}
?>