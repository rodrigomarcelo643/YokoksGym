<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'connection.php'; 

header('Content-Type: application/json'); 

$memberId = $_GET['member_id'] ?? null;

$items = json_decode(file_get_contents("php://input"), true);

if ($memberId) {
    mysqli_begin_transaction($conn);

    try {
        $update_query = "UPDATE members SET paid_status = 'paid' WHERE id = ?";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, 'i', $memberId);

        if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0) {

            if (is_array($items) && count($items) > 0) {
    
                $insert_success = true; 

                foreach ($items as $item) {
                    $insert_query = "INSERT INTO sales (member_id, product_name, quantity, total) VALUES (?, ?, ?, ?)";
                    $insert_stmt = mysqli_prepare($conn, $insert_query);
                    mysqli_stmt_bind_param($insert_stmt, 'isid', $memberId, $item['product_name'], $item['quantity'], $item['total']);

                    // Execute the insert statement
                    if (!mysqli_stmt_execute($insert_stmt)) {
                        $insert_success = false; // Mark as failed if any insert fails
                        mysqli_stmt_close($insert_stmt);
                        break; // Exit the loop on failure
                    }
                    mysqli_stmt_close($insert_stmt);
                }

                // Step 2: Delete existing cart items for the member only if insert was successful
                if ($insert_success) {
                    $delete_query = "DELETE FROM cart_items WHERE member_id = ?";
                    $delete_stmt = mysqli_prepare($conn, $delete_query);
                    mysqli_stmt_bind_param($delete_stmt, 'i', $memberId);
                    mysqli_stmt_execute($delete_stmt);

                    // Commit the transaction
                    mysqli_commit($conn);
                    echo json_encode(['success' => true, 'message' => 'Member status marked as paid, new sales recorded, and cart items deleted successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to insert sales data.']);
                    mysqli_rollback($conn); // Rollback if insert fails
                }

                mysqli_stmt_close($delete_stmt);
            } else {
                echo json_encode(['success' => false, 'message' => 'No valid items provided.']);
                mysqli_rollback($conn); // Rollback if no items are provided
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No member status updated.']);
            mysqli_rollback($conn); // Rollback if member status is not updated
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
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