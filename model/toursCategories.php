<?php
include_once('../config/Database.php');
class ToursCategories
{
    private $objConn;
    private $conn;

    private function connectDatabase()
    {
        $objConn = new Database();
        $conn = $objConn->connectDb();

        return $conn;
    }

    public function fetchToursCategories()
    {
        $conn = $this->connectDatabase();
        $sql = 'SELECT * FROM tours_categories';

        if ($result = mysqli_query($conn, $sql))
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        else
            return ['status' => '0', 'message' => 'Fetch failure!'];
    }

    public function fetchToursCategoriesById($payload)
    {
        $conn = $this->connectDatabase();
        
        $sql = "SELECT c.id as id, c.title
                FROM categories AS c, tours_categories AS tc 
                WHERE c.id = tc.categories_id AND tc.tours_id = $payload->id
        ";

        if ($result = mysqli_query($conn, $sql))
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        else
            return ['status' => '0', 'message' => 'Fetch failure!'];
    }
}

?>