<?php
require ('../src/connect.php');
require ('../src/account.php');

// Check admin permissions
if (!isset($_SESSION['Account_Role']) || 
   ($_SESSION['type'] !== "Super Admin" && $_SESSION['type'] !== "Admin")) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['staff_id'])) {
    $staff_id = $conn->real_escape_string($_POST['staff_id']);

    // Get chairman's hashed password from database
    $chairmanSql = "SELECT Password FROM account_tbl WHERE Role = 'Chairman' AND Status = 'Activated' LIMIT 1";
    $chairmanResult = $conn->query($chairmanSql);

    if ($chairmanResult->num_rows === 0) {
        $_SESSION['error'] = "No active chairman account found";
        header("Location: admin_management.php?tab=staff");
        exit();
    }

    $chairman = $chairmanResult->fetch_assoc();
    if (!password_verify($_POST['chairman_password'], $chairman['Password'])) {
        $_SESSION['error'] = "Invalid Chairman password";
        header("Location: admin_management.php?tab=staff");
        exit();
    }

    // Now proceed with deletion if password is correct
    $staff_id = $_POST['staff_id'];

    // First get the associated account ID
    $accountSql = "SELECT account_id FROM staff_information_tbl WHERE staff_id = ?";
    $stmt = $conn->prepare($accountSql);
    $stmt->bind_param("s", $staff_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $staff = $result->fetch_assoc();
    $account_id = $staff['account_id'];

    // Delete from staff table
    $deleteStaff = "DELETE FROM staff_information_tbl WHERE staff_id = ?";
    $stmt = $conn->prepare($deleteStaff);
    $stmt->bind_param("s", $staff_id);
    $stmt->execute();

    // Delete from account table
    if ($account_id) {
        $deleteAccount = "DELETE FROM account_tbl WHERE Account_ID = ?";
        $stmt = $conn->prepare($deleteAccount);
        $stmt->bind_param("s", $account_id);
        $stmt->execute();
    }
    
    if ($stmt->execute()) {
        // Log the activity
        $logIdPrefix = strtoupper(substr($_SESSION['Account_Role'], 0, 3)); // First 3 letters of the admin role
        $logIdDateTime = date("YmdHis"); // Current date and time in YYYYMMDDHHMMSS format
        $logId = $logIdPrefix . $logIdDateTime; // Combine prefix and date-time
        $action = "Deleted staff: $staff_name (ID: $staff_id)";
        $logSql = "INSERT INTO admin_activity_log (log_id, admin_id, action_by, action, created_at) 
                   VALUES (?, ?, ?, ?, NOW())";
        $logStmt = $conn->prepare($logSql);
        $logStmt->bind_param("ssss", $logId, $_SESSION['Account_ID'], $_SESSION['Account_Role'], $action);
        $logStmt->execute();
        
        $_SESSION['success'] = "Staff member and associated account deleted successfully";
        header("Location: admin_management.php?tab=staff");
        exit();
    } else {
        header("Location: admin_management.php?error=staff_delete_failed&tab=staff");
    }
    exit();
}


?>