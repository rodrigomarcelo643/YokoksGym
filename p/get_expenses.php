<?php
include 'connection.php';
date_default_timezone_set('Asia/Manila');
header('Content-Type: application/json');

$sql = "SELECT date, SUM(amount) as total_amount FROM expenses GROUP BY date ORDER BY date";

$result = $conn->query($sql);

$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);

$conn->close();
?>