<?php
header('Content-Type: application/json');

include 'connection.php';


$sql = "SELECT product_name, product_code, change_amount, reason, change_date FROM stock_history ORDER BY change_date DESC";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

echo json_encode($data);
?>