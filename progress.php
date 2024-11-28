<?php
header('Content-Type: application/json');

include 'connection.php';

// Get the username from the request (GET parameter)
$username = isset($_GET['username']) ? $conn->real_escape_string($_GET['username']) : '';

$response = array();

// Check if username is provided
if (!empty($username)) {
    $sql = "SELECT COUNT(*) as count FROM scanned_visits WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response['count'] = $row['count'];
        }
    } else {
        $response['count'] = 0;
    }
} else {
    $response['error'] = "Username is required";
}

// Close the database connection
$conn->close();
echo json_encode($response);
?>
