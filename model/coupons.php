<?php

include_once('../config/Database.php');

class Coupons
{
    private $conn;

    private function connect()
    {
        $objConn = new Database();
        $conn = $objConn->connectDb();

        return $conn;
    }

    public function checkCouponCode($couponCode)
    {
        $conn = $this->connect();

        $sql = "call sp_check_coupon_code('$couponCode')";
        
        if ($result = mysqli_query($conn, $sql)) {
            if ($fetch = mysqli_fetch_array($result, MYSQLI_ASSOC))
                return ['status' => 1, 'result' => $fetch];
            else
                return ['status' => 0];
        } else
            return ['status' => 0, 'result' => $result];
    }

    public function fetch_coupon()
    {
        $conn = $this->connect();

        $sql = "SELECT * FROM coupons";

        if ($result = mysqli_query($conn, $sql))
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        else
            return ['status' => 0, 'message' => 'Fetch failure!'];
    }

    public function fetch_coupon_by_code($code)
    {
        $conn = $this->connect();

        $sql = "SELECT * FROM coupons WHERE code = '" . $code . "'";

        if ($result = mysqli_query($conn, $sql))
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        else
            return ['status' => 0, 'message' => 'Fetch failure!'];
    }

    public function fetch_coupon_by_id($id)
    {
        $conn = $this->connect();

        $sql = "SELECT * FROM coupons WHERE id = $id";

        if ($result = mysqli_query($conn, $sql))
            return mysqli_fetch_assoc($result);
        else
            return ['status' => 0, 'message' => 'Fetch failure!'];
    }
}

?>