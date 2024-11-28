<?php
include 'connection.php'; // Ensure this file establishes a MySQLi connection using `$conn`

// Fetch POST data
$data = $_POST;
$memberId = isset($data['member_id']) ? intval($data['member_id']) : 0;
$itemsJson = isset($data['items']) ? $data['items'] : '[]';

// Decode the JSON array
$items = json_decode($itemsJson, true);

if (!is_array($items)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid items data']);
    exit;
}

try {
    // Begin transaction
    $conn->begin_transaction();

    // Prepare the SQL statement
    $stmt = $conn->prepare("
        INSERT INTO cart_items (member_id, product_id, product_name, quantity, price, total)
        VALUES (?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            quantity = VALUES(quantity),
            price = VALUES(price),
            total = VALUES(total)
    ");

    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    // Bind parameters: "i" for integer, "d" for double, "s" for string
    foreach ($items as $item) {
        $productId = intval($item['product_id']);
        $productName = $item['product_name'];
        $quantity = intval($item['quantity']);
        $price = floatval($item['price']);
        $total = floatval($item['total']);

        // Bind values
        $stmt->bind_param("iisdid", $memberId, $productId, $productName, $quantity, $price, $total);

        // Execute the prepared statement
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
    }

    // Commit the transaction
    $conn->commit();

    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => 'Failed to update cart: ' . $e->getMessage()]);
} finally {
    $stmt->close();
    $conn->close();
}
?>