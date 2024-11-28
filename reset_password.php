<?php

include 'connection.php';

$currentPassword = $_POST['current_password'];
$newPassword = $_POST['new_password'];
$username = $_POST['username']; 


if (empty($currentPassword) || empty($newPassword)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

$newPasswordHashed = password_hash($newPassword, PASSWORD_BCRYPT);

$sql = "SELECT password FROM members_mobile  WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    if (password_verify($currentPassword, $row['password'])) {
        $updateSql = "UPDATE members_mobile SET password = ? WHERE username = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ss", $newPasswordHashed, $username);

        if ($updateStmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Password changed successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update the password.']);
        }
        $updateStmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not found.']);
}

$stmt->close();
$conn->close();
?>
