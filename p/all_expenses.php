<?php
include 'connection.php';
header('Content-Type: application/json');

$sql = "SELECT SUM(amount) as total_amount FROM expenses";

$result = $conn->query($sql);

$data = $result->fetch_assoc();

echo json_encode($data);
$conn->close();
?>