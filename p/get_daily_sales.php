<?php
// Include the database connection
require 'connection.php'; // Ensure this file is correctly included



// Query to get daily sales based on sale_time
$dailySalesQuery = "SELECT SUM(total) AS daily_sales FROM sales WHERE DATE(sale_time) = CURDATE()";
$resultDaily = $conn->query($dailySalesQuery);
$dailySales = $resultDaily->fetch_assoc()['daily_sales'] ?? 0.00;

// Query to get gross sales
$grossSalesQuery = "SELECT SUM(total) AS gross_sales FROM sales";
$resultGross = $conn->query($grossSalesQuery);
$grossSales = $resultGross->fetch_assoc()['gross_sales'] ?? 0.00;

// Calculate the percentage change for the sales display
$percentageChange = ($dailySales > 0 && $grossSales > 0) ? (($dailySales - $grossSales) / $grossSales) * 100 : 0;

// Prepare the response data
$response = [
    'daily_sales' => number_format((float)$dailySales, 2), // Format daily sales
    'gross_sales' => number_format((float)$grossSales, 2), // Format gross sales
    'percentage_change' => number_format((float)$percentageChange, 2) // Format percentage change
];

// Output the JSON response
echo json_encode($response);
?>