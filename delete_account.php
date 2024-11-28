<?php
header('Content-Type: application/json');

include'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM members_mobile WHERE username = ?");
    $stmt->bind_param("s", $username);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(array("status" => "success", "message" => "Account deleted successfully."));
        } else {
            echo json_encode(array("status" => "error", "message" => "No account found with that username."));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Error deleting account: " . $conn->error));
    }

    $stmt->close();
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request."));
}

$conn->close();
?>
