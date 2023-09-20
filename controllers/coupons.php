<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

include_once('../model/coupons.php');

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
        $objCoupon = new Coupons();

        if (isset($objParam)) {
            if (isset($objParam['couponCode']))
                $resultFetch = $objCoupon->fetch_coupon_by_code($objParam['couponCode']);
            else if (isset($objParam['id']))
                $resultFetch = $objCoupon->fetch_coupon_by_id($objParam['id']);
        } else
            $resultFetch = $objCoupon->fetch_coupon();

        echo json_encode($resultFetch);
        break;

    case 'POST':
        $payload = json_decode(file_get_contents('php://input'));
        $result;

        if (isset($payload)) {
            $objCoupon = new Coupons();

            $result = $objCoupon->checkCouponCode($payload->couponCode);
        }

        echo json_encode($result);

    default:
        # code...
        break;
}

?>