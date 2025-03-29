<?php
require ('../src/connect.php');
require ('../src/account.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountId = $_POST['Account_ID'];

    // Debug: Log the received Account_ID
    error_log("Received Account_ID for deletion: " . $accountId);

    // Delete the admin account
    $sql = "DELETE FROM account_tbl WHERE Account_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $accountId);

    if ($stmt->execute()) {
        // Redirect with success parameter
        header("Location: admin_management.php?success=2");
    } else {
        // Redirect with error parameter
        header("Location: admin_management.php?error=1");
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>