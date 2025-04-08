<?php
require ('../src/connect.php');
require ('../src/account.php');


// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate required fields
    if (empty($_POST['Account_ID']) || empty($_POST['reason']) || empty($_POST['chairman_password'])) {
        header("Location: admin_management.php?error=missing_fields");
        exit();
    }

    $accountId = $_POST['Account_ID'];
    $reason = $_POST['reason'];
    $otherReason = isset($_POST['other_reason']) ? $_POST['other_reason'] : '';
    $chairmanPassword = $_POST['chairman_password'];
    $currentTab = isset($_POST['current_tab']) ? $_POST['current_tab'] : 'admin';

    // If reason is "Other" but no details provided
    if ($reason === 'Other' && empty($otherReason)) {
        header("Location: admin_management.php?error=short_reason&tab=" . $currentTab);
        exit();
    }

    // Get chairman account (assuming chairman is a Super Admin)
    $chairmanSql = "SELECT * FROM account_tbl WHERE Type = 'Super Admin' AND Role = 'Chairman' AND Status = 'Activated' LIMIT 1";
    $chairmanResult = $conn->query($chairmanSql);
    
    if ($chairmanResult->num_rows === 0) {
        header("Location: admin_management.php?error=no_chairman&tab=" . $currentTab);
        exit();
    }

    $chairman = $chairmanResult->fetch_assoc();

    // Verify chairman password
    if (!password_verify($chairmanPassword, $chairman['Password'])) {
        header("Location: admin_management.php?error=invalid_password&tab=" . $currentTab);
        exit();
    }

    // Prepare the deactivation reason
    $fullReason = ($reason === 'Other') ? 'Other: ' . $otherReason : $reason;

    // Update account status
    $updateSql = "UPDATE account_tbl SET Status = 'Deactivated' WHERE Account_ID = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("s", $accountId);
    
    if ($stmt->execute()) {
        // Log the deactivation activity
        $logIdPrefix = strtoupper(substr($_SESSION['Account_Role'], 0, 3)); // First 3 letters of the admin role
        $logIdDateTime = date("YmdHis"); // Current date and time in YYYYMMDDHHMMSS format
        $logId = $logIdPrefix . $logIdDateTime; // Combine prefix and date-time

        $logSql = "INSERT INTO admin_activity_log (log_id, admin_id, action_by, action, created_at) VALUES (?, ?, ?, ?, NOW())";
        $logStmt = $conn->prepare($logSql);
        $action = "Deactivated account ID $accountId. Reason: $fullReason";
        $logStmt->bind_param("ssss", $logId, $_SESSION['Account_ID'], $_SESSION['Account_Role'], $action);
        $logStmt->execute();
        
        header("Location: admin_management.php?success=deactivated&tab=" . $currentTab);
        exit();
    } else {
        header("Location: admin_management.php?error=deactivation_failed&tab=" . $currentTab);
        exit();
    }
} else {
    header("Location: admin_management.php?error=invalid_method");
    exit();
}


?>