<?php
// deduct_stock.php
include 'connection.php';

// Prepare and execute deduction for each item in the cart
foreach ($_POST['items'] as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];

    // Prepare the SQL statement to update the stock
    $sql = "UPDATE AddProducts SET Stocks = Stocks - ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $quantity, $product_id);

    // Execute the statement and check for success
    if (!$stmt->execute()) {
        echo json_encode(["status" => "error", "message" => "Failed to update stock for product ID: $product_id"]);
        exit; // Exit on first failure
    }
}

echo json_encode(["status" => "success"]);
$stmt->close();
$conn->close();
?>