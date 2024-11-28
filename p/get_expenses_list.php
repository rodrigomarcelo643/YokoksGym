<?php
header('Content-Type: application/json');

// Include the database connection file
include 'connection.php'; // Ensure this file contains your database connection logic

// Get filter parameters from the request, ensuring safe access
$date = isset($_GET['date']) ? $_GET['date'] : '';
$staffName = isset($_GET['staffName']) ? $_GET['staffName'] : '';

// Prepare the base SQL query
$sql = "SELECT 
            id, 
            DATE_FORMAT(date, '%M %d, %Y') AS date, 
            image, 
            description, 
            type, 
            supplier, 
            amount, 
            CONCAT(first_name, ' ', last_name) AS full_name 
        FROM expenses 
        WHERE 1=1"; // Default condition to allow appending filters

$params = []; // Array to hold parameters for the prepared statement

// Add exact date filter if provided
if (!empty($date)) {
    $sql .= " AND DATE(date) = ?";
    $params[] = $date; // Add the date parameter
}

// Add staff full name filter if provided
if (!empty($staffName)) {
    $sql .= " AND CONCAT(first_name, ' ', last_name) LIKE ?";
    $params[] = '%' . $staffName . '%'; // Prepare like statement for staff name
}

// Append order by clause
$sql .= " ORDER BY date DESC"; // Order by date in descending order

// Prepare the statement
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Bind parameters
    if ($params) {
        // Dynamically bind parameters based on count
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    }

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    $expenses = [];
    while ($row = $result->fetch_assoc()) {
        // If an image is present, encode it as base64
        if (!empty($row['image'])) {
            $imageData = base64_encode($row['image']);
            $row['image'] = 'data:image/jpeg;base64,' . $imageData;
        } else {
            $row['image'] = null;
        }
        $expenses[] = $row;
    }

    echo json_encode($expenses);
} else {
    echo json_encode(['error' => 'Failed to prepare statement: ' . $conn->error]);
}

$stmt->close(); // Close the statement
$conn->close(); // Close the connection
?>
