<?php
require ('../src/connect.php');

$id = $_GET['id'];
$sql = "SELECT Account_ID, User_Email, Role, Type, Status FROM account_tbl WHERE Account_ID = $id";
$result = $conn->query($sql);
$admin = $result->fetch_assoc();

echo json_encode($admin);
?>