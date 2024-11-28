<?php
include 'connection.php'; 

header('Content-Type: application/json');

$today = date('Y-m-d');


$sql = "SELECT membership_start, COUNT(id) as count FROM members WHERE membership_start = '$today' GROUP BY membership_start";

$result = $conn->query($sql);

$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();
?>