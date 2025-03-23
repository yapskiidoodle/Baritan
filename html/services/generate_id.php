<?php
require '../../src/connect.php'; // Include your database connection file
require('../../admin/fpdf186/fpdf.php'); // Include the FPDF library
ob_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Handle file upload for 2x2 picture
    $twoByTwo = $_FILES['twoByTwo'];
    $twoByTwoName = $twoByTwo['name'];
    $twoByTwoTmpName = $twoByTwo['tmp_name'];
    $twoByTwoError = $twoByTwo['error'];

    if ($twoByTwoError === 0) {
        $twoByTwoNewName = uniqid('', true) . '.' . pathinfo($twoByTwoName, PATHINFO_EXTENSION);
        $twoByTwoDestination = '../../resident_folder/2x2pic/' . $twoByTwoNewName;

        if (!move_uploaded_file($twoByTwoTmpName, $twoByTwoDestination)) {
            die("Error moving uploaded file.");
        }
    } else {
        die("Error uploading file.");
    }

    // Form processing
    
    $residentID = $_SESSION['User_Data']['Resident_ID']; // Resident ID from session
    $barangayID = $_POST['barangayID'];
    $birthday = $_POST['birthday'];
    $today = date("F j, Y"); // Current date

    $date = new DateTime();
    $dateFormatted = $date->format('Ymd');
    $uniqueNumber = str_pad(1, 4, '0', STR_PAD_LEFT);
    $id = $dateFormatted . '-' . $uniqueNumber;

    $date->modify('+1 year');
    $valid = $date->format('F j, Y');

    $formattedBirthday = date("F j, Y", strtotime($birthday));

    $fullName = $_POST['firstName'] . ' ' . $_POST['middleInitial'][0] . '. ' . $_POST['lastName'] . ' ' . $_POST['suffix'];
    $address = $_POST['block'] . " " . $_POST['street'] . " " . $_POST['subdivision'] . ', 1470 Barangay Baritan, Malabon City';
    $formattedAddress = str_replace(',', ",\n", $address);

    $emergencyPerson = $_POST['emergencyPerson'];
    $emergencyContact = $_POST['emergencyContact'];

    // Database Insert Query
    $sql = "INSERT INTO barangay_id_tbl_{$id}Resident_ID, FullName, Address, Birthday, Date_Issued, Valid_Until, Contact_Person, Contact_Number, TwoByTwo) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssssssss", $barangayID, $residentID, $fullName, $formattedAddress, $formattedBirthday, $today, $valid, $emergencyPerson, $emergencyContact, $twoByTwoNewName);
        
        if ($stmt->execute()) {
            echo "Record inserted successfully.";

        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing query: " . $conn->error;
    }

    $conn->close();
    ob_end_clean();
} else {
    echo "Form was not submitted.";
    exit;
}



// Create instance of FPDF class
$pdf = new FPDF();
$pdf->AddPage();

// Add the `baritan_id.png` image (background) first
$bgImagePath = '../../pics/baritan_id.png'; // Path to your background image
$imageWidth = 150;  // Width in mm
$imageHeight = 100; // Height in mm

// Calculate the X and Y position to center the image
$pageWidth = 210;  // A4 width in mm
$pageHeight = 297; // A4 height in mm
$x = ($pageWidth - $imageWidth) / 2; // Center horizontally
$y = 40; // Position where the background image starts

// Add border around `baritan_id.png`
$pdf->SetDrawColor(0, 0, 0); // Black color for the border
$pdf->Rect($x - 2, $y - 2, $imageWidth + 4, $imageHeight + 4); // Rectangle around the image

// Add the background image now
$pdf->Image($bgImagePath, $x, $y, $imageWidth,$pdf->Cell(40, $imageHeight)); // X, Y, width, height

// Now, add the profile image above the background image (in terms of layering)
$profileImagePath = '../../resident_folder/2x2pic/'.$twoByTwoNewName; // Path to your profile image
$profileImageWidth = 40;  // Width of profile image in mm
$profileImageHeight = 40; // Height of profile image in mm
$pdf->Image($profileImagePath, 130, 68, $profileImageWidth, $profileImageHeight); // X, Y, width, height

// Add Title for the PDF
$pdf->SetFont('Arial', 'B', 30);

// Get the page width and set the title centered
$pageWidth = $pdf->GetPageWidth();
$titleWidth = $pdf->GetStringWidth('Barangay ID Sample'); // Get the width of the title text
$xPosition = ($pageWidth - $titleWidth) / 2; // Calculate X position to center the title

// Set X to center the title
$pdf->SetX($xPosition);

// Add the title
$pdf->Cell($titleWidth, 10, 'Barangay ID Sample', 0, 1, 'C');
// Add space


$pdf->Ln(55);
// Add table 
$pdf->SetX(37);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(35, 5, 'NAME:', 0, 0);
$pdf->Cell(50, 5, $fullName , 0, 1);

$pdf->SetX(37); // Set X position for the address label
$pdf->Cell(35, 5, 'ADDRESS:', 0, 0, 'L'); // Print the label "ADDRESS:" without padding (align left)

$pdf->MultiCell(0, 4, $formattedAddress, 0, 'L', false); // Print the formatted address with no padding



$pdf->Ln(2);
$pdf->SetX(37);
$pdf->Cell(35, 5, 'BIRTHDAY:', 0, 0);
$pdf->Cell(50, 5,$formattedBirthday  , 0, 1);

$pdf->SetX(37);
$pdf->Cell(35, 5, 'DATE ISSUED:', 0, 0);
$pdf->Cell(50, 5, $today, 0, 1);

$pdf->SetX(37);
$pdf->Cell(35, 5, 'VALID UNTIL:', 0, 0);
$pdf->Cell(50, 5, $valid, 0, 1);


$pdf->Ln(1);
$pdf->SetX(120);
$pdf->Cell(60, 5, 'ID #:'. $id , 0, 0, 'C');

$pdf->SetTextColor(255, 255, 255);  // RGB values for white
$pdf->Ln(14);
$pdf->SetX(37);
// Add more rows with dynamic data or static content
$pdf->Cell(40, 5, 'CONTACT PERSON:', 0, 0);
$pdf->Cell(50, 5, $emergencyPerson, 0, 1);

$pdf->SetX(37);
$pdf->Cell(40, 5, 'CONTACT NUMBER:', 0, 0);
$pdf->Cell(50, 5, $emergencyContact, 0, 1);

// Output the PDF
$pdf->Output('I', 'barangay_id_sample.pdf'); // Display in browser
// $pdf->Output('D', 'barangay_id_sample.pdf'); // Uncomment this if you want to force download
?>
