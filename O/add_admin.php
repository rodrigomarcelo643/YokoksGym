<?php 
    include '../p/connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['AdminfirstName'];
    $lastName = $_POST['AdminlastName'];
    $address = $_POST['address'];
    $contactNumber = $_POST['contact_number'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO Admin (firstName, lastName, address, contact_number, username, password, email) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $firstName, $lastName, $address, $contactNumber, $username, $password, $email);
    if ($stmt->execute()) {
        echo "New admin added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();

?>