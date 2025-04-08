<?php
require('../src/connect.php');
require('../src/account.php');
require('fpdf186/fpdf.php');

// Check authorization
if (!isset($_SESSION['Account_Role']) || 
    !in_array($_SESSION['type'], ["Super Admin", "Admin", "Editor"])) {
    header("Location: ../index.php");
    exit();
}

// Get form data
$fullName = $_POST['fullName'] ?? '';
$address = $_POST['address'] ?? '';
$birthDate = $_POST['birthDate'] ?? '';
$civilStatus = $_POST['civilStatus'] ?? '';

// Create PDF
$pdf = new FPDF('P', 'mm', array(85.6, 53.98)); // Standard ID size
$pdf->AddPage();

// Add background
$bgImagePath = 'pics/id_bg.png';
$pdf->Image($bgImagePath, 0, 0, 85.6, 53.98);

// Add content (same as your existing ID generation code)
// ... [rest of your ID generation code]

// Output the PDF
$pdf->Output("Barangay_ID_$fullName.pdf", 'I');
exit();
?>