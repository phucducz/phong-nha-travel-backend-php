<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

include_once('../model/paymentMethod.php');

$methods = $_SERVER['REQUEST_METHOD'];
switch ($methods) {
    case 'GET':
        $objPayment = new PaymentMethod;
        $result = $objPayment->getListPayment();

        echo json_encode($result);
        break;

    default:
        # code...
        break;
}

?>