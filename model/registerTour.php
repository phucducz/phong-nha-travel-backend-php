<?php
include_once('../config/Database.php');

class RegisterTour
{

    private $objConnect;
    private $conn;

    public function insertBookTour($information)
    {
        $objConnect = new Database();
        $conn = $objConnect->connectDb();

        $information->dateTime = date('Y-m-d');
        $sql = "CALL sp_insertBookedTours('$information->tourId', '$information->bookingDate', '$information->userId')";

        if (mysqli_query($conn, $sql))
            $res = ['status' => 1, 'message' => 'Book tour successfully!'];
        else
            $res = ['status' => 0, 'message' => 'Book tour failure!'];

        return $sql;
    }
}


?>