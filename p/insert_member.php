<?php
session_start();

header('Content-Type: application/json');

include 'connection.php';

// Check if the staff is logged in
if (!isset($_SESSION['staffUsername'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit();
}

// Get the staff's full name from session
$staffFullName = htmlspecialchars($_SESSION['firstName'] . ' ' . $_SESSION['lastName']);

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO members (first_name, last_name, contact_number, membership_type, membership_start, membership_due_date, total_cost, added_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$contactNumber = $_POST['contactNumber'];
$membershipType = $_POST['membershipType'];

// Get the current date and time
$membershipStart = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD HH:MM:SS
$membershipDueDate = calculateDueDate($membershipStart, $membershipType);
$totalCost = $_POST['totalCost'];

// Bind parameters to the SQL statement
$stmt->bind_param("ssssssss", $firstName, $lastName, $contactNumber, $membershipType, $membershipStart, $membershipDueDate, $totalCost, $staffFullName);

if ($stmt->execute()) {
    $newMember = [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'contact_number' => $contactNumber,
        'membership_type' => $membershipType,
        'membership_start' => $membershipStart,
        'membership_due_date' => $membershipDueDate,
        'total_cost' => $totalCost,
        'added_by' => $staffFullName,
    ];
    echo json_encode($newMember);
} else {
    echo json_encode(['error' => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();

function calculateDueDate($startDate, $type) {
    $startDate = new DateTime($startDate);

    switch ($type) {
        case 'daily-basic':
        case 'daily-pro':
            $dueDate = $startDate->add(new DateInterval('P1D'));
            break;
        case 'monthly-basic':
        case 'monthly-pro':
            $dueDate = $startDate->add(new DateInterval('P1M'));
            break;
        default:
            $dueDate = $startDate;
            break;
    }
    return $dueDate->format('Y-m-d H:i:s'); // Ensure this returns the full datetime format
}
?>