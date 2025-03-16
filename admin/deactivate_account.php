<?php
require ('../src/connect.php');

$accountId = $_GET['id'];

// Update the account status to "Deactivated"
$sql = "UPDATE account_tbl SET Status = 'Deactivated' WHERE Account_ID = $accountId";
if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $conn->error]);
}

$conn->close();
?>