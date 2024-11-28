<?php
include 'connection.php'; 

$product_id = $_POST['product_id'];
$quantity = $_POST['quantity']; 

if (!isset($product_id) || !isset($quantity)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit;
}

$quantity = floatval($quantity);

// Fetch the current stock
$query = "SELECT Stocks FROM AddProducts WHERE ProductId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $product_id);
$stmt->execute();
$stmt->bind_result($current_stock);
$stmt->fetch();
$stmt->close();

if ($current_stock === null) {
    echo json_encode(['status' => 'error', 'message' => 'Product not found']);
    exit;
}

// Check if there is enough stock
if ($current_stock < $quantity) {
    echo json_encode(['status' => 'error', 'message' => 'Insufficient stock']);
    exit;
}

// Deduct stock
$new_stock = $current_stock - $quantity;
$query = "UPDATE AddProducts SET Stocks = ? WHERE ProductId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ds', $new_stock, $product_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update stock']);
}

$stmt->close();
$conn->close();
?>