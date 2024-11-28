<?php
// Include the database connection
require 'connection.php'; // Ensure this file is correctly included

header('Content-Type: application/json'); // Set the content type to JSON

function getNetData($conn) {
    // Query to get daily sales based on sale_time
    $dailySalesQuery = "SELECT SUM(total) AS daily_sales FROM sales WHERE DATE(sale_time) = CURDATE()";
    $resultDaily = $conn->query($dailySalesQuery);
    $dailySales = $resultDaily->fetch_assoc()['daily_sales'] ?? 0.00;

    // Query to get total expenses for the current day
    $expensesQuery = "SELECT SUM(amount) AS total_expenses FROM expenses WHERE DATE(date) = CURDATE()";
    $resultExpenses = $conn->query($expensesQuery);
    $totalExpenses = $resultExpenses->fetch_assoc()['total_expenses'] ?? 0.00;

    // Calculate net daily sales by subtracting expenses from daily sales
    $netDailySales = $dailySales - $totalExpenses;

    // Prepare the response data
    $response = [
        'daily_sales' => number_format((float)$dailySales, 2), // Format daily sales
        'total_expenses' => number_format((float)$totalExpenses, 2), // Format total expenses
        'net_daily_sales' => number_format((float)$netDailySales, 2) // Format net daily sales
    ];

    return json_encode($response);
}

// Call the function and output the JSON response
echo getNetData($conn);
?>