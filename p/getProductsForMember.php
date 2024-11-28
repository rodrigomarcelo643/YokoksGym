<?php
// Include the database connection file
include 'connection.php'; // Assumes connection.php contains a MySQLi connection setup

// Get memberId from the request
$memberId = $_GET['memberId'];

// Prepare the SQL query to get products based on memberId
$query = "SELECT ProductName, ProductId, Price, Stocks, image FROM AddProducts WHERE member_id = ?";

// Initialize the statement
$stmt = $conn->prepare($query); // Assuming $conn is the MySQLi connection variable in connection.php

// Bind the parameter to the statement
$stmt->bind_param('i', $memberId); // 'i' stands for integer, adjust according to the type of member_id

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch all products as an associative array
$products = $result->fetch_all(MYSQLI_ASSOC);

// Return the products as a JSON response
echo json_encode($products);

// Close the statement and connection
$stmt->close();
$conn->close();
?>