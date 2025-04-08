<?php
// Make sure no output is sent before headers
ob_start();

require('../src/connect.php');
require('../src/account.php');
require('fpdf186/fpdf.php');

// Check authorization
if (!isset($_SESSION['Account_Role']) || 
    !in_array($_SESSION['type'], ["Super Admin", "Admin", "Editor"])) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_GET['request_id'])) {
    die("Request ID missing");
}
$requestId = $_GET['request_id'];

// Fetch request details
$query = "SELECT 
            r.Document_Type, 
            r.Purpose,
            CONCAT(res.FirstName, ' ', res.LastName) AS FullName,
            res.Address
          FROM request_document_tbl r
          JOIN residents_information_tbl res ON r.Resident_ID = res.Resident_ID
          WHERE r.Request_ID = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $requestId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Request not found");
}

$data = $result->fetch_assoc();

$fullName = htmlspecialchars($data['FullName']);
$purpose = htmlspecialchars($data['Purpose']);
$documentType = htmlspecialchars($data['Document_Type']);
$address = htmlspecialchars($data['Address']);



    try {
        // Create instance of FPDF class
        $pdf = new FPDF();
        $pdf->AddPage();

        // Get page width and height
        $pageWidth = $pdf->GetPageWidth();
        $pageHeight = $pdf->GetPageHeight();

        // Add the background image
        $bgImagePath = 'pics/documents.png'; // Path to your background image
        if (file_exists($bgImagePath)) {
            $pdf->Image($bgImagePath, 0, 0, $pageWidth, $pageHeight);
        }

        // Now you can add other content on top of the background image
        $pdf->Ln(60);
        $pdf->SetX(95);

        $pdf->SetFont('Times', 'B', 20);
        $pdf->SetTextColor(0, 0, 0);

        // Get current date
        $currentDate = new DateTime();
        $formattedDate = $currentDate->format('F d, Y');

        if (strtolower($documentType) == "indigency") {
            $header = "CERTIFICATE OF INDIGENCY"; 
            $body = '
            This is to certify that this office interposes no objection as to the operation of '.$purpose.' owned by '.$fullName.' located at #'.$address.'.

            This certification is being issued upon the request of the above-named person/establishment for securing Locational Clearance and Business Permit. 
            
            Issued this '.$formattedDate.' at Barangay Baritan, City of Malabon.';

        } else if (strtolower($documentType) == "permit") { 
            $header = "PERMIT"; 
            $body = '
            This is to certify that '.$fullName.' of #'.$address.' has complied with the necessary requirements and is hereby granted permission to operate for the purpose of '.$purpose.' within the jurisdiction of Barangay Baritan, City of Malabon.

            This Permit is issued in accordance with local ordinances and regulations, and is valid for the purpose of securing a Locational Clearance and Business Permit.

            Issued this '.$formattedDate.' at Barangay Baritan, City of Malabon.';

        } else if (strtolower($documentType) == "clearance") {
            $header = "CLEARANCE"; 
            $body = '
              This is to certify that ' . $fullName . ' is a bona fide resident of ' . $address . ' and personally known to be a person of good moral character without any criminal record or derogatory information against him/her and who enjoys a good reputation in this community.

              As per requirement and/or to support his/her application for: '.$purpose.'.
              
              Issued this '.$formattedDate.' at Barangay Baritan, City of Malabon.' ;
        }

        $pdf->Cell(0, 10, $header, 0, 1, "C");

        //body of the pdf
        $pdf->SetFont('Arial', '', 12);

        $pdf->Ln(10);
        $pdf->SetX(95);
        $pdf->Cell(0, 10, "To whom it may concern,", 0, 1, "L");

        // Fix: Align MultiCell with Cell()
        $pdf->SetX(95); // Ensure MultiCell starts where Cell() was
        $pdf->MultiCell(105, 10, "      $body", 0, "L");

        // Generate a unique filename
        $filename = $documentType . '_' . str_replace(' ', '_', $fullName) . '_' . time();
        
        // Clear any output buffer
        ob_end_clean();
        
        // Output the PDF directly to the browser
        $pdf->Output('I', $filename);
        exit();
    } catch (Exception $e) {
        // Clean any output buffer before showing error
        ob_end_clean();
        die("Error generating PDF: " . $e->getMessage());
    }

?>