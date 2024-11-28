<?php
include 'connection.php';

$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($productId <= 0) {
    echo json_encode(['error' => 'Invalid product ID']);
    exit;
}

$conn->begin_transaction();

try {

    $sql = "DELETE FROM stock_history WHERE product_id = $productId";
    $conn->query($sql);

    // Delete the product
    $sql = "DELETE FROM AddProducts WHERE id = $productId";
    $conn->query($sql);

    $conn->commit();
    echo json_encode(['success' => 'Product deleted successfully']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['error' => 'Error deleting product: ' . $e->getMessage()]);
}

$conn->close();
?>