<?php 
    include '../p/connection.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $staffFirstName = $_POST['firstName'];
        $staffLastName = $_POST['lastName'];
        $staffUsername = $_POST['staffUsername'];
        $staffPassword = $_POST['staffPassword'];
        $staffEmail = $_POST['staffEmail'];

        $hashedPassword = password_hash($staffPassword, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO addstaff (first_name, last_name, staffUsername, staffPassword, staffEmail) VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param("sssss", $staffFirstName, $staffLastName, $staffUsername, $hashedPassword, $staffEmail);

        if ($stmt->execute()) {
            echo json_encode(['success' => "Message Successfully Sent"]);
        } else {
            echo json_encode(['error' => "Message Failed To Send: " . $stmt->error]);
        }
    }
?>