<?php
require ('../src/connect.php');
require ('../src/account.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountId = $_POST['Account_ID'] ?? '';
    $chairmanPassword = $_POST['chairman_password'] ?? '';
    $currentTab = $_POST['current_tab'] ?? 'admin';

    if (empty($accountId) || empty($chairmanPassword)) {
        header("Location: admin_management.php?error=missing_fields&tab=$currentTab");
        exit();
    }

    // Check chairman password
    $chairmanQuery = "SELECT * FROM account_tbl WHERE Role = 'Chairman' AND Status = 'Activated'";
    $chairmanResult = $conn->query($chairmanQuery);
    
    if ($chairmanResult->num_rows === 0) {
        header("Location: admin_management.php?error=no_chairman&tab=$currentTab");
        exit();
    }

    $chairman = $chairmanResult->fetch_assoc();
    if (!password_verify($chairmanPassword, $chairman['Password'])) {
        header("Location: admin_management.php?error=invalid_password&tab=$currentTab");
        exit();
    }

    // Activate the account
    $activateSql = "UPDATE account_tbl SET Status = 'Activated' WHERE Account_ID = ?";
    $stmt = $conn->prepare($activateSql);
    $stmt->bind_param("s", $accountId);
    
    if ($stmt->execute()) {
        // Log the deactivation activity
        $logIdPrefix = strtoupper(substr($_SESSION['Account_Role'], 0, 3)); // First 3 letters of the admin role
        $logIdDateTime = date("YmdHis"); // Current date and time in YYYYMMDDHHMMSS format
        $logId = $logIdPrefix . $logIdDateTime; // Combine prefix and date-time

        $logSql = "INSERT INTO admin_activity_log (log_id, admin_id, action_by, action, created_at) VALUES (?, ?, ?, ?, NOW())";
        $logStmt = $conn->prepare($logSql);
        $action = "Activated account ID $accountId.";
        $logStmt->bind_param("ssss", $logId, $_SESSION['Account_ID'], $_SESSION['Account_Role'], $action);
        $logStmt->execute();
        
        header("Location: admin_management.php?success=activated&tab=" . $currentTab);
        exit();
    } else {
        header("Location: admin_management.php?error=activation_failed&tab=" . $currentTab);
        exit();
    }
}

header("Location: admin_management.php");
exit();
?>