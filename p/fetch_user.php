<?php
header('Content-Type: application/json');
include 'connection.php';
$email = $_POST['email'];

$stmt = $conn->prepare("SELECT staffEmail, profileImage FROM addstaff WHERE staffEmail = ?");
$stmt->bind_param("s", $email);

$stmt->execute();
$stmt->store_result();

$response = array();
if ($stmt->num_rows > 0) {
    $stmt->bind_result($staffEmail, $profileImage);
    $stmt->fetch();
    
    // Check if profileImage is NULL or default and handle accordingly
    $profileImage = $profileImage ? base64_encode($profileImage) : 'default';
    
    $response['found'] = true;
    $response['email'] = $staffEmail;
    $response['profileImage'] = $profileImage;
} else {
    $response['found'] = false;
}

echo json_encode($response);
?>