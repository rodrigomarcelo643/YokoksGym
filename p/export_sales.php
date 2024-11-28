<?php
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include 'connection.php'; 

session_start();

// Assuming you have the user's first and last name stored in session variables
$loggedInFirstName = isset($_SESSION['firstName']) ? $_SESSION['firstName'] : 'Unknown';
$loggedInLastName = isset($_SESSION['lastName']) ? $_SESSION['lastName'] : 'User';

// Prepare to fetch data for the exported file
$productsQuery = "SELECT ProductName, Price, Stocks FROM AddProducts"; // Use the new table name
$result = $conn->query($productsQuery); 

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the header row
$sheet->setCellValue('A1', 'Product Name');
$sheet->setCellValue('B1', 'Price');
$sheet->setCellValue('C1', 'Start Quantity');
$sheet->setCellValue('D1', 'End Quantity');
$sheet->setCellValue('E1', 'Quantity Sold');
$sheet->setCellValue('F1', 'Sales');
$sheet->setCellValue('G1', 'First Name'); // User's first name
$sheet->setCellValue('H1', 'Last Name');  // User's last name

$rowNum = 2; // Start from the second row

while ($row = $result->fetch_assoc()) {
    $startQuantity = $row['Stocks'];
    $endQuantity = $startQuantity; // This can be changed as per user input
    $quantitySold = 0; // Default to 0
    $sales = $quantitySold * $row['Price']; // Calculate sales

    // Fill the spreadsheet with data
    $sheet->setCellValue('A' . $rowNum, $row['ProductName']);
    $sheet->setCellValue('B' . $rowNum, $row['Price']);
    $sheet->setCellValue('C' . $rowNum, $startQuantity);
    $sheet->setCellValue('D' . $rowNum, $endQuantity);
    $sheet->setCellValue('E' . $rowNum, $quantitySold);
    $sheet->setCellValue('F' . $rowNum, $sales);
    $sheet->setCellValue('G' . $rowNum, $loggedInFirstName);
    $sheet->setCellValue('H' . $rowNum, $loggedInLastName);
    $rowNum++;
}

// Close the database connection
$conn->close();

// Set the filename
$date = date('Y-m-d'); 
$filename = "sales_report_{$loggedInFirstName}_{$loggedInLastName}_{$date}.xlsx"; 

// Set the headers to trigger the Excel download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Pragma: public');
header('Expires: 0');

// Write the file to the output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
