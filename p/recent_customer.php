<?php
include 'connection.php';

$sql = "SELECT first_name, last_name, membership_type, total_cost
        FROM members
        ORDER BY id DESC
        LIMIT 10";

$result = $conn->query($sql);

$rows = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Check if membership_type is not empty
        if (!empty($row['membership_type'])) {
            $rows[] = $row;
        }
    }

    // Reverse the array to show the most recent first
    $rows = array_reverse($rows);

    // Check if there are valid rows to display
    if (count($rows) > 0) {
        // Output data of each row
        foreach ($rows as $row) {
            $membershipType = htmlspecialchars($row['membership_type']);
            $color = ''; // Default color
            switch ($membershipType) {
                case 'Daily Basic':
                    $color = 'green';
                    break;
                case 'Daily Pro':
                    $color = 'darkorange';
                    break;
                case 'Monthly Basic':
                    $color = 'violet';
                    break;
                case 'Monthly Pro':
                    $color = 'blue';
                    break;
                default:
                    $color = 'black';
                    break;
            }

            // Format total_cost to two decimal places
            $totalCost = number_format((float)$row['total_cost'], 2, '.', '');

            // Output row
            echo "<tr style='background-color:white!important'>";
            echo "<td class='px-4 py-2'>" . htmlspecialchars($row['membership_type']) . "</td>";
            echo "<td class='px-4 py-2 flex items-center'>
                    <img src='../Assets/default_profile_image.png' style='margin-right:10px;' class='w-8 h-8 inline-block rounded-full' alt='Profile Image'>
                    " . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "
                  </td>";
            echo "<td class=' px-4 py-2'>
                    <div class='flex items-center'>
                      <img src='../Assets/pesos.png' style='width: 20px; height: 20px;' class='mr-2' alt='Money Icon'>
                      <span style='color: $color;'>" . htmlspecialchars($totalCost) . "</span>
                    </div>
                  </td>";
            echo "</tr>";
        }
    } else {
        // If no members with a membership type, display message
        echo "<tr><td colspan='3' class='border px-4 py-2 text-center'>No members with a valid membership type found.</td></tr>";
    }
} else {
    // If the query returns no results
    echo "<tr><td colspan='3' class='border px-4 py-2 text-center'>No recent customers found</td></tr>";
}

// Close the database connection
$conn->close();
?>