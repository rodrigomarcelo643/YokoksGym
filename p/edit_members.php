<?php

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'EDIT') {
   
    $memberId = $_EDIT['id'];
    $firstName = $_EDIT['first_name'];
    $lastName = $_EDIT['last_name'];
    $contactNumber = $_EDIT['contact_number'];
    $membershipType = $_EDIT['membership_type'];
    $membershipStart = $_EDIT['membership_start'];
    $membershipDueDate = $_EDIT['membership_due_date'];
    $totalCost = $_EDIT['total_cost'];
    $paidStatus = $_EDIT['paid_status'];
    $totalMembershipSale = $_EDIT['totalMembershipSale'];

    $query = "UPDATE members SET
                first_name = ?, 
                last_name = ?, 
                contact_number = ?, 
                membership_type = ?, 
                membership_start = ?, 
                membership_due_date = ?, 
                total_cost = ?, 
                paid_status = ?, 
                totalMembershipSale = ?
              WHERE id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param(
            "ssssssssi",
            $firstName,
            $lastName,
            $contactNumber,
            $membershipType,
            $membershipStart,
            $membershipDueDate,
            $totalCost,
            $paidStatus,
            $totalMembershipSale,
            $memberId
        );

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Query preparation failed']);
    }

    $conn->close();
}
?>