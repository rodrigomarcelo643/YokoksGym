<?php
header('Content-Type: application/json');

include 'connection.php';

$member_id = isset($_GET['member_id']) ? intval($_GET['member_id']) : 0;

$sql = "SELECT * FROM AddProducts WHERE member_id = $member_id";
$result = $conn->query($sql);

$items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items[] = [
            'id' => $row['id'],
            'name' => htmlspecialchars($row['ProductName']),
            'price' => htmlspecialchars($row['Price']),
            'imgSrc' => !empty($row['image']) ? 'data:image/jpeg;base64,' . base64_encode($row['image']) : 'path/to/default/image.jpg'
        ];
    }
}

$conn->close();
echo json_encode($items);
?>