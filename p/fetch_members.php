<?php
include 'connection.php';

$sql = "SELECT * FROM members";
$result = $conn->query($sql);

$members = [];
$currentDate = new DateTime();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dueDate = new DateTime($row['membership_due_date']);
        
        // Determine membership status
        if ($currentDate > $dueDate) {
            $remainingTime = "<span class='expired-status'>Expired</span>";
        } else {
            $remainingTime = "<span class='active-status-green'>Active</span>";
        }

        // Check if added_by is null or empty, and set a fallback value
        $addedBy = !empty($row['added_by']) ? $row['added_by'] : "N/A";

        // Append member data including the staff who added them (with fallback for added_by)
        $members[] = [
            'id' => $row['id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'contact_number' => $row['contact_number'],
            'membership_type' => $row['membership_type'],
            'total_cost' => $row['total_cost'],
            'remaining_time' => $remainingTime,
            'membership_start' => $row['membership_start'], // Full datetime
            'membership_due_date' => $row['membership_due_date'], // Full datetime
            'added_by' => $addedBy // Fallback to "N/A" if added_by is empty
        ];
    }
}

$conn->close();
?>
