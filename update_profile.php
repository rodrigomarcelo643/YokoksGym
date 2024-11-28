<?php
include 'connection.php';

// Get the POST data
$username = $_POST['username'] ?? '';
$firstName = $_POST['first_name'] ?? '';
$lastName = $_POST['last_name'] ?? '';
$contactNumber = $_POST['contact_number'] ?? '';
$birthdate = $_POST['birthdate'] ?? '';
$gender = $_POST['gender'] ?? '';
$profileImage = $_POST['profile_image'] ?? null;

// Prepare the SQL statement
if ($profileImage) {
    $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, contact_number = ?, birthdate = ?, gender = ?, profile_image = ? WHERE username = ?");
    $stmt->bind_param("ssssssi", $firstName, $lastName, $contactNumber, $birthdate, $gender, $profileImage, $username);
} else {
    $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, contact_number = ?, birthdate = ?, gender = ? WHERE username = ?");
    $stmt->bind_param("ssssss", $firstName, $lastName, $contactNumber, $birthdate, $gender, $username);
}

// Execute the statement
if ($stmt->execute()) {
    // Send a success message with a success field
    echo json_encode(["success" => true, "message" => "Profile updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Update failed: " . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
