<?php
include 'connection.php';

header('Content-Type: application/json');

// Get today's date in YYYY-MM-DD format
$today = date('Y-m-d');

// Update the SQL query to filter by today's date
$sql = "SELECT SUM(amount) as total_amount FROM expenses WHERE date = '$today'";

$result = $conn->query($sql);

$data = $result->fetch_assoc();

echo json_encode($data);

$conn->close();
?>