<?php
require ('../src/connect.php');
header('Content-Type: application/json');

$residentID = $_GET['residentID'] ?? '';

// Check if resident exists
$stmt = $conn->prepare("SELECT COUNT(*) FROM residents_information_tbl WHERE resident_ID = ?");
$stmt->bind_param("s", $residentID);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count == 0) {
    echo json_encode(['exists' => false]);
    exit;
}

// Check if resident has an account
$stmt = $conn->prepare("SELECT Account_ID FROM account_tbl WHERE staff_id IN 
                       (SELECT staff_id FROM staff_information_tbl WHERE resident_id = ?)");
$stmt->bind_param("s", $residentID);
$stmt->execute();
$stmt->bind_result($accountId);
$stmt->fetch();

echo json_encode([
    'exists' => true,
    'hasAccount' => !empty($accountId),
    'accountId' => $accountId ?? ''
]);

$stmt->close();
?>