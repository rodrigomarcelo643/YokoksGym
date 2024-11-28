<?php
header('Content-Type: application/json');
include 'connection.php';

$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($productId > 0) {
    $stmt = $conn->prepare("SELECT id, ProductName, ProductId, units as ProductUnits, Price, Stocks, ProductType FROM AddProducts WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode($product);
    } else {
        echo json_encode(array("error" => "Product not found"));    
    }

    $stmt->close();
} else {
    echo json_encode(array("error" => "Invalid product ID")); 
}

$conn->close();
?>