<?php

include 'connection.php';

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

$searchQuery = htmlspecialchars($searchQuery);

$sql = "SELECT * FROM members WHERE CONCAT(first_name, ' ', last_name) LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%$searchQuery%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>