<?php
// Database connection settings
include 'connection.php';

// SQL query to count visits for today
$sql = "SELECT COUNT(*) AS visit_count FROM scanned_visits WHERE DATE(created_at) = CURDATE()";
$result = $conn->query($sql);

// Initialize visit count
$visit_count = 0;

// Check if the query was successful
if ($result) {
    $row = $result->fetch_assoc();
    $visit_count = $row['visit_count'];
} else {
    echo "Error: " . $conn->error;
}

// Close connection
$conn->close();

// Calculate the total visits and format it with comma separation
$total_visits = 0 + $visit_count;
$formatted_visit_count = number_format($total_visits);

// Output the visit count
echo $formatted_visit_count;
?>