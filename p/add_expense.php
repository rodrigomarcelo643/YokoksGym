<?php
include 'connection.php';
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['staffUsername'])) {
    header("Location: L.php");
    exit();
}

// Retrieve staff details from session
$firstName = htmlspecialchars($_SESSION['firstName']);
$lastName = htmlspecialchars($_SESSION['lastName']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data and trim input
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $amount = isset($_POST['amount']) ? trim($_POST['amount']) : '';
    $type = isset($_POST['type']) ? trim($_POST['type']) : '';
    $supplier = isset($_POST['supplier']) ? trim($_POST['supplier']) : ''; // Retrieve supplier

    // Validate inputs
    if (empty($description) || !is_numeric($amount) || $amount <= 0 || empty($type) || empty($supplier)) {
        echo json_encode(['success' => false, 'message' => "Invalid input data"]);
        exit();
    }

    // Initialize image variable
    $imageData = null; // Initialize variable for the image data

    // Handle file upload
    if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] == UPLOAD_ERR_OK) {
        // Set maximum file size to 512 KiB
        $maxFileSize = 10201201021* 1212121024;

        // Check file size
        if ($_FILES['imageUpload']['size'] > $maxFileSize) {
            echo json_encode(['success' => false, 'message' => "File size exceeds 512 KiB."]);
            exit();
        }

        // Read the file contents into a variable
        $imageData = file_get_contents($_FILES['imageUpload']['tmp_name']);
    } else {
        echo json_encode(['success' => false, 'message' => "File upload error: " . $_FILES['imageUpload']['error']]);
        exit();
    }

    $date = date('Y-m-d');

    // Prepare SQL statement to insert expense including supplier
    $sql = "INSERT INTO expenses (description, amount, date, type, supplier, first_name, last_name, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => "Error preparing statement: " . $conn->error]);
        exit();
    }

    // Bind parameters
    $stmt->bind_param("sdssssss", $description, $amount, $date, $type, $supplier, $firstName, $lastName, $imageData);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => "Expense added successfully"]);
    } else {
        echo json_encode(['success' => false, 'message' => "Error: " . $stmt->error]);
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>