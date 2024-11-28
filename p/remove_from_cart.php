<?php
header('Content-Type: application/json');

include 'connection.php';

// Check if the required POST data is available
if (!isset($_POST['member_id'], $_POST['product_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Required data is missing']);
    exit;
}

$member_id = $_POST['member_id'];
$product_id = $_POST['product_id'];

// Prepare the SQL statement to delete the cart item
$sql = "DELETE FROM cart_items WHERE member_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $member_id, $product_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Item removed from cart']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to remove item from cart']);
}

$stmt->close();
$conn->close();
?>