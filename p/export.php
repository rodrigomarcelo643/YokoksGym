<?php
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include 'connection.php'; 

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session to access logged-in user's information
session_start();

// Assuming you have the user's first and last name stored in session variables
$loggedInFirstName = isset($_SESSION['firstName']) ? $_SESSION['firstName'] : 'Unknown';
$loggedInLastName = isset($_SESSION['lastName']) ? $_SESSION['lastName'] : 'User';

// Fetch the data from your expenses table
$query = "SELECT date, description, amount, type FROM expenses"; // Adjusted columns
$result = $conn->query($query); // Use $conn instead of $mysqli

if (!$result) {
    die("Query failed: " . $conn->error); // Use $conn here as well
}

// Create a new Spreadsheet object
try {
    $spreadsheet = new Spreadsheet();
} catch (Exception $e) {
    echo 'Error: ',  $e->getMessage(), "\n";
    exit;
}

// Set the header row
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Date');
$sheet->setCellValue('B1', 'Description');
$sheet->setCellValue('C1', 'Amount');
$sheet->setCellValue('D1', 'Type');
$sheet->setCellValue('E1', 'First Name'); // Moved to E1
$sheet->setCellValue('F1', 'Last Name');  // Moved to F1

// Populate the sheet with data
$rowNum = 2; // Start from the second row
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $rowNum, $row['date']);
    $sheet->setCellValue('B' . $rowNum, $row['description']);
    $sheet->setCellValue('C' . $rowNum, $row['amount']);
    $sheet->setCellValue('D' . $rowNum, $row['type']);
    $sheet->setCellValue('E' . $rowNum, $loggedInFirstName); // Use logged-in user's first name
    $sheet->setCellValue('F' . $rowNum, $loggedInLastName);  // Use logged-in user's last name
    $rowNum++;
}

// Close the database connection
$conn->close(); // Use $conn here as well

// Set the filename to include today's date, time, and the user's name
$date = date('Y-m-d'); // Format: YYYY-MM-DD
$time = date('H-i-s'); // Format: HH-MM-SS
$filename = "exported_by_{$loggedInFirstName}_{$loggedInLastName}_{$date}_{$time}.xlsx"; // New filename format

// Set the headers to trigger the Excel download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\""); // Change to attachment for download
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Pragma: public');
header('Expires: 0');

// Write the file to the output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
