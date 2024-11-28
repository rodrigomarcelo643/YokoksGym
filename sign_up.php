<?php
include 'connection.php';



if($_SERVER['REQUEST_METHOD'] == "POST"){

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$username = $_POST['username'];
$contact_number = $_POST['contact_number'];
$password = $_POST['password'];

$sql = "INSERT INTO members_mobile (first_name, last_name, username, contact_number, password) 
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}


$hashed_password = password_hash($password, PASSWORD_DEFAULT);


$stmt->bind_param("sssss", $first_name, $last_name, $username, $contact_number, $hashed_password);


if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

}
?>
