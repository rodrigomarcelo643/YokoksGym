<?php
header('Content-Type: application/json');

include 'connection.php';

//=====SQL GROUPED 
$sql = "
    SELECT
        member_id,
        product_name,
        SUM(quantity) AS total_quantity,
        price,
        SUM(total) AS total_price
    FROM
        cart_items
    GROUP BY
        member_id,
        product_name,
        price
";

$result = $conn->query($sql);

$items = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}

echo json_encode($items);

?>