<?php
    include 'connection.php';
    $sql = "SELECT * FROM cart_items WHERE member_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $member_id); // assuming you have the member_id
    $stmt->execute();
    $result = $stmt->get_result();

    $cartItems = [];
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }

    $stmt->close();
    $conn->close();

    // Return as JSON
    echo json_encode($cartItems);
?>