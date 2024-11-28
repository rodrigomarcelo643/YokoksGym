<?php
// fetch_staff_members.php
function fetchStaffMembers() {
    include 'connection.php'; // Include your database connection

    $query = "SELECT first_name, last_name FROM addstaff";
    $result = $conn->query($query);

    $staffMembers = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $staffMembers[] = $row;
        }
    }
    return $staffMembers;
}

// Call the function to get staff members
$staffMembers = fetchStaffMembers();
?>