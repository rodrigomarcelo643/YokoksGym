<?php
// Database connection (replace with your own connection details)
include'connection.php';


// Get username from POST request
$username = $_POST['username'];

// Fetch email from the database
$sql = "SELECT email FROM members_mobile WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($email);
$stmt->fetch();

if ($email) {
    echo json_encode(["status" => "success", "email" => $email]);
} else {
    echo json_encode(["status" => "error", "message" => "Email not found."]);
}

$stmt->close();
$conn->close();
?>
