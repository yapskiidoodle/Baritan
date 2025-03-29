<?php
require ('../src/connect.php');
require ('../src/account.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountId = $_POST['Account_ID'];

    // Debug: Log the received Account_ID
    error_log("Received Account_ID: " . $accountId);

    // Update the account status to "Activated"
    $sql = "UPDATE account_tbl SET Status = 'Activated' WHERE Account_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $accountId);

    if ($stmt->execute()) {
        header("Location: admin_management.php?success=1");
    } else {
        header("Location: admin_management.php?error=1");
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>