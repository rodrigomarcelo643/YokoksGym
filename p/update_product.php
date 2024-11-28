<?php
header('Content-Type: application/json');

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $productName = $conn->real_escape_string($_POST['ProductName']);
    $productId = $conn->real_escape_string($_POST['ProductId']);
    $price = floatval($_POST['Price']);
    $stocks = intval($_POST['Stocks']);
    $productType = $conn->real_escape_string($_POST['ProductType']);
    $productUnits = $conn->real_escape_string($_POST['Units']);
    $stockReason = isset($_POST['stockReason']) ? $conn->real_escape_string($_POST['stockReason']) : '';


    $currentStockQuery = "SELECT Stocks, ProductName, ProductId FROM AddProducts WHERE id = ?";
    $currentStockStmt = $conn->prepare($currentStockQuery);
    $currentStockStmt->bind_param("i", $id);
    $currentStockStmt->execute();
    $currentStockResult = $currentStockStmt->get_result();
    $currentStockRow = $currentStockResult->fetch_assoc();
    $currentStock = intval($currentStockRow['Stocks']);
    $currentProductName = $currentStockRow['ProductName'];
    $currentProductId = $currentStockRow['ProductId'];
    $currentStockStmt->close();

    // Update the product
    $query = "UPDATE AddProducts 
              SET ProductName = ?, ProductId = ?, units = ?, Price = ?, Stocks = ?, ProductType = ?
              WHERE id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die(json_encode(["success" => false, "error" => "Prepare failed: " . $conn->error]));
    }

    $stmt->bind_param("sssdssi", $productName, $productId, $productUnits, $price, $stocks, $productType, $id);
    if ($stmt->execute()) {
        if ($stocks !== $currentStock && !empty($stockReason)) {
            // Insert into stock history
            $historyQuery = "INSERT INTO stock_history (product_id, product_name, product_code, change_amount, reason, change_date) VALUES (?, ?, ?, ?, ?, NOW())";
            $historyStmt = $conn->prepare($historyQuery);
            if ($historyStmt === false) {
                die(json_encode(["success" => false, "error" => "Prepare failed: " . $conn->error]));
            }
            $changeAmount = $stocks - $currentStock;
            $historyStmt->bind_param("issis", $id, $currentProductName, $currentProductId, $changeAmount, $stockReason);
            $historyStmt->execute();
            $historyStmt->close();
        }

        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>