<?php
include_once('../config/Database.php');
class UpdateAPI
{
    private $objConnect;
    private $conn;

    private function connectDatabase()
    {
        $objConnect = new Database();
        $conn = $objConnect->connectDb();

        return $conn;
    }

    public function updateData($option)
    {
        $conn = $this->connectDatabase();

        $sql = "UPDATE $option->tableName SET quantity = $option->quantity WHERE ID = $option->bookedTourId";
        $result = mysqli_query($conn, $sql);

        if ($result)
            return ['status: ' => 1, 'message: ' => 'Update success!'];
        else
            return ['status: ' => 0, 'message: ' => 'Update failure!'];;
    }
}
?>