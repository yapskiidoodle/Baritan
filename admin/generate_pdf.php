<?php
require('fpdf186/fpdf.php');
ob_start(); // Start output buffering

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "Barangay_Baritan";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $format = $_POST["format"];

    if ($format === "pdf") {
        header("Location: generate_pdf.php");
        exit;
    } elseif ($format === "csv") {
        header("Location: csv_population.php");
        exit;
    } else {
        echo "Invalid format selected.";
    }
}

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch residents and sort alphabetically by Last Name
$sql = "SELECT Resident_ID, LastName, FirstName, Sex, Contact_Number, Address, Date_of_Birth,
        TIMESTAMPDIFF(YEAR, Date_of_Birth, CURDATE()) AS Age 
        FROM Residents_information_tbl 
        ORDER BY LastName ASC";
$result = $conn->query($sql);
$total_population = $result->num_rows;

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

$pdf->SetTitle("Official Barangay Population Report");

// Add Logo
$pdf->Image('pics/logo.png', 90, 5, 25); // (x, y, width)

$pdf->Ln(15);

// Barangay Header
$pdf->Cell(0, 10, 'Barangay Baritan - Resident Population Report', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, 'Official Barangay Population Report', 0, 1, 'C');
$pdf->Cell(0, 5, 'Generated on: ' . date("F d, Y"), 0, 1, 'C');
$pdf->Ln(8);

// Center the table
$table_width = 170; // Adjust based on column sizes
$start_x = (210 - $table_width) / 2; // Calculate center position

// Table Headers (Centered)
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetX($start_x);
$pdf->Cell(30, 6, 'ID', 1, 0, 'C');
$pdf->Cell(25, 6, 'Last Name', 1, 0, 'C');
$pdf->Cell(25, 6, 'First Name', 1, 0, 'C');
$pdf->Cell(12, 6, 'Sex', 1, 0, 'C');
$pdf->Cell(15, 6, 'Age', 1, 0, 'C');
$pdf->Cell(20, 6, 'Contact', 1, 0, 'C');
$pdf->Cell(40, 6, 'Address', 1, 1, 'C');

// Table Data (Auto Page Break)
$pdf->SetFont('Arial', '', 7);
if ($total_population > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($pdf->GetY() > 270) { // New page if too low
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetX($start_x);
            $pdf->Cell(30, 6, 'ID', 1, 0, 'C');
            $pdf->Cell(25, 6, 'Last Name', 1, 0, 'C');
            $pdf->Cell(25, 6, 'First Name', 1, 0, 'C');
            $pdf->Cell(12, 6, 'Sex', 1, 0, 'C');
            $pdf->Cell(15, 6, 'Age', 1, 0, 'C');
            $pdf->Cell(20, 6, 'Contact', 1, 0, 'C');
            $pdf->Cell(40, 6, 'Address', 1, 1, 'C');
            $pdf->SetFont('Arial', '', 7);
        }

        $pdf->SetX($start_x); // Align data rows to table center
        $pdf->Cell(30, 6, $row['Resident_ID'], 1, 0, 'C');
        $pdf->Cell(25, 6, $row['LastName'], 1, 0, 'C');
        $pdf->Cell(25, 6, $row['FirstName'], 1, 0, 'C');
        $pdf->Cell(12, 6, $row['Sex'], 1, 0, 'C');
        $pdf->Cell(15, 6, $row['Age'], 1, 0, 'C');
        $pdf->Cell(20, 6, $row['Contact_Number'], 1, 0, 'C');
        $pdf->Cell(40, 6, $row['Address'], 1, 1, 'C');
    }
} else {
    $pdf->Cell(0, 6, 'No records found.', 1, 1, 'C');
}

// Summary Section
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 8, "Total Population: $total_population residents", 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(0, 5, "This document serves as an official report of the current population count in Barangay Baritan. The data presented includes demographic details such as names, gender, age, and contact information of registered residents.", 0, 'C');

// Close connection & Output PDF
$conn->close();
ob_end_clean();
$pdf->Output('I', 'Barangay_Baritan_Resident_Report.pdf');
exit();
