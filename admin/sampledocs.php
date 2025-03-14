<?php
require('fpdf186/fpdf.php'); // Include the FPDF library

class PDF extends FPDF {
    function Header() {
        // Set font for the header
        $this->SetFont('Arial', 'B', 14);
        // Set background color for the header
        $this->SetFillColor(200, 220, 255);
        // Title
        $this->Cell(0, 10, 'Republic of the Philippines', 0, 1, 'C', true);
        $this->Ln(5);
        $this->Cell(0, 10, 'BARANGAY BARITAN', 0, 1, 'C', true);
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'BARANGAY CLEARANCE', 0, 1, 'C', true);
        $this->Ln(10);
    }

    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['format'])) {
    // Retrieve form data
    $name = 'name';
    $address = 'address';
    $purpose = 'purpose';
    $date_issued = date('F j, Y'); // Current date

    // Create a new PDF instance
    $pdf = new PDF();
    $pdf->AddPage();

    // Set font for the body
    $pdf->SetFont('Arial', '', 12);

    // Add content with some styling
    $pdf->SetTextColor(0, 0, 0); // Black text
    $pdf->Cell(0, 10, 'To whom it may concern,', 0, 1);
    $pdf->Ln(5);

    $pdf->SetTextColor(0, 0, 128); // Navy blue text
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, "This is to certify that $name,", 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0); // Black text
    $pdf->MultiCell(0, 10, "of legal age, and a resident of $address, has been cleared by this Barangay from any derogatory record as of this date.", 0, 'L');
    $pdf->Ln(5);

    $pdf->SetTextColor(0, 0, 128); // Navy blue text
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'This Barangay Clearance is issued for the purpose of:', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0); // Black text
    $pdf->MultiCell(0, 10, "$purpose.", 0, 'L');
    $pdf->Ln(5);

    $pdf->SetTextColor(0, 0, 128); // Navy blue text
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Issued this ' . $date_issued . ' at Barangay Baritan, Malabon City.', 0, 1);
    $pdf->Ln(10);

    // Add a simple border or line for design
    $pdf->SetDrawColor(0, 0, 128); // Navy blue line
    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
    $pdf->Ln(10);

    // Add signature section
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Certified by:', 0, 1);
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'U', 12);
    $pdf->Cell(0, 10, '_________________________', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Barangay Captain', 0, 1, 'C');

    // Output the PDF to the browser
    $pdf->Output('I', 'Barangay_Clearance.pdf');
} else {
    // Handle invalid request
    echo "Invalid request.";
}
?>