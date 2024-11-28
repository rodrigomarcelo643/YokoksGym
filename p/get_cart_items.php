<?php
include 'connection.php';

// Get the member_id from the request
$member_id = intval($_GET['member_id']);

// Prepare the SQL query to fetch cart items for the specific member
$sql = "SELECT ci.*, m.first_name, m.last_name 
        FROM cart_items ci 
        JOIN members m ON ci.member_id = m.id 
        WHERE ci.member_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $member_id);
$stmt->execute();

$result = $stmt->get_result();
$items = [];

// Fetch data and store it in an array
while ($row = $result->fetch_assoc()) {
    $items[] = [
        'member_id' => $row['member_id'],
        'member_name' => $row['first_name'] . ' ' . $row['last_name'],
        'product_id' => $row['product_id'],
        'product_name' => $row['product_name'],
        'quantity' => $row['quantity'],
        'price' => $row['price'],
        'total' => $row['total']
    ];
}

// Return the result as JSON
header('Content-Type: application/json');
echo json_encode($items);

// Close connections
$stmt->close();
$conn->close();
?>