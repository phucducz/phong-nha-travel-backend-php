<?php

ini_set('display_errors', '1');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

include_once('../model/fetchAPI.php');
include_once('../model/bookDetails.php');

$methods = $_SERVER['REQUEST_METHOD'];

switch ($methods) {
    case 'GET':
        $path = explode('=', $_SERVER['REQUEST_URI']);
        $objFetchAPI = new FetchAPI();

        if (isset($path[1]) && is_numeric($path[1]))
            $resultFetch = $objFetchAPI->fetchTourBookedByUserId($path[1]);
        else
            $resultFetch = $objFetchAPI->fetchBookedTour();

        echo json_encode($resultFetch);
        break;

    case 'POST':
        $option = json_decode(file_get_contents('php://input'));
        $result = "";
        $bookDetails = new BookDetails();
        
        $result = $bookDetails->insertBookDetails($option);

        echo json_encode($result);
        break;

    case "DELETE":
        $path = explode('=', $_SERVER['REQUEST_URI']);

        if (isset($path[1]) && is_numeric($path[1])) {
            $objBookDetails = new BookDetails();

            $data = new stdClass;
            $data->id = $path[1];
            $result = $objBookDetails->deleteBookedDetails($data);
        }

        echo json_encode($result);
        break;
}
?>