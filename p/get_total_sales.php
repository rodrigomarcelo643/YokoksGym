<?php
require 'connection.php'; // Include your database connection file

header('Content-Type: application/json'); // Set the content type to JSON

// Query to calculate the total sales
$query = "SELECT SUM(total) AS total_sales FROM sales";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalSales = $row['total_sales'] ?? 0; // Get total sales or set to 0 if null
    $totalSalesFormatted = number_format($totalSales, 2);
    echo json_encode(['success' => true, 'total_sales' => $totalSales]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to retrieve total sales.']);
}

// Close the database connection
mysqli_close($conn);
?>