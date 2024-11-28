<?php
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connection.php'; // Ensure this file includes the database connection

    // Sanitize user inputs
    $current_password = htmlspecialchars($_POST['current-password']);
    $new_password = htmlspecialchars($_POST['new-password']);

    // Get the username from the session
    $staff_username = $_SESSION['staffUsername'];

    // Fetch the current password from the database
    $stmt = $conn->prepare("SELECT staffPassword FROM addstaff WHERE staffUsername = ?");
    $stmt->bind_param('s', $staff_username);
    $stmt->execute();
    $stmt->store_result();
    
    $response = ["status" => "error", "message" => ""];

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        if (password_verify($current_password, $hashed_password)) {
            // Update the password
            $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("UPDATE addstaff SET staffPassword = ? WHERE staffUsername = ?");
            $stmt->bind_param('ss', $new_password_hash, $staff_username);
            if ($stmt->execute()) {
                $response = ["status" => "success", "message" => "Password updated successfully."];
            } else {
                $response['message'] = "Failed to update password.";
            }
        } else {
            $response['message'] = "Current password is incorrect.";
        }
    } else {
        $response['message'] = "Username not found.";
    }

    $stmt->close();
    $conn->close();
    echo json_encode($response);
    exit();
}
?>