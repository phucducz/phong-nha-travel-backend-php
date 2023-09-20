<?php

include_once('../config/Database.php');

class Checkouts
{
    private $objConnect;

    private function connect()
    {
        $objConnect = new Database();

        return $objConnect->connectDb();
    }

    public function insert_checkouts($userId)
    {
        $conn = $this->connect();

        $sql = "CALL sp_insert_checkouts($userId)";

        if (mysqli_query($conn, $sql))
            return ['message' => 'Insert successfully!', 'status' => 1];
        else
            return ['message' => 'Insert failure!', 'status' => 0];
    }

    public function get_exist_cart_items($userId)
    {
        $conn = $this->connect();

        $sql = "CALL sp_get_exist_cart_items($userId)";

        if ($result = mysqli_query($conn, $sql))
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        else
            return ['message' => 'Fetch failure!', 'status' => 0];

    }
}

?>