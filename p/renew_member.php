<?php
header('Content-Type: application/json');

include 'connection.php';
if ($conn->connect_error) {
    die(json_encode(['error' => "Connection failed: " . $conn->connect_error]));
}

// Function to calculate due date based on membership type
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
    return $dueDate->format('Y-m-d');
}

// Prepare the SQL statement to update the member
$stmt = $conn->prepare("UPDATE members SET membership_type = ?, membership_due_date = ?, total_cost = ? WHERE first_name = ? AND last_name = ? AND contact_number = ?");

if (!$stmt) {
    die(json_encode(['error' => "Prepare failed: " . $conn->error]));
}

// Get POST data
$membershipType = $_POST['renewMembershipType'];
$membershipStart = date('Y-m-d');
$membershipDueDate = calculateDueDate($membershipStart, $membershipType);
$totalCost = $_POST['renewTotalCost'];
$firstName = $_POST['renewFirstName'];
$lastName = $_POST['renewLastName'];
$contactNumber = $_POST['renewContactNumber'];

// Bind parameters
$stmt->bind_param("ssssss", $membershipType, $membershipDueDate, $totalCost, $firstName, $lastName, $contactNumber);

// Execute the statement
if ($stmt->execute()) {
    // Update daily_sales table for today
    $today = date('Y-m-d');

    $insertSalesQuery = "INSERT INTO daily_sales (renewal_date, sales_count)
                         VALUES (?, 1)
                         ON DUPLICATE KEY UPDATE sales_count = sales_count + 1";

    if ($insertSalesStmt = $conn->prepare($insertSalesQuery)) {
        $insertSalesStmt->bind_param("s", $today);

        if (!$insertSalesStmt->execute()) {
            echo json_encode(['error' => "Failed to record today's sales: " . $insertSalesStmt->error]);
            $insertSalesStmt->close();
            $stmt->close();
            $conn->close();
            exit();
        }
        $insertSalesStmt->close();
    } else {
        echo json_encode(['error' => "Failed to prepare today's sales statement: " . $conn->error]);
        $stmt->close();
        $conn->close();
        exit();
    }

    // Return updated member information
    $updatedMember = [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'contact_number' => $contactNumber,
        'membership_type' => $membershipType,
        'membership_start' => $membershipStart,
        'membership_due_date' => $membershipDueDate,
        'total_cost' => $totalCost,
    ];
    echo json_encode($updatedMember);
} else {
    echo json_encode(['error' => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>