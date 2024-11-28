<?php

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['ProductName'];
    $productId = $_POST['ProductId'];
    $productType = $_POST['ProductType'];
    $productStocks = $_POST['ProductStocks'];
    $productPrice = $_POST['ProductPrice'];
    $productUnits = $_POST['Units'];


    $image = null;
    if (isset($_FILES['UploadFile']) && $_FILES['UploadFile']['error'] == UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['UploadFile']['tmp_name']);
    }

    $stmt = $conn->prepare("SELECT COUNT(*) FROM AddProducts WHERE ProductName = ? OR ProductId = ?");
    $stmt->bind_param("ss", $productName, $productId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo json_encode(['success' => TRUE ]);
        echo "<script>
            alert('Error: Product Name or Product ID already exists.');
        </script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO AddProducts (ProductName, units, ProductId, ProductType, Price, Stocks, image) VALUES (?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssis", $productName, $productUnits, $productId, $productType, $productPrice, $productStocks, $image, );

        if ($stmt->execute()) {
       
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

?>