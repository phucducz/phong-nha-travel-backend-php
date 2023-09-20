<?php

include_once('../config/Database.php');
include_once('../model/topics.php');
include_once('../function/functions.php');

class ModelTour
{
    private $conn;
    private $objConn;

    public function connect()
    {
        $objConn = new Database();
        $conn = $objConn->connectDb();

        return $conn;
    }

    public function fetchToursTopics()
    {
        $conn = $this->connect();

        $sql = "CALL sp_select_tours_topics";

        $result = mysqli_query($conn, $sql);
        $fetchTour = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if ($fetchTour)
            return $fetchTour;
        else
            return ['status: ' => 0, 'message: ' => 'Fecth failure!'];
    }

    public function fetchTour()
    {
        $conn = $this->connect();

        $sql = "CALL sp_select_tours";

        $result = mysqli_query($conn, $sql);
        $fetchTour = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if ($fetchTour)
            return $fetchTour;
        else
            return ['status: ' => 0, 'message: ' => 'Fecth failure!'];
    }

    public function fetchTourById($tourId)
    {
        $conn = $this->connect();

        $sql = "CALL sp_select_tour_id($tourId)";

        $result = mysqli_query($conn, $sql);
        $fetchTour = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($fetchTour)
            return $fetchTour;
        else
            return ['status: ' => 0, 'message: ' => 'Fecth failure!'];
    }

    public function fetchToursOrderMost()
    {
        $conn = $this->connect();

        $sql = "CALL sp_tours_order_most";

        if ($result = mysqli_query($conn, $sql))
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        else
            return ['status' => 0, 'message' => 'Fetch failure!'];
    }

    public function fetchToursHot()
    {
        $conn = $this->connect();

        $sql = "CALL sp_tours_hot";

        if ($result = mysqli_query($conn, $sql))
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        else
            return ['status' => 0, 'message' => 'Fetch failure!'];
    }

    public function viewTour($payload)
    {
        $conn = $this->connect();

        if (isset($payload->tourId))
            $sql = "SELECT t.*, i.image 
                    FROM tours AS t, images AS i
                    WHERE t.id = $payload->tourId AND t.id = i.tour_id AND i.isMain = 1
            ";
        else
            $sql = "SELECT t.*, i.image 
            FROM tours AS t, images AS i
            WHERE t.id = i.tour_id AND i.isMain = 1";

        if ($result = mysqli_query($conn, $sql))
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        else
            return ['status' => 0, 'message' => 'Fetch failure!'];
    }

    public function fetchToursHotOrderMost()
    {
        $conn = $this->connect();

        $sql = "SELECT * FROM v_tours_hot_order_most";

        if ($result = mysqli_query($conn, $sql))
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        else
            return ['status' => 0, 'message' => 'Fetch failure!'];
    }

    public function updateTour($payload)
    {
        $conn = $this->connect();

        $price = $payload->price;
        $priceChild = $price - ($price * 10 / 100);
        $lengthCategories = count($payload->categories);
        $categories = "";
        $topics = "";
        $lengthTopics = count($payload->topics);

        $objFunction = new Functions;
        $categories = $objFunction->string_concatenation($lengthCategories, $payload->categories);
        $topics = $objFunction->string_concatenation($lengthTopics, $payload->topics);

        $sql = "
            call sp_handle_update_tour($payload->id, '$payload->name', '$payload->description', $payload->price,
            $priceChild, '$payload->image', $lengthCategories, $categories, $lengthTopics, $topics);
        ";

        if (mysqli_query($conn, $sql))
            return ['status' => 1, 'message' => 'Update success!'];
        else
            return ['status' => 0, 'message' => 'Update failure!'];
    }

    public function deleteTour($payload)
    {
        $conn = $this->connect();

        $sql = "CALL sp_handle_delete_tour($payload->id)";

        if (mysqli_query($conn, $sql))
            return ['status' => 1, 'message' => 'Delete successfully!'];
        else
            return ['status' => 0, 'message' => 'Delete failure!'];
    }

    public function insertTour($payload)
    {
        $conn = $this->connect();

        $topics = "";
        $categories = "";
        $lengthTopics = count($payload->topics);
        $lengthCategories = count($payload->categories);

        $objFunction = new Functions();
        $topics = $objFunction->string_concatenation($lengthTopics, $payload->topics);
        $categories = $objFunction->string_concatenation($lengthCategories, $payload->categories);

        $sql = "CALL sp_handle_insert_tour('$payload->name', '$payload->description', $payload->price, 
        '$payload->image', $lengthTopics, $topics, $lengthCategories, $categories)";

        if (mysqli_query($conn, $sql))
            return ['status' => 1, 'message' => 'Insert successfully!'];
        else
            return ['status' => 0, 'message' => 'Insert failure!'];
    }

    public function find_tours_other($payload)
    {
        $conn = $this->connect();

        $objValue = new stdClass;
        foreach ($payload as $key => $value) {
            $objValue->$key = $value;
        }

        $sql = "call sp_find_tours_ref('$objValue->name', '$objValue->title', 
            $objValue->startPrice, $objValue->endPrice, '$objValue->start_date',
            '$objValue->end_date')";

        if ($result = mysqli_query($conn, $sql))
            // return mysqli_fetch_all($result, MYSQLI_ASSOC);
            return ['message' => 'Fetch failure!', 'status' => 0, '$sql' => $sql];
        else
            return ['message' => 'Fetch failure!', 'status' => 0, '$sql' => $sql];
    }

    public function find_tours($payload)
    {
        $conn = $this->connect();

        $sql = "SELECT t.id, t.name, t.description, i.image, t.priceAdult
        FROM `tours` AS t, categories AS c, tours_categories AS tc, images AS i
        WHERE tc.tours_id = t.id AND tc.categories_id = c.id AND i.tour_id = t.id AND ";

        $i = 1;
        foreach ($payload as $key => $value) {
            if ($i == count($payload)) {
                if ($key == 'name')
                    $sql .= "$key like '%$value%'";
                if ($key == 'start_date' || $key == 'end_date') {
                    if ($key == 'start_date')
                        $sql .= "$key <= '$value'";
                    if ($key == 'end_date')
                        $sql .= "$key >= '$value'";
                } else if ($key = 'priceAdult')
                    $sql .= "$key BETWEEN $value[0] AND $value[1]";
                else
                    $sql .= "$key. ' = '. $value";
            } else {
                if ($key == 'name')
                    $sql .= "$key like '%$value%' AND ";
                else if ($key == 'priceAdult')
                    $sql .= "$key BETWEEN $value[0] AND $value[1] AND ";
                else if ($key == 'start_date' || $key == 'end_date') {
                    if ($key == 'start_date')
                        $sql .= "$key <= '$value' AND ";
                    else
                        $sql .= "$key >= '$value' AND ";
                } else
                    $sql .= "$key = '$value' AND ";
            }
            $i++;
        }
        $sql .= ' GROUP BY t.id;';

        if ($result = mysqli_query($conn, $sql))
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        else
            return ['message' => 'Fetch fail!', 'status' => 0, 'sql' => $sql, 'lenght' => count($payload)];
    }

    public function fetch_tour_by_category($name)
    {
        $conn = $this->connect();

        $sql = "call sp_get_tour_by_category('$name')";

        if ($result = mysqli_query($conn, $sql))
            // return ['message' => 'Fetch failure!', 'status' => 0];
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        else
            return ['message' => 'Fetch failure!', 'status' => 0];
    }
}
?>