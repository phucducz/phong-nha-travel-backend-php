<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

include_once('../model/checkoutsDetail.php');

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
        $result;
        
        if (isset($objParam['userId'])) {
            $objCheckoutsDetail = new CheckoutsDetail();
            $result = $objCheckoutsDetail->get_info_checkouts_detail_user($objParam['userId']);
        }

        echo json_encode($result);
        break;

    case 'POST':
        $payload = json_decode(file_get_contents('php://input'));
        $result;

        if (isset($payload)) {
            $objCheckoutsDetail = new CheckoutsDetail();
            $result = $objCheckoutsDetail->insert_checkouts_detail_first($payload);
        }

        echo json_encode($result);
        break;

    default:
        # code...
        break;
}

?>