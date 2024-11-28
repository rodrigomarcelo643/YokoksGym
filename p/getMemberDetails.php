<?php
header('Content-Type: application/json');

include 'connection.php';

$memberId = isset($_POST['memberId']) ? $_POST['memberId'] : null;

if (!$memberId) {
    echo json_encode(array("status" => "error", "message" => "Invalid input"));
    exit();
}


$query = "SELECT first_name, last_name FROM members WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $memberId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(array("status" => "error", "message" => "Member not found"));
} else {
    $member = $result->fetch_assoc();
    echo json_encode(array("status" => "success", "first_name" => $member['first_name'], "last_name" => $member['last_name']));
}

?>