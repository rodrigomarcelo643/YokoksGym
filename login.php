<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connection.php'; 

$response = array("status" => "error");

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    echo json_encode(array("status" => "invalid_request", "method" => $_SERVER['REQUEST_METHOD']));
    exit();
}

if (empty($_POST['username']) || empty($_POST['password'])) {
    echo json_encode(array("status" => "invalid_request", "error" => "Missing username or password"));
    exit();
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT id, first_name, last_name, username, contact_number, password FROM members_mobile WHERE username = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    $response["status"] = "prepare_failed";
    $response["error"] = $conn->error;
    echo json_encode($response);
    exit();
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $response["status"] = "success";
        $response["first_name"] = $user["first_name"];
        $response["last_name"] = $user["last_name"];
        $response["username"] = $user["username"];
        $response["contact_number"] = $user["contact_number"];
        $response["user_id"] = $user["id"]; // Add user ID to response
    } else {
        $response["status"] = "invalid_password";
    }
} else {
    $response["status"] = "user_not_found";
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
