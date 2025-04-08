<?php
require 'connect.php';
require 'account.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEmail = $_POST['userEmail'] ?? '';
    $password = $_POST['password'] ?? '';

    $FamilyName = isset($_POST['famName']) ? trim($_POST['famName']) : '';
    $FamilyName = preg_replace('/[^a-zA-Zñ ]/', '', $FamilyName); // Remove special characters & numbers
    $FamilyName = ucwords(strtolower($FamilyName)); // Capitalize first letter of each word 


    $FirstName = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
    $FirstName = preg_replace('/[^a-zA-Zñ ]/', '', $FirstName); // Remove special characters & numbers
    $FirstName = ucwords(strtolower($FirstName)); // Capitalize first letter of each word

    $MiddleName = isset($_POST['middleInitial']) ? trim($_POST['middleInitial']) : '';
    $MiddleName  = preg_replace('/[^a-zA-Zñ ]/', '',  $MiddleName ); // Remove special characters & numbers
    $MiddleName = ucwords(strtolower($MiddleName)); // Capitalize first letter of each word    

    $LastName  = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';
    $LastName  = preg_replace('/[^a-zA-Zñ ]/', '', $LastName ); // Remove special characters & numbers
    $LastName  = ucwords(strtolower($LastName)); // Capitalize first letter of each word   
    
    $Suffix = isset($_POST['suffix']) ? trim($_POST['suffix']) : '';
    $Suffix = preg_replace('/[^a-zA-Z0-9. ]/', '', $Suffix); // Allows letters, numbers, space, and period
    $Suffix = ucwords(strtolower($Suffix)); // Capitalize first letter of each word


    $Sex = $_POST['sex'] ?? '';
    $Date_of_Birth = $_POST['birthday'] ?? '';
    $Role = $_POST['role'] ?? '';
    $Contact_Number = $_POST['contact'] ?? '';
    $Resident_Email = $_POST['email'] ?? '';
    $Occupation = $_POST['occupation'] ?? '';
    $Religion = $_POST['religion'] ?? '';
    $Eligibility_Status = $_POST['eligibilityStatus'] ?? '';
    $Civil_Status = $_POST['civilStatus'] ?? '';
    $Emergency_Person = $_POST['emergencyPerson'] ?? '';
    $Emergency_Contact_No = $_POST['emergencyContact'] ?? '';
    $Emergency_Address = $_POST['emergencyAddress'] ?? '';
    $Relationship_to_Person = $_POST['emergencyRelation'] ?? '';
    $Address = trim(($_POST['block'] ?? '') . ' ' . ($_POST['street'] ?? '') . ' ' . ($_POST['subdivision'] ?? ''));
    $Valid_ID_Type = $_POST['idType'] ?? '';

    // Secure Password Hashing
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    // File Upload Configuration
    $uploadDir = '../resident_folder/';
    $validIdFrontDir = $uploadDir . 'valid_id/Front/';
    $validIdBackDir = $uploadDir . 'valid_id/Back/';
    $pic2x2Dir = $uploadDir . 'profile/';
    
    // Create directories if they don't exist
    if (!file_exists($validIdFrontDir)) mkdir($validIdFrontDir, 0777, true);
    if (!file_exists($validIdBackDir)) mkdir($validIdBackDir, 0777, true);
    if (!file_exists($pic2x2Dir)) mkdir($pic2x2Dir, 0777, true);

    // Validate and process file uploads
    $validIdFront = '';
    $validIdBack = '';
    $pic2x2 = '';
    
    // Function to handle file uploads
    function handleFileUpload($fileInput, $targetDir, $residentId) {
        if (!isset($_FILES[$fileInput]) || $_FILES[$fileInput]['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'No file uploaded or upload error'];
        }
        
        $file = $_FILES[$fileInput];
        $maxSize = 5 * 1024 * 1024; // 5MB
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        
        // Validate file type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        
        if (!in_array($mime, $allowedTypes)) {
            return ['success' => false, 'message' => 'Only JPG, PNG, or GIF images are allowed'];
        }
        
        // Validate file size
        if ($file['size'] > $maxSize) {
            return ['success' => false, 'message' => 'File size must be less than 5MB'];
        }
        
        // Generate unique filename
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $residentId . '_' . $fileInput . '_' . time() . '.' . $ext;
        $targetPath = $targetDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return ['success' => true, 'path' => $filename];
        } else {
            return ['success' => false, 'message' => 'Failed to move uploaded file'];
        }
    }

    // Process form data (your existing code)
    
    // ... (rest of your form data processing)

    // Generate Resident ID (your existing code)
    $query = "SELECT COUNT(*) AS total FROM residents_information_tbl";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $residentCount = ($row['total'] ?? 0) + 1;
    $Resident_ID = strtoupper(substr($LastName, 0, 3)) . date("Y") . str_pad($residentCount, 4, "0", STR_PAD_LEFT);

    // Handle file uploads after Resident_ID is generated
    $idFrontResult = handleFileUpload('idFront', $validIdFrontDir, $Resident_ID);
    $idBackResult = handleFileUpload('idBack', $validIdBackDir, $Resident_ID);
    $pic2x2Result = handleFileUpload('2x2pic', $pic2x2Dir, $Resident_ID);

    // Check for file upload errors
    if (!$idFrontResult['success'] || !$idBackResult['success'] || !$pic2x2Result['success']) {
        die("File upload error: " . 
            ($idFrontResult['message'] ?? '') . " " . 
            ($idBackResult['message'] ?? '') . " " . 
            ($pic2x2Result['message'] ?? ''));
    }

    $validIdFront = $idFrontResult['path'];
    $validIdBack = $idBackResult['path'];
    $pic2x2 = $pic2x2Result['path'];
  // Insert into `account_tbl`
  $queryAcc = "SELECT MAX(CAST(SUBSTRING(Account_ID, -3) AS UNSIGNED)) AS max_id FROM account_tbl";
  $resultAcc = mysqli_query($conn, $queryAcc);
  $rowAcc = mysqli_fetch_assoc($resultAcc);
  $accountCount = ($rowAcc['max_id'] ?? 0) + 1;
  $Account_ID = "FAM" . date("Y") . str_pad($accountCount, 3, "0", STR_PAD_LEFT);

  $sqlAccount = "INSERT INTO account_tbl (Account_ID, Role, Type, User_Email, Password, Status) 
                 VALUES (?, ?, ?, ?, ?, ?)";
  $stmtAccount = $conn->prepare($sqlAccount);
  $Account_Type = "Family Account";
  $AccountStatus = "Deactivated";
  $stmtAccount->bind_param("ssssss", $Account_ID, $Role, $Account_Type, $userEmail, $hashedPassword, $AccountStatus);
  
  if (!$stmtAccount->execute()) {
      die("Error inserting into account_tbl: " . $stmtAccount->error);
  }

  // Generate Family Name ID & Insert into `family_name_tbl`
  $queryFam = "SELECT COUNT(*) AS totalFam FROM family_name_tbl";
  $resultFam = mysqli_query($conn, $queryFam);
  $rowFam = mysqli_fetch_assoc($resultFam);
  $familyCount = ($rowFam['totalFam'] ?? 0) + 1;
  $shortenedName = strtoupper(strlen($FamilyName) >= 3 ? substr($FamilyName, 0, 3) : str_pad($FamilyName, 3, "X"));
  $Family_Name_ID = "FAM" . $shortenedName . date("Y") . str_pad($familyCount, 3, "0", STR_PAD_LEFT);

  $sqlFamily = "INSERT INTO family_name_tbl (Family_Name_ID, Account_ID, Family_Name, Status) 
                VALUES (?, ?, ?, ?)";
  $stmtFamily = $conn->prepare($sqlFamily);
  if (!$stmtFamily) {
      die("Error preparing family table SQL: " . $conn->error);
  }
  $status = "Inactive";
  $stmtFamily->bind_param("ssss", $Family_Name_ID, $Account_ID, $FamilyName, $status);
  if (!$stmtFamily->execute()) {
      die("Error inserting into family_name_tbl: " . $stmtFamily->error);
  }

    // Calculate Age
    $dob = new DateTime($Date_of_Birth);
    $today = new DateTime();
    $Age = $today->diff($dob)->y;

    // Insert into residents_information_tbl with file paths
    $sqlAddInfo = "INSERT INTO residents_information_tbl 
        (Resident_ID, Family_Name_ID, FirstName, MiddleName, LastName, Suffix, Sex, Date_of_Birth, Role, Contact_Number, 
        Resident_Email, Occupation, Religion, Eligibility_Status, Civil_Status, Emergency_Person, 
        Emergency_Contact_No, Emergency_Address, Relationship_to_Person, Address, Valid_ID_Type, Age,
        Valid_ID_Picture_Front, Valid_ID_Picture_Back, Pic_Path) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmtAddInfo = $conn->prepare($sqlAddInfo);
    if (!$stmtAddInfo) {
        die("Error preparing SQL: " . $conn->error);
    }
    
    $stmtAddInfo->bind_param("sssssssssssssssssssssssss", 
        $Resident_ID, $Family_Name_ID, $FirstName, $MiddleName, $LastName, $Suffix, $Sex, $Date_of_Birth, $Role, $Contact_Number,
        $Resident_Email, $Occupation, $Religion, $Eligibility_Status, $Civil_Status, $Emergency_Person,
        $Emergency_Contact_No, $Emergency_Address, $Relationship_to_Person, $Address, $Valid_ID_Type, $Age,
        $validIdFront, $validIdBack, $pic2x2
    );

    if (!$stmtAddInfo->execute()) {
        die("Error inserting into residents_information_tbl: " . $stmtAddInfo->error);
    }

    header("Location: ../index.php");
    $_SESSION['success-message'] = "Resident information added successfully!";
    exit();
}
?>