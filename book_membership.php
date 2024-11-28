<?php
include 'connection.php';

// Start the session to access session variables
session_start();

// Debugging: Log session data
error_log(print_r($_SESSION, true));

// Get the POSTed JSON data
$input = json_decode(file_get_contents('php://input'), true);

// Check if the user is authenticated (username stored in session)
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Validate input data
    if (!isset($input['membership_type']) || !isset($input['first_name']) || !isset($input['last_name'])) {
        echo json_encode(["success" => false, "error" => "Invalid input data"]);
        exit();
    }

    $membership_type = $input['membership_type'];
    $first_name = $input['first_name'];
    $last_name = $input['last_name'];

    // Prepare the SQL statement to check for existing bookings
    $checkSql = "SELECT * FROM bookings WHERE username = ? AND status = 'pending'";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Update the existing booking if found
        $updateSql = "UPDATE bookings SET membership_type = ?, first_name = ?, last_name = ?, status = 'pending' WHERE username = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ssss", $membership_type, $first_name, $last_name, $username);

        if ($updateStmt->execute()) {
            echo json_encode(["success" => true, "message" => "Booking updated successfully", "status" => "pending"]);
        } else {
            echo json_encode(["success" => false, "error" => "Failed to update booking"]);
        }
    } else {
        // Insert new booking if none exists
        $insertSql = "INSERT INTO bookings (username, membership_type, first_name, last_name, status) VALUES (?, ?, ?, ?, 'pending')";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("ssss", $username, $membership_type, $first_name, $last_name);

        // Execute the statement and check for success
        if ($insertStmt->execute()) {
            echo json_encode(["success" => true, "message" => "Booking successful", "status" => "pending"]);
        } else {
            echo json_encode(["success" => false, "error" => "Failed to insert booking"]);
        }
    }

    // Close statements
    $checkStmt->close();
    if (isset($updateStmt)) {
        $updateStmt->close();
    }
    if (isset($insertStmt)) {
        $insertStmt->close();
    }
} else {
    echo json_encode(["success" => false, "error" => "User not authenticated"]);
}

// Close the database connection
$conn->close();
?>
