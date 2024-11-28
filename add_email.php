<?php
header("Content-Type: application/json");

include'connection.php';


// Get POST data
$username = $_POST['username'];
$email = $_POST['email'];

// Update the email in the database
$sql = "UPDATE members_mobile SET email=? WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $username);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Email added successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add email: " . $conn->error]);
}

$stmt->close();
$conn->close();
?>
