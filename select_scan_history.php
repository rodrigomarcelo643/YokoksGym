<?php 

include 'connection.php';

header('Content-Type: application/json'); // Set the response content type

if (isset($_GET['username']) && !empty($_GET['username'])) {
    $username = $conn->real_escape_string($_GET['username']); // Escape the username input

    // Get the page and limit from the query parameters
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Default to page 1 if not set
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10; // Default to 10 records per page

    // Calculate the starting limit
    $start = ($page - 1) * $limit;

    // Prepare the SQL statement with pagination
    $sql = "SELECT * FROM scanned_visits WHERE username = ? ORDER BY created_at DESC LIMIT ?, ?";
    
    // Prepare and bind the statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sii", $username, $start, $limit); // Bind the parameters
        $stmt->execute(); // Execute the statement  
        $result = $stmt->get_result(); // Get the result set

        // Fetch the results
        $response = [];
        while ($row = $result->fetch_assoc()) {
            $response[] = $row;
        }

        // Return the response as JSON
        echo json_encode($response);
        
        $stmt->close(); // Close the statement
    } else {
        echo json_encode(array("error" => "Failed to prepare statement: " . $conn->error));
    }
} else {
    echo json_encode(array("error" => "Username parameter is missing or empty."));
}

$conn->close(); // Close the database connection
?>
