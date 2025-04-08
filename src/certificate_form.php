<?php
require 'connect.php'; // Database connection
require 'account.php'; // Contains session_start()
require('../admin/fpdf186/fpdf.php'); // Include the FPDF library
ob_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    
    $documentType = $_POST['documentType'];
    
    $purpose = $_POST['purpose'];
    
    $firstName = ucwords(strtolower(trim($_POST['firstName'])));
    $middleName = isset($_POST['middleName']) ? trim($_POST['middleName']) : '';
    $lastName = ucwords(strtolower(trim($_POST['lastName'])));
    $suffix = isset($_POST['suffix']) ? trim($_POST['suffix']) : '';

    // Format middle initial if available
    $middleInitial = $middleName !== '' ? strtoupper($middleName[0]) . '.' : '';

    // Format suffix if available
    $suffixFormatted = $suffix !== '' ? ' ' . ucwords(strtolower($suffix)) : '';

    // Construct full name
    $fullName = "$firstName " . ($middleInitial ? "$middleInitial " : '') . "$lastName$suffixFormatted";


    $address = $_POST['block'] . " " . $_POST['street'] . " " . $_POST['subdivision'] . ', Barangay Baritan, Malabon City';
    function addOrdinalSuffix($num) {
        if (!in_array(($num % 100), [11, 12, 13])) {
            switch ($num % 10) {
                case 1: return $num . 'st';
                case 2: return $num . 'nd';
                case 3: return $num . 'rd';
            }
        }
        return $num . 'th';
    }
    
    $today = date("j"); // Get day as a number
    $monthYear = date("F Y"); // Get month and year
    $formattedDate = addOrdinalSuffix($today) . " day of " . $monthYear;

    if (isset($_POST['submitBtn'])) { 
        
        $requestID = uniqid("REQ_");
        $residentID = $_SESSION['User_Data']['Resident_ID'];

        // Prepare SQL statement
        $sql = "INSERT INTO request_document_tbl 
                (Request_ID, Resident_ID, Document_Type, Purpose, FirstName,LastName,MiddleName,Suffix, Address ) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error preparing SQL: " . $conn->error);
        }   
        // Bind parameters
        $stmt->bind_param("sssssssss", $requestID, $residentID, $documentType, $purpose, $firstName, $lastName, $middleName, $suffix, $address);

        if ($stmt->execute()) {
            echo "Request submitted successfully.";
            header("Location: ../index.php"); // Redirect to index
            exit(); // Ensure script stops execution after redirect


    }

    
}
    }




// Create instance of FPDF class
$pdf = new FPDF();
$pdf->AddPage();

// Get page width and height
$pageWidth = $pdf->GetPageWidth();
$pageHeight = $pdf->GetPageHeight();

// Add the background image
$bgImagePath = '../pics/documents.png'; // Path to your background image
$pdf->Image($bgImagePath, 0, 0, $pageWidth, $pageHeight);

// Now you can add other content on top of the background image
$pdf->Ln(60);
$pdf->SetX(95);

$pdf->SetFont('Times', 'B',20);
$pdf->SetTextColor(0, 0, 0);




if ($documentType == "Certificate") {
    $header = "CERTIFICATE"; 
    $body = '
    This is to certify that this office interposes no objection as to the operation of '.$purpose.' owned by '.$fullName.' located at #'.$address.'.

    This certification is being issued upon the request of the above-named person/establishment for securing Locational Clearance and Business Permit. 
    
    Issued this '.$formattedDate.' at Barangay Baritan, City of Malabon.';

}  else if ($documentType == "Permit") { 
    $header = "PERMIT"; 
    $body = '
    This is to certify that '.$fullName.' of #'.$address.' has complied with the necessary requirements and is hereby granted permission to operate for the purpose of '.$purpose.' within the jurisdiction of Barangay Baritan, City of Malabon.

    This Permit is issued in accordance with local ordinances and regulations, and is valid for the purpose of securing a Locational Clearance and Business Permit.

    Issued this '.$formattedDate.' at Barangay Baritan, City of Malabon.';

} else if ($documentType == "Clearance") {
    $header = "CLEARANCE"; 
    $body = '
      This is to certify that ' . $fullName . ' is a bona fide resident of #' . $address . ' and personally known to be a person of good moral character without any criminal record or derogatory information against him/her and who enjoys a good reputation in this community.

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
$pdf->MultiCell(105, 10, 
"      $body",
 0, "L");

// Output the PDF
$pdf->Output();

?>
