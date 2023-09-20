<?php
include_once('../config/Database.php');
class FetchAPI
{
    private $objConnect;
    private $conn;

    private function connectDatabase()
    {
        $objConnect = new Database();
        $conn = $objConnect->connectDb();

        return $conn;
    }

    public function fetchTour($table)
    {
        $conn = $this->connectDatabase();

        $sql = "CALL sp_select_tour";

        $result = mysqli_query($conn, $sql);
        $fetchTour = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if ($fetchTour)
            return $fetchTour;
        else
            return ['status: ' => 0, 'message: ' => 'Fecth failure!'];
    }

    public function fetchTopic()
    {
        $conn = $this->connectDatabase();

        $sql = "SELECT * FROM topics";

        $result = mysqli_query($conn, $sql);
        $fetchTour = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if ($fetchTour)
            return $fetchTour;
        else
            return ['status: ' => 0, 'message: ' => 'Fecth failure!'];
    }

    public function fetchTopicById($payload)
    {
        $conn = $this->connectDatabase();

        $sql = "SELECT * FROM topics WHERE id = $payload->id";

        $result = mysqli_query($conn, $sql);
        $fetchTour = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if ($fetchTour)
            return $fetchTour;
        else
            return ['status: ' => 0, 'message: ' => 'Fecth failure!'];
    }

    public function fetchTourById($option)
    {
        $conn = $this->connectDatabase();

        $sql = "SELECT ts.id, ts.name, ts.description, p.price_adult AS price, i.image
                FROM tours AS ts, prices AS p, images AS i
                WHERE ts.price_id = p.id AND i.tour_id = ts.id AND ts.id = $option->id";

        if ($result = mysqli_query($conn, $sql)) {
            $fetchTour = mysqli_fetch_array($result, MYSQLI_ASSOC);
            return $fetchTour;
        } else
            return ['status: ' => 0, 'message: ' => 'Fecth failure!'];
    }

    public function fetchTourBookedByUserId($option)
    {
        $conn = $this->connectDatabase();

        $sql = "CALL sp_selectTourBooked($option)";

        if ($result = mysqli_query($conn, $sql)) {
            $fetchTour = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $fetchTour;
        } else
            return ['status: ' => 0, 'message: ' => 'Fecth failure!'];
    }

    public function fetchBookedTour()
    {
        $conn = $this->connectDatabase();
        $sql = "SELECT * FROM booked_tours";

        if ($result = mysqli_query($conn, $sql)) {
            $fetchBookedTour = mysqli_fetch_all($result);
            return $fetchBookedTour;
        } else
            return ['status' => '0', 'message' => 'Fetch failure!'];
    }

    public function searchTour($payload)
    {
        $conn = $this->connectDatabase();
        $sql = "CALL sp_search_tours('$payload->name')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else
            return $sql;
    }

    public function fetchUser()
    {
        $conn = $this->connectDatabase();
        $sql = 'SELECT * FROM users';

        if ($result = mysqli_query($conn, $sql)) {
            $fetchResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $fetchResult;
        } else
            return ['status: ' => '0', 'message: ' => 'Fetch failure!'];
    }
    public function fetchArrayUser()
    {
        $conn = $this->connectDatabase();
        $sql = 'SELECT * FROM users';

        if ($result = mysqli_query($conn, $sql)) {
            $fetchResult = mysqli_fetch_array($result, MYSQLI_ASSOC);
            return $fetchResult;
        } else
            return ['status: ' => '0', 'message: ' => 'Fetch failure!'];
    }
}

?>