<?php
require 'connection.php'; // Ensure to include your database connection file

// Get the member ID from the request
$memberId = $_GET['member_id'] ?? null;

if ($memberId) {
    // Start a transaction
    mysqli_begin_transaction($conn);

    try {
        // Move the items to a debt table
        // You may need to adjust the columns in the INSERT statement as per your debt table structure
        $insertQuery = "INSERT INTO debt_items (member_id, product_name, quantity, total)
                         SELECT member_id, product_name, quantity, total FROM cart_items WHERE member_id = ?";
        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, 'i', $memberId);
        mysqli_stmt_execute($stmt);

        // Check if rows were inserted
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Now delete the items from the cart_items table
            $deleteQuery = "DELETE FROM cart_items WHERE member_id = ?";
            $deleteStmt = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($deleteStmt, 'i', $memberId);
            mysqli_stmt_execute($deleteStmt);

            // Commit the transaction
            mysqli_commit($conn);

            echo json_encode(['success' => true, 'message' => 'Items marked as debt successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No items moved to debt.']);
        }

        // Close the prepared statements
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($deleteStmt);
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        mysqli_rollback($conn);
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Member ID is required.']);
}

// Close the database connection
mysqli_close($conn);
?>