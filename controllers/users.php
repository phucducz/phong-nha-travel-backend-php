<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

include_once('../model/fetchAPI.php');

$methods = $_SERVER['REQUEST_METHOD'];
switch ($methods) {
    case 'GET':
        $objFetchAPI = new FetchAPI();
        $result = $objFetchAPI->fetchUser();
        echo json_encode($result);
        break;
    
    default:
        # code...
        break;
}

?>