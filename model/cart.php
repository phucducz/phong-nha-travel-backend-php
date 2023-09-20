<?php

include_once('../config/Database.php');

class Cart
{
    private function connect()
    {
        $objConn = new Database();
        $connect = $objConn->connectDb();

        return $connect;
    }

    public function insert_cart($payload)
    {
        $conn = $this->connect();

        $sql = "call sp_insert_cart($payload->tourId, '$payload->bookingDate', $payload->quantity, $payload->userId)";

        if (mysqli_query($conn, $sql))
            return ['message' => 'Insert successfully!', 'status' => 1];
        else
            return ['message' => 'Insert failure!', 'status' => 0];
    }

    public function update_cart_coupon_id($payload)
    {
        $conn = $this->connect();

        $sql = "call sp_update_cart_coupon($payload->couponId, $payload->userId)";

        if (mysqli_query($conn, $sql))
            return ['message' => 'Update successfully!', 'status' => 1];
        else
            return ['message' => 'Update failure!', 'status' => 0];
    }

    public function get_list_cart($userId)
    {
        $conn = $this->connect();

        $sql = "CALL sp_select_cart($userId)";

        if ($result = mysqli_query($conn, $sql))
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        else
            return ['status' => 0, 'message' => 'Fecth failure!'];
    }

    public function delete_cart_item($itemId)
    {
        $conn = $this->connect();

        $sql = "CALL sp_delete_cart_item($itemId)";

        if (mysqli_query($conn, $sql))
            return ['status' => '1', 'message' => 'Delete successfully!'];
        else
            return ['status' => '0', 'message' => 'Delete failure!'];
    }

    public function update_cart_item($payload)
    {
        $conn = $this->connect();

        $sql = "CALL sp_update_cart_price($payload->id, $payload->quantity)";

        if (mysqli_query($conn, $sql))
            return ['status' => '1', 'message' => 'Update successfully!'];
        else
            return ['status' => '0', 'message' => 'Update failure!'];
    }
}

?>