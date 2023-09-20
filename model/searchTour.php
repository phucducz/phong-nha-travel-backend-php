<?php
include_once('../config/Database.php');

class SearchTour
{
    private $objConnect;
    private $conn;

    private function connectDatabase()
    {
        $objConnect = new Database();
        $conn = $objConnect->connectDb();

        return $conn;
    }

    public function searchTour($information)
    {
        $conn = $this->connectDatabase();
        $sql = "CALL sp_searchTour('$information->name')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $fetchTour = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $fetchTour;
        } else
            return ['status: ' => 0, 'message: ' => 'Fecth failure!'];
    }
}
?>