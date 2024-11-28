<?php
include 'connection.php'; // Include your database connection

// Fetch all QR code images from the database
function fetchQrImagesFromDatabase() {
    global $conn;

    $stmt = $conn->prepare("SELECT image FROM images");
    $stmt->execute();
    $stmt->bind_result($imageData);

    $images = array();
    while ($stmt->fetch()) {
        $images[] = base64_encode($imageData); // Convert image data to base64 for easy comparison
    }
    $stmt->close();

    // Return the images as a JSON array
    return json_encode($images);
}

// Output the QR images as JSON
header('Content-Type: application/json');
echo fetchQrImagesFromDatabase();
?>
