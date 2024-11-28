<?php
header('Content-Type: application/json');

// Include the database connection file
include 'connection.php';

// Retrieve the username from the request
if (isset($_POST['username'])) {
    $user = $_POST['username'];

    // Use a prepared statement with MySQLi
    $query = "SELECT * FROM workouts WHERE username = ? ORDER BY date_added DESC";
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameter
        $stmt->bind_param('s', $user);
        // Execute the statement
        $stmt->execute();
        // Get the result
        $result = $stmt->get_result();

        // Fetch all workouts as an associative array
        $workouts = $result->fetch_all(MYSQLI_ASSOC);

        // Output the workouts as JSON
        echo json_encode($workouts);

        // Close the statement
        $stmt->close();
    } else {
        // Handle query preparation error
        echo json_encode(['error' => 'Query preparation failed: ' . $conn->error]);
    }
} else {
    echo json_encode(['error' => 'No username provided']);
}

// Close the database connection
$conn->close();
?>
