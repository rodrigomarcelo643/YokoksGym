<?php
// Database connection settings
include 'connection.php'; // Make sure this file has the correct connection code

// SQL query to get visit counts by date
$sql = "SELECT DATE(created_at) AS visit_date, COUNT(*) AS visit_count
        FROM scanned_visits
        GROUP BY DATE(created_at)
        ORDER BY DATE(created_at)";

$result = $conn->query($sql);

// Initialize arrays to hold the data for the graph
$dates = [];
$counts = [];

// Check if the query was successful and fetch data
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $dates[] = $row['visit_date'];
        $counts[] = $row['visit_count'];
    }
} else {
    echo "Error: " . $conn->error;
}

// Close connection
$conn->close();

// Convert PHP arrays to JSON format for use in JavaScript
$dates_json = json_encode($dates);
$counts_json = json_encode($counts);

// Output the complete HTML content with echo
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanned Visits Bar Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Add styles for the canvas to make it responsive */
        #visitsChart {
            width: 100% !important; /* Set canvas width to 100% */
            height: 600px; /* Set a specific height or auto for dynamic */
            max-height: 600px; /* Ensure maximum height */
        }
    </style>
</head>
<body style="padding:10px; background-color:transparent !important;">
    <h1 style="text-align:center;color:#124137;font-size:20px;font-weight:bold;">Overall Visits</h1>
    <canvas id="visitsChart"></canvas>
    <script>
        const labels = ' . $dates_json . '; // Dates from PHP
        const amounts = ' . $counts_json . '; // Visit counts from PHP

        // Find the maximum and second maximum values
        const sortedAmounts = [...amounts].sort((a, b) => b - a);
        const maxAmount = sortedAmounts[0];
        const secondMaxAmount = sortedAmounts[1];

        // Create gradient colors based on the values
        const ctx = document.getElementById("visitsChart").getContext("2d");

        const createGradient = (ctx, amount) => {
            if (amount === maxAmount) {
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, "rgba(255, 0, 0, 1)"); // Red for max
                gradient.addColorStop(1, "rgba(255, 100, 100, 1)"); // Lighter red
                return gradient;
            } else if (amount === secondMaxAmount) {
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
               gradient.addColorStop(0, "rgba(255, 165, 0, 1)");
               gradient.addColorStop(1, "rgba(255, 165, 0, 0.5)");
                return gradient;
            } else {
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
             gradient.addColorStop(0, "#009b7b"); // Main color for others
                gradient.addColorStop(1, "#66d9c8");
                return gradient;
            }
        };

        const data = {
            labels: labels,
            datasets: [{
                label: "Yokoks Visits",
                data: amounts,
                backgroundColor: amounts.map((amount) => createGradient(ctx, amount)),
                borderColor: "transparent",
                borderWidth: 0,
                borderRadius: 6 // Rounded corners
            }]
        };

        const config = {
            type: "bar",
            data: data,
            options: {
                responsive: true, // Make the chart responsive
                maintainAspectRatio: false, // Do not maintain the original aspect ratio
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: `Last Updated: ${new Date().toLocaleString()}`, // Display last updated time
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || "";
                                if (label) {
                                    label += ": ";
                                }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y; // Show visit count
                                }
                                return label;
                            },
                        },
                    },
                    legend: {
                        display: true,
                    },
                },
                layout: {
                    padding: 20,
                },
            }
        };

        const visitsChart = new Chart(ctx, config);
    </script>
</body>
</html>';
?>
