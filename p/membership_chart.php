<?php
include 'connection.php';

// Query to get membership types and their counts
$sql = "SELECT membership_type, COUNT(*) as count FROM members GROUP BY membership_type";
$result = $conn->query($sql);

$membershipData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $membershipData[$row['membership_type']] = $row['count'];
    }
}

// Close the connection
$conn->close();

// Convert membership data to JSON for use in JavaScript
echo '<script>';
echo 'const membershipData = ' . json_encode($membershipData) . ';';
echo '</script>';
?>