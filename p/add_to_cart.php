<?php
header('Content-Type: application/json');

// Include database connection
include 'connection.php';

$member_id = $_POST['member_id'];
$member_name = $_POST['member_name'];
$items = json_decode($_POST['items'], true); // Decode the JSON string into an array

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid items data']);
    exit;
}

// Process each item in the cart
foreach ($items as $item) {
    $product_id = $item['product_id'];
    $product_name = $item['product_name'];
    $quantity = $item['quantity'];
    $price = $item['price'];
    $total = $item['total'];

    // Check stock availability
    $sql = "SELECT Stocks FROM AddProducts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    
    $stmt->bind_param('i', $product_id); // 'i' for integer
    $stmt->execute();
    $stmt->bind_result($stock);
    $stmt->fetch();
    $stmt->close();

    if ($stock === null) {
        echo json_encode(['status' => 'error', 'message' => 'Product not found for ID: ' . $product_id]);
        $conn->close();
        exit;
    }

    if ($stock < $quantity) {
        echo json_encode(['status' => 'error', 'message' => 'Insufficient stock for product ID: ' . $product_id]);
        $conn->close();
        exit;
    }

    // Insert the item into the cart
    $sql = "INSERT INTO cart_items (member_id, product_id, product_name, quantity, price, total, member_name) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    
    // Use correct data types: 'i' for integers, 'd' for float, 's' for strings
    $stmt->bind_param('iisiiss', $member_id, $product_id, $product_name, $quantity, $price, $total, $member_name);

    if (!$stmt->execute()) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add item to cart for product ID: ' . $product_id . '. Error: ' . $stmt->error]);
        $stmt->close();
        $conn->close();
        exit;
    }

    // Update the stock for the product
    $sql = "UPDATE AddProducts SET Stocks = Stocks - ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    
    $stmt->bind_param('ii', $quantity, $product_id); // 'i' for integers
    $stmt->execute();
}

// Return success response
echo json_encode(['status' => 'success', 'message' => 'Items added to cart successfully']);
$stmt->close();
$conn->close();
?>