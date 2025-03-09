<?php
require('fpdf186/fpdf.php');

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
        $this->Cell(0, 10, 'CERTIFICATE OF INDIGENCY', 0, 1, 'C', true);
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
$pdf->Cell(0, 10, 'This is to certify that I, [Name],', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0); // Black text
$pdf->MultiCell(0, 10, 'born on [Date of Birth], a resident of [Address], Sta. Am Ext. St., Brgy. Barangay, Partner, certifies also that the above-named person belongs to an indigent family of this Barangay.', 0, 'L');
$pdf->Ln(5);

$pdf->SetTextColor(0, 0, 128); // Navy blue text
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'This Certification is Being Issued upon request of the above-named person', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0); // Black text
$pdf->MultiCell(0, 10, 'for FINANCIAL ASSISTANCE FOR [Purpose].', 0, 'L');

// Add a simple border or line for design
$pdf->SetDrawColor(0, 0, 128); // Navy blue line
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(10);

// Output the PDF
$pdf->Output('I', 'Certificate_of_Indigency.pdf');
?>
