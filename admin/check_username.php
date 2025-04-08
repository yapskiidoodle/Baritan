<?php
require ('../src/connect.php');
header('Content-Type: application/json');

$username = $_GET['username'] ?? '';

$stmt = $conn->prepare("SELECT COUNT(*) FROM account_tbl WHERE User_Email = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();

echo json_encode(['exists' => $count > 0]);

$stmt->close();
?>