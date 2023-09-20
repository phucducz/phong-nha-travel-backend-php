<?php
include_once('../config/Database.php');
class RemoveTable
{
    private $objConnect;
    private $conn;

    public function removeTableById($option)
    {
        $objConnect = new Database();
        $conn = $objConnect->connectDb();

        $sql = "DELETE FROM $option->tableName WHERE ID = $option->id";

        if (mysqli_query($conn, $sql))
            return ['status' => 1, 'message' => 'Delete successfully!'];
        else
            return ['status' => 0, 'message' => 'Delete failure!'];
            // return $sql;
    }
}
?>