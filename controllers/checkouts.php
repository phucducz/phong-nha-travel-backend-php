<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

include_once('../model/checkouts.php');

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
    case 'POST':
        $payload = json_decode(file_get_contents('php://input'));
        $result;
        $objCheckouts = new Checkouts();

        if (isset($payload))
            $result = $objCheckouts->insert_checkouts($payload->userId);

        echo json_encode($result);
        break;

    case 'GET':
        $objCheckouts = new Checkouts();
        $resultFetch;

        if (isset($objParam))
            $resultFetch = $objCheckouts->get_exist_cart_items($objParam['userId']);

        echo json_encode($resultFetch);
        break;

    default:
        # code...
        break;
}
?>