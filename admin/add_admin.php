<?php
require ('../src/connect.php');
require ("../src/account.php");

$User_Email = $_POST['User_Email'];
$Role = ucwords(strtolower($_POST['Role']));
$Type = $_POST['Type'];
$Password = password_hash($_POST['Password'], PASSWORD_DEFAULT);
$Status = $_POST['Status'];
$Account_ID = "ADM" . date("YmdHis");

// Validate account type
$validTypes = ['Super Admin', 'Admin', 'Editor'];
if (!in_array($Type, $validTypes)) {
    die("Invalid account type.");
}

$sql = "SELECT COUNT(*) as count FROM account_tbl WHERE Role = 'Chairman'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$chairmanCount = $row['count']; // Fetch the actual count as an integer

$sqlSec = "SELECT COUNT(*) as count FROM account_tbl WHERE Role = 'Secretary'";
$resultSec = $conn->query($sqlSec);
$rowSec = $result->fetch_assoc();
$secretatyCount = $row['count']; // Fetch the actual count as an integer



if (($Role == "Chairman") || ($Role == "Secretary")) {
    if ($chairmanCount > 0) {  // Only check if count > 0 (NULL is no longer a concern)
        $_SESSION['error_message'] = "Chairman or Secretary already exists.";
        header("Location: admin_management.php");
        exit();
    } 
}


$_SESSION['success_message'] = "Profile added successfully.";
$sql = "INSERT INTO account_tbl (Account_ID, User_Email, Role, Type, Password, Status) VALUES ('$Account_ID' ,'$User_Email', '$Role', '$Type', '$Password', '$Status')";
$conn->query($sql);  



header('Location: admin_management.php');



?>