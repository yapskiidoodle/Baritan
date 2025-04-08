<?php
require ('../src/connect.php');
require ('../src/account.php');
session_start();

// Store all form data in session to repopulate form
$_SESSION['form_data'] = $_POST;

$resident_ID = strtoupper($_POST['residentID']);
$start_Term = $_POST['start_term'];
$end_Term = $_POST['end_term'];
$User_Email = $_POST['User_Email'];
$Role = $_POST['Role'];
$Type = $_POST['Type'];
$Password = password_hash($_POST['Password'], PASSWORD_DEFAULT);
$Status = $_POST['Status'];
$Account_ID = "ADM" . date("YmdHis");

// Validate account type
$validTypes = ['Super Admin', 'Admin', 'Editor'];
if (!in_array($Type, $validTypes)) {
    $_SESSION['validation_errors']['Type'] = "Invalid account type selected";
    header("Location: admin_management.php?tab=staff&showModal=addAdmin");
    exit();
}

// Check if resident exists
$countResident = "SELECT COUNT(*) FROM residents_information_tbl WHERE resident_ID = ?";
$stmt = $conn->prepare($countResident);
$stmt->bind_param("s", $resident_ID);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count == 0) {
    $_SESSION['validation_errors']['residentID'] = "Resident ID does not exist in our records";
    header("Location: admin_management.php?tab=staff&showModal=addAdmin");
    exit();
}

// Check if resident already has an account
$checkResidentAccount = "SELECT Account_ID FROM account_tbl WHERE staff_id IN 
                        (SELECT staff_id FROM staff_information_tbl WHERE resident_id = ?)";
$stmt = $conn->prepare($checkResidentAccount);
$stmt->bind_param("s", $resident_ID);
$stmt->execute();
$stmt->bind_result($existingAccountId);
$stmt->fetch();

if ($existingAccountId) {
    $_SESSION['validation_errors']['residentID'] = "This Resident ID is already assigned to Account ID: $existingAccountId";
    $stmt->close();
    header("Location: admin_management.php?tab=staff&showModal=addAdmin");
    exit();
}
$stmt->close();

// Check if username exists
$checkUsername = "SELECT COUNT(*) FROM account_tbl WHERE User_Email = ?";
$stmt = $conn->prepare($checkUsername);
$stmt->bind_param("s", $User_Email);
$stmt->execute();
$stmt->bind_result($usernameCount);
$stmt->fetch();

if ($usernameCount > 0) {
    $_SESSION['validation_errors']['User_Email'] = "This username is already taken";
    $stmt->close();
    header("Location: admin_management.php?tab=staff&showModal=addAdmin");
    exit();
}
$stmt->close();

// Get resident name
$nameQuery = "SELECT FirstName, LastName FROM residents_information_tbl WHERE Resident_ID = ?";
$stmt = $conn->prepare($nameQuery);
$stmt->bind_param("s", $resident_ID);
$stmt->execute();
$stmt->bind_result($firstName, $lastName);
$stmt->fetch();
$stmt->close();

// Generate staff_id
$firstThreeLetters = strtoupper(substr($firstName, 0, 3));
$currentDateTime = date("md s");
$currentDateTimeNumbers = str_replace(" ", "", $currentDateTime);
$staff_id = $firstThreeLetters . $currentDateTimeNumbers;
$fullName = trim("$firstName $lastName");

// Insert into staff table
$staffSql = "INSERT INTO staff_information_tbl (staff_id, name, resident_id, account_id, role, start_term, end_term, created_at) 
             VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($staffSql);
$stmt->bind_param("sssssss", $staff_id, $fullName, $resident_ID, $Account_ID, $Role, $start_Term, $end_Term);

if (!$stmt->execute()) {
    $_SESSION['validation_errors']['general'] = "Error creating staff record: " . $stmt->error;
    header("Location: admin_management.php?tab=staff&showModal=addAdmin");
    exit();
}
$stmt->close();

// Insert into account table
$accountSql = "INSERT INTO account_tbl (Account_ID, staff_id, User_Email, Role, Type, Password, Status) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($accountSql);
$stmt->bind_param("sssssss", $Account_ID, $staff_id, $User_Email, $Role, $Type, $Password, $Status);

if ($stmt->execute()) {
    // Log the activity
    $logIdPrefix = strtoupper(substr($_SESSION['Account_Role'], 0, 3));
    $logIdDateTime = date("YmdHis");
    $logId = $logIdPrefix . $logIdDateTime;
    $action = "Added new staff: $fullName (ID: $staff_id) as $Role";
    
    $logSql = "INSERT INTO admin_activity_log (log_id, admin_id, action_by, action, created_at) 
               VALUES (?, ?, ?, ?, NOW())";
    $logStmt = $conn->prepare($logSql);
    $logStmt->bind_param("ssss", $logId, $_SESSION['Account_ID'], $_SESSION['Account_Role'], $action);
    $logStmt->execute();
    $logStmt->close();
    
    // Clear form data on success
    unset($_SESSION['form_data']);
    unset($_SESSION['validation_errors']);
    $_SESSION['success'] = "New staff member added successfully!";
    header("Location: admin_management.php?tab=staff");
} else {
    $_SESSION['validation_errors']['general'] = "Error creating account: " . $stmt->error;
    header("Location: admin_management.php?tab=staff&showModal=addAdmin");
}
$stmt->close();
exit();
?>