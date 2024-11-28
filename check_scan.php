<?php
// Include your database connection
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    
    // Get the current date
    $currentDate = date('Y-m-d');

    // Query to check if there is a scan record for today
    $query = "SELECT COUNT(*) FROM scanned_visits WHERE username = ? AND DATE(created_at) = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $currentDate);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    
    // Return 1 if scanned today, 0 if not
    echo $count > 0 ? "1" : "0";

    $stmt->close();
}
?>
