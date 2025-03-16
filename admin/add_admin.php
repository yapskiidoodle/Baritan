<?php
require ('../src/connect.php');

$User_Email = $_POST['User_Email'];
$Role = $_POST['Role'];
$Type = $_POST['Type'];
$Password = password_hash($_POST['Password'], PASSWORD_DEFAULT);
$Status = $_POST['Status'];
$Account_ID = "ADM" . date("YmdHis");

// Validate account type
$validTypes = ['Super Admin', 'Admin', 'Editor'];
if (!in_array($Type, $validTypes)) {
    die("Invalid account type.");
}

$sql = "INSERT INTO account_tbl (Account_ID, User_Email, Role, Type, Password, Status) VALUES ('$Account_ID' ,'$User_Email', '$Role', '$Type', '$Password', '$Status')";
$conn->query($sql);

header('Location: admin_management.php');
?>