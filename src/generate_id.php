<?php
require '../src/connect.php'; // Include your database connection file
require '../src/account.php';
require('../admin/fpdf186/fpdf.php'); // Include the FPDF library
ob_start();

// Initialize variables
$twoByTwoNewName = $idFrontNewName = $idBackNewName = $paymentNewName = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Process form data but don't save to database yet
    $residentID = $_SESSION['User_Data']['Resident_ID']; // Resident ID from session
    $birthday = $_POST['birthday'];
    $today = date("F j, Y"); // Current date
    $date = new DateTime();
    $dateFormatted = $date->format('Ymd');
    $id = 'ID-' . str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
    $date->modify('+1 year');
    $valid = $date->format('F j, Y');
    $formattedBirthday = date("F j, Y", strtotime($birthday));
    $fullName = $_POST['firstName'] . ' ' . $_POST['middleInitial'][0] . '. ' . $_POST['lastName'] . ' ' . $_POST['suffix'];
    $address = $_POST['block'] . " " . $_POST['street'] . " " . $_POST['subdivision'] . ', 1470 Barangay Baritan, Malabon City';
    $formattedAddress = str_replace(',', ",\n", $address);
    $emergencyPerson = $_POST['emergencyPerson'];
    $emergencyContact = $_POST['emergencyContact'];

    // Handle file upload for 2x2 picture (temporary processing)
    if (isset($_FILES['twoByTwo'])) {
        $twoByTwo = $_FILES['twoByTwo'];
        $twoByTwoName = $twoByTwo['name'];
        $twoByTwoTmpName = $twoByTwo['tmp_name'];
        $twoByTwoError = $twoByTwo['error'];

        if ($twoByTwoError === 0) {
            $twoByTwoNewName = uniqid('', true) . '.' . pathinfo($twoByTwoName, PATHINFO_EXTENSION);
        }
        
        if (!empty($twoByTwoNewName)) {
            $twoByTwoDestination = '../resident_folder/2x2pic/' . $twoByTwoNewName;
            if (!move_uploaded_file($twoByTwoTmpName, $twoByTwoDestination)) {
                die("Error moving 2x2 picture file.");
            }
        }
    }

    // Handle file upload for ID (front) (temporary processing)
    if (isset($_FILES['idFront'])) {
        $idFront = $_FILES['idFront'];
        $idFrontName = $idFront['name'];
        $idFrontTmpName = $idFront['tmp_name'];
        $idFrontError = $idFront['error'];
        
        if ($idFrontError === 0) {
            $idFrontNewName = uniqid('', true) . '.' . pathinfo($idFrontName, PATHINFO_EXTENSION);
        }
    }
    
    // Handle file upload for ID (back) (temporary processing)
    if (isset($_FILES['idBack'])) {
        $idBack = $_FILES['idBack'];
        $idBackName = $idBack['name'];
        $idBackTmpName = $idBack['tmp_name'];
        $idBackError = $idBack['error'];
        
        if ($idBackError === 0) {
            $idBackNewName = uniqid('', true) . '.' . pathinfo($idBackName, PATHINFO_EXTENSION);
        }
    }

    // Handle payment file upload (temporary processing)
    if (isset($_FILES['payment'])) {
        $payment = $_FILES['payment'];
        $paymentName = $payment['name'];
        $paymentTmpName = $payment['tmp_name'];
        $paymentError = $payment['error'];
        
        if ($paymentError === 0) {
            $paymentNewName = uniqid('', true) . '.' . pathinfo($paymentName, PATHINFO_EXTENSION);
        }
    }

    // Only process the form submission when submitBtn is clicked
    if (isset($_POST['submitBtn'])) {
        // Now actually move the uploaded files
       
        
        if (!empty($idFrontNewName)) {
            $idFrontDestination = '../resident_folder/valid_id/front/' . $idFrontNewName;
            if (!move_uploaded_file($idFrontTmpName, $idFrontDestination)) {
                die("Error moving ID front file.");
            }
        }
        
        if (!empty($idBackNewName)) {
            $idBackDestination = '../resident_folder/valid_id/back/' . $idBackNewName;
            if (!move_uploaded_file($idBackTmpName, $idBackDestination)) {
                die("Error moving ID back file.");
            }
        }
        
        if (!empty($paymentNewName)) {
            $paymentDestination = '../resident_folder/payment/' . $paymentNewName;
            if (!move_uploaded_file($paymentTmpName, $paymentDestination)) {
                die("Error moving payment file.");
            }
        }

        // Insert into database
        $sql = "INSERT INTO barangay_id_tbl 
                    (Barangay_ID, Resident_ID, FullName, Address, Birthday, Date_Issued, Valid_Until, 
                    Contact_Person, Contact_Number, TwoByTwo, IdFront, IdBack, Payment) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        $stmt = $conn->prepare($sql);
    
        if (!$stmt) {
            die("Error preparing SQL: " . $conn->error);
        }  
    
        $stmt->bind_param("sssssssssssss", 
            $id, 
            $residentID, 
            $fullName, 
            $formattedAddress, 
            $formattedBirthday, 
            $today, 
            $valid, 
            $emergencyPerson, 
            $emergencyContact, 
            $twoByTwoNewName, 
            $idFrontNewName, 
            $idBackNewName, 
            $paymentNewName
        );
    
        if ($stmt->execute()) {
            // Generate PDF only after successful database insertion
            generatePDF($fullName, $formattedAddress, $formattedBirthday, $today, $valid, $id, $emergencyPerson, $emergencyContact, $twoByTwoNewName);
            
            // Redirect after processing
            header("Location: ../index.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    
        $stmt->close();
        $conn->close();
    } else {
        // If not submitting to database, just generate the preview PDF
        generatePDF($fullName, $formattedAddress, $formattedBirthday, $today, $valid, $id, $emergencyPerson, $emergencyContact, $twoByTwoNewName);
    }
} else {
    echo "Form was not submitted.";
    exit;
}

function generatePDF($fullName, $formattedAddress, $formattedBirthday, $today, $valid, $id, $emergencyPerson, $emergencyContact, $twoByTwoNewName) {
    // Create instance of FPDF class
    $pdf = new FPDF();
    $pdf->AddPage();

    // Add the `baritan_id.png` image (background) first
    $bgImagePath = '../pics/baritan_id.png'; // Path to your background image
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
    $pdf->Image($bgImagePath, $x, $y, $imageWidth, $imageHeight); // X, Y, width, height

    // Now, add the profile image above the background image (in terms of layering)
    if (!empty($twoByTwoNewName)) {
        $profileImagePath = __DIR__ . '/../resident_folder/2x2pic/' . $twoByTwoNewName;
        if (!empty($twoByTwoNewName)) {
            $profileImagePath = '../resident_folder/2x2pic/'.$twoByTwoNewName;
            if (file_exists($profileImagePath)) {
                $pdf->Image($profileImagePath, 130, 68, 40, 40);
            } else {
                // Optional: fallback or warning
                error_log("Profile image not found at: $profileImagePath");
            }
        }
    }

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

    $pdf->Ln(5);
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
}
?>