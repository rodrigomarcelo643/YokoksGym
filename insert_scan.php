<?php
header('Content-Type: application/json');

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $scanned_url = $conn->real_escape_string($_POST['scanned_url']);

 
    $sql = "INSERT INTO scanned_visits (username, scanned_url, created_at) 
            VALUES ('$username', '$scanned_url', 
            DATE_FORMAT(CONVERT_TZ(NOW(), '+00:00', '+08:00'), '%Y-%m-%d %r'))";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Scan recorded successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error recording scan: ' . $conn->error]);
    }
}

$conn->close();
?>
