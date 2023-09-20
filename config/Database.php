<?php
    class Database
    {
        private $servername = "localhost";
        private $dbname = "quanlysinhvien";
        private $username = "root";
        private $password = "";
        private $conn;

        public function connectDb()
        {
            $conn = new mysqli('localhost', 'root', '', 'travel_management');

            if (!$conn)
                die("Cannot connect database: " . $conn->getMessage());

            return $conn;
        }
    }
?>