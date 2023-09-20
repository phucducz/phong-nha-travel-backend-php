<?php

include_once('../config/Database.php');

class Categories
{
    private $conn;
    private $objConn;

    private function connectDatabase()
    {
        $objConn = new Database();
        $conn = $objConn->connectDb();

        return $conn;
    }

    public function fetchCategories()
    {
        $conn = $this->connectDatabase();
        $sql = 'SELECT * FROM categories';

        if ($result = mysqli_query($conn, $sql))
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        else
            return ['status' => '0', 'message' => 'Fetch failure!'];
    }
}
?>