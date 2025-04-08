<?php
require ('../src/connect.php');
require ('../src/account.php');

if (!isset($_SESSION['Account_Role']) || $_SESSION['type'] !== "Super Admin") {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['staff_id']) && !empty($_POST['account_id'])) {
    $staff_id = $conn->real_escape_string($_POST['staff_id']);
    $account_id = $conn->real_escape_string($_POST['account_id']);

    $sql = "UPDATE staff_information_tbl SET account_id = ? WHERE staff_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $account_id, $staff_id);
    
    if ($stmt->execute()) {

        $logIdPrefix = strtoupper(substr($_SESSION['Account_Role'], 0, 3)); // First 3 letters of the admin role
        $logIdDateTime = date("YmdHis"); // Current date and time in YYYYMMDDHHMMSS format
        $logId = $logIdPrefix . $logIdDateTime; // Combine prefix and date-time
        $action = "Assigned account $account_id to staff $staff_id";
        $logSql = "INSERT INTO admin_activity_log (log_id, admin_id, action_by, action, created_at) 
                   VALUES (?, ?, ?, ?, NOW())";
        $logStmt = $conn->prepare($logSql);
        $logStmt->bind_param("ssss", $logId, $_SESSION['Account_ID'], $_SESSION['Account_Role'], $action);
        $logStmt->execute();
        
        header("Location: admin_management.php?success=account_assigned&tab=staff");
    } else {
        header("Location: admin_management.php?error=assign_failed&tab=staff");
    }
    exit();
}

header("Location: admin_management.php");
exit();
?>