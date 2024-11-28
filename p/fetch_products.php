<?php
include 'connection.php';

function sanitizeId($id) {
    return preg_replace('/[^a-zA-Z0-9_-]/', '_', $id);
}

function highlightSearchTerm($text, $searchTerm) {
    $searchTerm = preg_quote($searchTerm, '/');
    return preg_replace('/('.$searchTerm.')/iu', '<mark>$1</mark>', $text);
}

// Pagination setup
$itemsPerPage = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

// Search setup
$searchTerm = isset($_GET['search']) ? strtolower($_GET['search']) : '';

// Fetch products with pagination
$sql = "SELECT * FROM AddProducts LIMIT $itemsPerPage OFFSET $offset";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Similar code to output each product row
        // Ensure to echo the same HTML structure for each row
    }
} else {
    echo "<tr><td colspan='6'>No products found</td></tr>";
}

$conn->close();
?>