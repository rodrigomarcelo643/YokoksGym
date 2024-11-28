<?php
header('Content-Type: application/json');

include 'connection.php';

if ($conn->connect_error) {
    die(json_encode(['error' => "Connection failed: " . $conn->connect_error]));
}

$today = date('Y-m-d');

$stmt = $conn->prepare("SELECT COALESCE(SUM(sales_count), 0) AS today_sales FROM daily_sales WHERE renewal_date = ?");

if (!$stmt) {
    die(json_encode(['error' => "Prepare failed: " . $conn->error]));
}


$stmt->bind_param("s", $today);

if ($stmt->execute()) {
    $stmt->bind_result($todaySales);
    $stmt->fetch();
    
    echo json_encode(['today_sales' => $todaySales]);
} else {
    echo json_encode(['error' => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>