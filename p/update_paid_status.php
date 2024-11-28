<?php
// Include database connection file
include 'connection.php';

// Get the JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['memberId']) && isset($data['paid_status'])) {
    $memberId = $data['memberId'];
    $paidStatus = $data['paid_status'];

    // Begin transaction
    mysqli_begin_transaction($conn);

    try {
        // Prepare the update statement for the members table
        $updateStatement = $conn->prepare("UPDATE members SET paid_status = ? WHERE id = ?");
        $updateStatement->bind_param("si", $paidStatus, $memberId);
        $updateStatement->execute();

        // Check if the update was successful
        if ($updateStatement->affected_rows > 0) {
            // Determine whether to log in sales or debts table
            if ($paidStatus === "paid") {
                // Log the sale
                $insertSale = $conn->prepare("INSERT INTO sales (member_id, sale_time, total) VALUES (?, NOW(), (SELECT total_cost FROM members WHERE id = ?))");
                $insertSale->bind_param("ii", $memberId, $memberId);
                $insertSale->execute();
            } else {
                // Log the debt
                $insertDebt = $conn->prepare("INSERT INTO debt (member_id, debt_time, total) VALUES (?, NOW(), (SELECT total_cost FROM members WHERE id = ?))");
                $insertDebt->bind_param("ii", $memberId, $memberId);
                $insertDebt->execute();
            }

            // Commit the transaction
            mysqli_commit($conn);
            echo json_encode(['success' => true]);
        } else {
            throw new Exception("Failed to update paid status.");
        }
    } catch (Exception $e) {
        // Roll back the transaction if something failed
        mysqli_rollback($conn);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}
?>