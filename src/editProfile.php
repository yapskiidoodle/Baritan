<?php
require 'connect.php'; // Ensure this correctly initializes $conn
require 'account.php'; // Ensure this starts the session

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: ../html/profile.php");
    exit();
}

// Ensure user session is set
$userID = $_SESSION['User_Data']['Resident_ID'] ?? '';

if (!$userID) {
    $_SESSION['error_message'] = "User session is missing or expired.";
    header("Location: ../html/profile.php");
    exit();
}

// Retrieve form data safely
$firstName = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
$firstName = preg_replace('/[^a-zA-Zñ ]/', '', $firstName); // Remove special characters & numbers
$firstName = ucwords(strtolower($firstName)); // Capitalize first letter of each word

$middleName = isset($_POST['middleName']) ? trim($_POST['middleName']) : '';
$middleName = preg_replace('/[^a-zA-ñ ]/', '', $middleName); // Remove special characters & numbers
$middleName = ucwords(strtolower($middleName)); // Capitalize first letter of each word    

$lastName = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';
$lastName = preg_replace('/[^a-zA-Zñ ]/', '', $lastName); // Remove special characters & numbers
$lastName = ucwords(strtolower($lastName)); // Capitalize first letter of each word  


$sex = $_POST['sex'] ?? '';
$birthday = $_POST['birthday'] ?? '';
$role = $_POST['role'] ?? '';
$contact = $_POST['contact'] ?? '';
$residentEmail = $_POST['residentEmail'] ?? '';
$occupation = $_POST['occupation'] ?? '';
$religion = $_POST['religion'] ?? '';
$eligibilityStatus = $_POST['eligibilityStatus'] ?? '';
$civilStatus = $_POST['civilStatus'] ?? '';
$emergencyPerson = $_POST['emergencyPerson'] ?? '';
$emergencyContact = $_POST['emergencyContact'] ?? '';
$emergencyAddress = $_POST['emergencyAddress'] ?? '';
$relationship = $_POST['emergencyRelation'] ?? '';
$address = $_POST['address'] ?? '';

// Validate Resident_ID before updating
$checkStmt = $conn->prepare("SELECT Resident_ID FROM residents_information_tbl WHERE Resident_ID = ?");
$checkStmt->bind_param("s", $userID);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows === 0) {
    $_SESSION['error_message'] = "Resident not found.";
    header("Location: ../html/profile.php");
    exit();
}

// Prepare the update query using MySQLi
$stmt = $conn->prepare("
    UPDATE residents_information_tbl SET
        FirstName = ?, MiddleName = ?, LastName = ?, Sex = ?, Date_of_Birth = ?, 
        Role = ?, Contact_Number = ?, Resident_Email = ?, Occupation = ?, 
        Religion = ?, Eligibility_Status = ?, Civil_Status = ?, 
        Emergency_Person = ?, Emergency_Contact_No = ?, Emergency_Address = ?, 
        Relationship_to_Person = ?, Address = ?
    WHERE Resident_ID = ?
");

if (!$stmt) {
    $_SESSION['error_message'] = "Database error: " . $conn->error;
    header("Location: ../html/profile.php");
    exit();
}

$stmt->bind_param(
    "ssssssssssssssssss",
    $firstName, $middleName, $lastName, $sex, $birthday,
    $role, $contact, $residentEmail, $occupation,
    $religion, $eligibilityStatus, $civilStatus,
    $emergencyPerson, $emergencyContact, $emergencyAddress,
    $relationship, $address, $userID
);

if (!$stmt->execute()) {
    $_SESSION['error_message'] = "Error updating profile: " . $stmt->error;
    header("Location: ../html/profile.php");
    exit();
}

// Check if any rows were updated
if ($stmt->affected_rows > 0) {
    // Reload session data
    $stmt = $conn->prepare("SELECT * FROM residents_information_tbl WHERE Resident_ID = ?");
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($newData = $result->fetch_assoc()) {
        $_SESSION['User_Data'] = $newData;
        $_SESSION['success_message'] = "Profile updated successfully.";
    } else {
        $_SESSION['error_message'] = "Profile update was successful, but data could not be refreshed.";
    }

    header("Location: ../html/profile.php");
    exit();
} else {
    $_SESSION['error_message'] = "No changes were made.";
    header("Location: ../html/profile.php");
    exit();
}
?>



<!-- 

echo "<pre>";
print_r($_POST);
echo "Resident_ID: " . ($_SESSION['User_Data']['Resident_ID'] ?? 'not set');
echo "\n";
echo "Family_: " . ($_SESSION['User_Data']['Family_Name_ID'] ?? 'not set');
echo "</pre>";
exit();

-->