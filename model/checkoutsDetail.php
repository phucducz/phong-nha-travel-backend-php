<?php

include_once('../config/Database.php');

class CheckoutsDetail
{
    private $conn;

    private function connect()
    {
        $objConnect = new Database();

        return $objConnect->connectDb();
    }

    public function insert_checkouts_detail_first($payload)
    {
        $conn = $this->connect();
        
        $sql = "CALL sp_handle_insert_checkouts_detail($payload->userId, '$payload->firstName', '$payload->lastName',
        '$payload->phoneNumber', '$payload->emailAddress', $payload->paymentMethodId, '$payload->fullName')";

        if (mysqli_query($conn, $sql))
            return ['status' => 1, 'message' => 'Insert successfully!'];
        else
            return ['status' => 0, 'message' => 'Insert failure!', 'sql' => $sql];
    }

    public function get_info_checkouts_detail_user($id)
    {
        $conn = $this->connect();
        
        $sql = "CALL sp_select_checkout_detail($id)";

        if ($result = mysqli_query($conn, $sql))
            return mysqli_fetch_assoc($result);
        else
            return ['status' => 0, 'message' => 'Insert failure!', 'sql' => $sql];
    }
}

?>