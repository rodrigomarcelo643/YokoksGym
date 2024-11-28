<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connection.php'; 


    $response = ["status" => "error", "username" => "", "password" => "", "message" => ""];

    if (isset($_POST['staffUsername']) && isset($_POST['staffPassword'])) {
        $staff_username = htmlspecialchars($_POST['staffUsername']);
        $staff_password = htmlspecialchars($_POST['staffPassword']);

        $stmt = $conn->prepare("SELECT staffPassword, first_name, last_name, staffEmail, profileImage FROM addstaff WHERE staffUsername = ?");
        $stmt->bind_param('s', $staff_username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password, $first_name, $last_name, $staff_email, $profileImageBlob);
            $stmt->fetch();
            
            if (password_verify($staff_password, $hashed_password)) {
          
                $_SESSION['staffUsername'] = $staff_username;
                $_SESSION['firstName'] = $first_name;
                $_SESSION['lastName'] = $last_name;
                $_SESSION['staffEmail'] = $staff_email;
                $_SESSION['profileImage'] = $profileImageBlob ? base64_encode($profileImageBlob) : ''; // Encode BLOB as base64 if not null
                $response = ["status" => "success", "message" => "Login successful"];
            } else {
                $response['password'] = "Invalid password.";
            }
        } else {
            $response['username'] = "Username not found.";
        }

        $stmt->close();
    } else {
        $response['message'] = "Required fields are missing.";
    }

    $conn->close();
    echo json_encode($response);
    exit();
}
?>