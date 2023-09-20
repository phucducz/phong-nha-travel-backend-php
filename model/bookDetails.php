<?php
include_once('../config/Database.php');
include_once('../model/registerTour.php');
class BookDetails
{
    private $conn;
    private $objConnect;

    private function connect()
    {
        $objConnect = new Database();
        $conn = $objConnect->connectDb();

        return $conn;
    }

    public function insertBookDetails($information)
    {
        $conn = $this->connect();

        if ($information->couponId == null)
            $sql = "call sp_insertBookDetails('$information->companyName', '$information->country', 
                '$information->postOfficeCode', '$information->city', '$information->note', 
                $information->paymentId, '$information->firstName', '$information->lastName', '$information->address',
                '$information->apartment', '$information->phoneNumber', '$information->email', '$information->quantity', 
                null)";
        else
            $sql = "call sp_insertBookDetails('$information->companyName', '$information->country', 
                '$information->postOfficeCode', '$information->city', '$information->note', 
                $information->paymentId, '$information->firstName', '$information->lastName', '$information->address',
                '$information->apartment', '$information->phoneNumber', '$information->email', '$information->quantity', 
                $information->couponId)";

        if (mysqli_query($conn, $sql))
            $res = ['status' => 1, 'message' => 'Insert book_details successfully!', 'sql' => $sql];
        else
            $res = ['status' => 0, 'message' => 'Insert book_details failure!'];

        return $res;
    }

    public function deleteBookedDetails($option)
    {
        $conn = $this->connect();

        $sql = "CALL deleteBookedDetails($option->id)";

        if (mysqli_query($conn, $sql))
            return ['status' => '1', 'message' => 'Delete success!'];
        else
            return ['status' => '0', 'message' => 'Delete failure!'];
    }
}

?>