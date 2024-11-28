<?php
  date_default_timezone_set('Asia/Manila');
$servername = "localhost"; 
$username = "u843230181_Anonymous"; 
$password = "Rodrigo#12345"; 
$dbname = "u843230181_Anonymous_db"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>