<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connection.php';

    $staffUsername = htmlspecialchars($_POST['staffUsername']);
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $staffEmail = htmlspecialchars($_POST['staffEmail']);

    // Prepare to update profile details
    $updateStmt = $conn->prepare("UPDATE addstaff SET first_name = ?, last_name = ?, staffEmail = ? WHERE staffUsername = ?");
    $updateStmt->bind_param('ssss', $firstName, $lastName, $staffEmail, $staffUsername);
    $updateStmt->execute();

    // Handle file upload
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profileImage']['tmp_name'];
        $fileContent = file_get_contents($fileTmpPath);

        $updateImageStmt = $conn->prepare("UPDATE addstaff SET profileImage = ? WHERE staffUsername = ?");
        $updateImageStmt->bind_param('bs', $fileContent, $staffUsername);
        $updateImageStmt->send_long_data(0, $fileContent);
        $updateImageStmt->execute();
    }

    // Fetch the updated profile data
    $stmt = $conn->prepare("SELECT first_name, last_name, staffEmail, profileImage FROM addstaff WHERE staffUsername = ?");
    $stmt->bind_param('s', $staffUsername);
    $stmt->execute();
    $stmt->bind_result($firstName, $lastName, $staffEmail, $profileImageBlob);
    $stmt->fetch();
    $_SESSION['firstName'] = $firstName;
    $_SESSION['lastName'] = $lastName;
    $_SESSION['staffEmail'] = $staffEmail;
    $_SESSION['profileImage'] = base64_encode($profileImageBlob); // Encode BLOB to base64

    $stmt->close();
    $conn->close();

    $response = ["status" => "success", "message" => "Profile updated successfully"];
    echo json_encode($response);
    exit();
}
?>