<?php

include_once('../config/Database.php');

class PaymentMethod {
    private $conn;
    private $objConn;

    private function connect()
    {
        $objConn = new Database();
        $conn = $objConn->connectDb();

        return $conn;
    }

    public function getListPayment() {
        $connect = $this->connect();

        $sql = 'SELECT * FROM payment_methods';

        if($result = mysqli_query($connect, $sql))
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        else
            return ['message' => 'Fetch failure!', 'status' => 0];
    }
}

?>