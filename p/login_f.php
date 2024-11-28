<?php
session_start();
header('Content-Type: application/json');

include 'connection.php'; 

$response = ["success" => false, "message" => "", "staffUsername" => ""];

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $stmt = $conn->prepare("SELECT staffUsername, staffPassword, first_name, last_name, profileImage FROM addstaff WHERE staffEmail = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($staffUsername, $storedPassword, $firstName, $lastName, $profileImageBlob);
        $stmt->fetch();
        
        // Verify password
        if (password_verify($password, $storedPassword)) {
            // Set session variables
            $_SESSION['staffEmail'] = $email;
            $_SESSION['staffUsername'] = $staffUsername;
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            $_SESSION['profileImage'] = $profileImageBlob ? base64_encode($profileImageBlob) : ''; // Encode BLOB as base64 if not null

            $response = [
                "success" => true, 
                "message" => "Login successful",
                "staffUsername" => $staffUsername
            ];
        } else {
            $response['message'] = "Incorrect password.";
        }
    } else {
        $response['message'] = "Email not found.";
    }

    $stmt->close();
} else {
    $response['message'] = "Email and password are required.";
}

$conn->close();
echo json_encode($response);
exit();
?>