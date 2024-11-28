<?php
include 'connection.php';
date_default_timezone_set('Asia/Manila');
header('Content-Type: application/json');

// Get today's and yesterday's dates
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));

// SQL queries to fetch expenses totals for today and yesterday
$sql_today = "SELECT SUM(amount) as total_amount FROM expenses WHERE DATE(date) = '$today'";
$sql_yesterday = "SELECT SUM(amount) as total_amount FROM expenses WHERE DATE(date) = '$yesterday'";

$result_today = $conn->query($sql_today);
$result_yesterday = $conn->query($sql_yesterday);

$data = [
    'today' => $result_today->fetch_assoc(),
    'yesterday' => $result_yesterday->fetch_assoc(),
];

echo json_encode($data);

$conn->close();
?>