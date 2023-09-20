<?php

include_once('../config/Database.php');

class TopicModel
{
    private $conn;
    private $objConn;

    public function connect()
    {
        $objConn = new Database();
        $conn = $objConn->connectDb();

        return $conn;
    }

    public function fetchTopicByTitle($title)
    {
        $conn = $this->connect();

        $sql = "SELECT * FROM topics WHERE title = '$title'";

        if ($fetchTopic = mysqli_query($conn, $sql)) {
            if ($result = mysqli_fetch_all($fetchTopic, MYSQLI_ASSOC))
                return $result;
            else
                return ['status' => 0, 'message' => 'Fetch failure!'];
        } else
            return ['status' => 0, 'message' => 'Fetch failure!'];

    }
}

?>