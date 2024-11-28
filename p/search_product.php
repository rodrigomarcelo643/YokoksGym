<?php
include 'connection.php';

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Adjust SQL query to include products with zero stocks
$sql = "SELECT id, ProductName, ProductId, units AS ProductUnits, Price, Stocks, ProductType FROM AddProducts WHERE Stocks >= 0";

if (!empty($searchQuery)) {
    $searchQuery = '%' . $conn->real_escape_string(strtolower($searchQuery)) . '%';
    $sql .= " AND (LOWER(ProductName) LIKE ? OR LOWER(ProductId) LIKE ?)";
}

$stmt = $conn->prepare($sql);

if (!empty($searchQuery)) {
    $stmt->bind_param("ss", $searchQuery, $searchQuery);
}

$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    // Format the Price to two decimal places
    $row['Price'] = number_format((float)$row['Price'], 2, '.', '');
    $products[] = $row;
}

header('Content-Type: application/json');
echo json_encode($products);
?>