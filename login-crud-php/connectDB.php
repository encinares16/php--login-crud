<?php 
    class ConnectDB {
        public $connect;
        function __connect($connect){
            $this->connect = $connect;
            if (!$connect) {
                die("Database connected failed: " . mysqli_connect_error());
            }
        }
    }
?>