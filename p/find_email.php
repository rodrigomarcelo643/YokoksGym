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
    
    // Check if profile image is empty or not set
    if (empty($profileImage)) {
        // Use a placeholder or default image if no profile image is found
        $profileImage = 'default';  // You can set a specific value to indicate the default
    } else {
        // Encode the profile image in base64 if it's available
        $profileImage = base64_encode($profileImage);
    }

    $response['found'] = true;
    $response['email'] = $staffEmail;
    $response['profileImage'] = $profileImage;
} else {
    $response['found'] = false;
}

// Send the JSON response
echo json_encode($response);
?>