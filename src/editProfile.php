<?php
require 'connect.php'; // Ensure database connection
require 'account.php'; // Ensures session is started

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION['error_message'] = "Invalid request.";
    header("Location: ../html/profile.php");
    exit();
}




// Ensure user session exists
$userID = trim($_POST['residentID'] ?? ''); // Fixed inconsistent field name

if (!$userID) {
    $_SESSION['error_message'] = "Resident ID is missing.";
    header("Location: ../html/profile.php");
    exit();
}

// Sanitize and validate form inputs
function sanitizeInput($input) {
    return ucwords(strtolower(trim(preg_replace('/[^a-zA-Zñ ]/', '', $input))));
}

// Sanitize inputs and match form names
$firstName = sanitizeInput($_POST['first_name'] ?? '');
$middleName = sanitizeInput($_POST['middle_name'] ?? '');
$lastName = sanitizeInput($_POST['last_name'] ?? '');
$suffix = $_POST['suffix'] ?? ''; // Ensure suffix is captured
$sex = $_POST['sex'] ?? '';
$birthday = $_POST['dob'] ?? '';  // Form uses 'dob'
$role = $_POST['role'] ?? ''; // Ensure Role is captured
$contact = $_POST['contact_number'] ?? ''; // Match form
$residentEmail = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$occupation = $_POST['occupation'] ?? '';
$religion = $_POST['religion'] ?? ''; // Fixed missing variable
$address = $_POST['address'] ?? ''; 

// Emergency Contact Details
$emergencyPerson = sanitizeInput($_POST['emergency_person'] ?? ''); 
$emergencyContact = $_POST['emergency_contact'] ?? ''; 
$emergencyAddress = $_POST['emergencyAddress'] ?? '';  // Fixed field name
$relationship = sanitizeInput($_POST['relationship'] ?? ''); 
$civilStatus = $_POST['civil_status'] ?? ''; 
$eligibilityStatus = $_POST['eligibility_status'] ?? ''; 

// Calculate Age from DOB
$age = '';
if (!empty($birthday)) {
    $birthDate = new DateTime($birthday);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y; // Calculate age based on birthdate
}

// Verify if Resident exists before updating
$checkStmt = $conn->prepare("SELECT Resident_ID FROM residents_information_tbl WHERE Resident_ID = ?");
$checkStmt->bind_param("s", $userID);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows === 0) {
    $_SESSION['error_message'] = "Resident not found.";
    header("Location: ../html/profile.php");
    exit();
}

// Prepare the update query securely
$stmt = $conn->prepare("
    UPDATE residents_information_tbl SET
        FirstName = ?, MiddleName = ?, LastName = ?, Suffix = ?, Sex = ?, 
        Date_of_Birth = ?, Age = ?, Role = ?, Contact_Number = ?, Resident_Email = ?, 
        Occupation = ?, Religion = ?, Eligibility_Status = ?, Civil_Status = ?, 
        Emergency_Person = ?, Emergency_Contact_No = ?, Emergency_Address = ?, 
        Relationship_to_Person = ?, Address = ?
    WHERE Resident_ID = ?
");

if (!$stmt) {
    $_SESSION['error_message'] = "Database error: " . $conn->error;
    header("Location: ../html/profile.php");
    exit();
}

// Bind parameters
$stmt->bind_param(
    "ssssssssssssssssssss", // 20 placeholders including age
    $firstName, $middleName, $lastName, $suffix, $sex, 
    $birthday, $age, $role, $contact, $residentEmail, 
    $occupation, $religion, $eligibilityStatus, $civilStatus, 
    $emergencyPerson, $emergencyContact, $emergencyAddress, 
    $relationship, $address, $userID
);

// Execute update
if (!$stmt->execute()) {
    $_SESSION['error_message'] = "Error updating profile: " . $stmt->error;
    header("Location: ../html/profile.php");
    exit();
}

// Refresh session data
$stmt = $conn->prepare("SELECT * FROM residents_information_tbl WHERE Resident_ID = ?");
$stmt->bind_param("s", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($newData = $result->fetch_assoc()) {
    if ($_SESSION['Resident_ID'] === $userID) {
        foreach ($newData as $key => $value) {
            $_SESSION['User_Data'][$key] = $value;
        }
    }
    $_SESSION['success_message'] = "Profile updated successfully.";

} else {
    $_SESSION['error_message'] = "Profile updated, but data could not be refreshed.";
}

header("Location: ../html/profile.php");
exit();
?>
