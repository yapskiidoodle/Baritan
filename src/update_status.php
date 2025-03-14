<?php
require 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accountID'], $_POST['newStatus'])) {
    $accountID = intval($_POST['accountID']); 
    $newStatus = ($_POST['newStatus'] === "Activated") ? "Activated" : "Deactivated";

    // Ensure `Account_ID` exists before updating
    $checkSql = "SELECT Account_ID FROM account_tbl WHERE Account_ID = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $accountID);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows === 0) {
        echo "error";
        exit();
    }

    // Update account status
    $sql = "UPDATE account_tbl SET Status = ? WHERE Account_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newStatus, $accountID);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "error";
}
?>
