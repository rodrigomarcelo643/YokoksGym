<?php
header('Content-Type: application/json');

// Include the database connection file
include 'connection.php'; // Ensure this file contains your database connection logic

// Get the ID of the expense to delete
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM expenses WHERE id = ?");
    
    if ($stmt) {
        $stmt->bind_param("i", $id); // "i" indicates that the parameter is an integer

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Expense deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete expense.']);
        }

        $stmt->close(); // Close the statement
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare the SQL statement.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID parameter is missing.']);
}

// Close the database connection
$conn->close();
?>