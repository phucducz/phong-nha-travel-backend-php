<?php

ini_set('display_errors', '1');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

include_once('../model/cart.php');

$methods = $_SERVER['REQUEST_METHOD'];
$objParam = null;
$url_components = parse_url($_SERVER['REQUEST_URI']);
if (isset($url_components['query'])) {
    $arrParam = [];
    parse_str($url_components['query'], $params);

    $arrParam = [$params];
    foreach ($arrParam as $object)
        $objParam = $object;
}

switch ($methods) {
    case 'GET':
        $objCart = new Cart();

        if (isset($objParam['userId']))
            $resultFetch = $objCart->get_list_cart($objParam['userId']);

        echo json_encode($resultFetch);
        break;

    case 'POST':
        $payload = json_decode(file_get_contents('php://input'));
        $objCart = new Cart();

        if ($payload->type === 'add')
            $result = $objCart->insert_cart($payload);
        else if ($payload->type === 'update')
            $result = $objCart->update_cart_coupon_id($payload);

        echo json_encode($result);
        break;

    case "DELETE":
        $objCart = new Cart();
        $result;

        if(isset($objParam['id']))
            $result = $objCart->delete_cart_item($objParam['id']);

        echo json_encode($result);
        break;

    case "PUT":
        $payload = json_decode(file_get_contents('php://input'));
        $objCart = new Cart();
        $result;

        if(isset($payload)) 
            $result = $objCart->update_cart_item($payload);

        echo json_encode($result);
        break;
}
?>