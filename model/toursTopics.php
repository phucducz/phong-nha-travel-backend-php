<?php
include_once('../config/Database.php');
class ToursTopics {
    private $conn;
    private $objConn;
    
    private function connectDatabase() {
        $objConn = new Database();
        $conn = $objConn->connectDb();

        return $conn;
    }

    public function fetchToursTopicsById($id) {
        $conn = $this->connectDatabase();

        $sql = "CALL sp_select_tours_topics_id($id)";

        if($result = mysqli_query($conn, $sql))
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        else
            return ['status' => 0, 'message' => 'Fecth failure!'];
    }
}

?>