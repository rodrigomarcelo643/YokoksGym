<?php
include 'connection.php'; // Include your database connection

$sql = "SELECT 
            SUM(
                CASE 
                    WHEN CURDATE() >= membership_start 
                    THEN (DATEDIFF(CURDATE(), membership_start) + 1) * (total_cost / DATEDIFF(membership_due_date, membership_start)) 
                    ELSE 0 
                END
            ) AS total_daily_membership_cost
        FROM members
        WHERE membership_due_date >= CURDATE()";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

$totalDailyMembershipCost = $row['total_daily_membership_cost'];

// Return the total daily membership cost in JSON format
echo json_encode(['total_daily_cost' => $totalDailyMembershipCost]);

$conn->close();
?>