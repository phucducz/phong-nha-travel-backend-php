<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

include_once('../model/tour.php');
include_once('../model/fetchAPI.php');

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
        $objTour = new ModelTour();

        if (isset($objParam['id'])) {
            if (is_numeric($objParam['id']))
                $resultFetch = $objTour->fetchTourById($objParam['id']);
        } else if (isset($objParam['page'])) {
            if ($objParam['page'] == 'admin')
                $resultFetch = $objTour->fetchTour();
        } else if (isset($objParam['type'])) {
            if ($objParam['type'] == 'search-other')
                $resultFetch = $objTour->find_tours_other($objParam['payload']);
            else if ($objParam['type'] == 'search') {
                // admin
                // $objFetch = new FetchAPI();
                // $payload = new stdClass;
                // $payload->name = $objParam['name'];
                // $resultFetch = $objFetch->searchTour($payload);

                // user
                $resultFetch = $objTour->find_tours($objParam['payload']);
            } else if ($objParam['type'] == 'order_most')
                $resultFetch = $objTour->fetchToursOrderMost();
            else if ($objParam['type'] == 'hot')
                $resultFetch = $objTour->fetchToursHot();
            else if ($objParam['type'] == 'view') {
                $payload = new stdClass;
                
                if (isset($objParam['tourId']))
                    $payload->tourId = $objParam['tourId'];
                
                $resultFetch = $objTour->viewTour($payload);
            }
        } else if (isset($objParam['categoryName']))
            $resultFetch = $objTour->fetch_tour_by_category($objParam['categoryName']);
        else if (isset($objParam['q']) && $objParam['q'] == 'hot_order')
            $resultFetch = $objTour->fetchToursHotOrderMost();
        else
            $resultFetch = $objTour->fetchToursTopics();

        echo json_encode($resultFetch);

        break;

    case 'PUT':
        $payload = json_decode(file_get_contents('php://input'));

        $objTour = new ModelTour();
        $result = $objTour->updateTour($payload);

        echo json_encode($result);
        break;

    case 'DELETE':
        $path = explode('=', $_SERVER['REQUEST_URI']);

        $payload = new stdClass;
        $payload->id = $path[1];

        $objTour = new ModelTour();
        $result = $objTour->deleteTour($payload);

        echo json_encode($result);

        break;


    case 'POST':
        $payload = json_decode(file_get_contents('php://input'));
        $dataCheckout = new stdClass;
        $result = null;

        if ($payload->type == 'prepareData') {
            $result = new stdClass;

            $name = explode(' ', $payload->fullName);
            $dataCheckout->fristName = $name[0];
            $dataCheckout->lastName = $name[1];

            $dataCheckout->emailAddress = $payload->emailAddress;
            $dataCheckout->time = $payload->time;
            $dataCheckout->quantity = $payload->quantity;
            $dataCheckout->phoneNumber = $payload->phoneNumber;

            $result = $dataCheckout;
        } else if ($payload->type == 'getData') {
            $result = $dataCheckout;
        } else {
            $objTour = new ModelTour();
            $result = $objTour->insertTour($payload);
        }

        echo json_encode($result);

        break;
}

?>