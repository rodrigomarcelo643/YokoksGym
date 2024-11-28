<?php
require 'connection.php'; // Include your database connection file

header('Content-Type: application/json'); // Set the content type to JSON

// Query to calculate the total debt
$query = "SELECT SUM(total) AS total_debt FROM debt_items";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalDebt = $row['total_debt'] ?? 0; // Get total debt or set to 0 if null

    // Format total debt with comma separation and two decimal places
    $formattedTotalDebt = number_format($totalDebt, 2);

    echo json_encode(['success' => true, 'total_debt' => $formattedTotalDebt]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to retrieve total debt.']);
}

// Close the database connection
mysqli_close($conn);
?>