<?php
require ('../src/connect.php');
require ('../src/account.php');

if (!isset($_SESSION['Account_Role']) || 
    ($_SESSION['type'] !== "Super Admin" && $_SESSION['type'] !== "Admin")) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    $required = ['name', 'role', 'start_term'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            header("Location: admin_management.php?error=missing_fields&tab=staff");
            exit();
        }
    }

    // Generate staff ID
    $staff_id = 'STF-' . strtoupper(substr(uniqid(), -6));
    $name = $conn->real_escape_string($_POST['name']);
    $role = $conn->real_escape_string($_POST['role']);
    $start_term = $conn->real_escape_string($_POST['start_term']);
    
    // Handle account assignment
    $account_id = 'no account yet';
    if (!empty($_POST['assign_account']) && $_POST['assign_account'] === 'yes') {
        // Find an available admin account
        $availableAccount = $conn->query("
            SELECT Account_ID 
            FROM account_tbl 
            WHERE Account_ID NOT IN (
                SELECT account_id 
                FROM staff_information_tbl 
                WHERE account_id != 'no account yet'
            )
            AND Type IN ('Admin', 'Super Admin', 'Editor')
            LIMIT 1
        ");
        
        if ($availableAccount->num_rows > 0) {
            $account_id = $availableAccount->fetch_assoc()['Account_ID'];
        } else {
            header("Location: admin_management.php?error=no_available_accounts&tab=staff");
            exit();
        }
    }

    // Insert staff record
    $sql = "INSERT INTO staff_information_tbl (staff_id, name, resident_id, account_id, role, start_term) 
            VALUES (?, ?, NULL, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $staff_id, $name, $account_id, $role, $start_term);
    
    if ($stmt->execute()) {

        $logIdPrefix = strtoupper(substr($_SESSION['Account_Role'], 0, 3)); // First 3 letters of the admin role
        $logIdDateTime = date("YmdHis"); // Current date and time in YYYYMMDDHHMMSS format
        $logId = $logIdPrefix . $logIdDateTime; // Combine prefix and date-time
        $action = $account_id === 'no account yet' 
            ? "Added new staff without account: $name" 
            : "Added new staff with account ID $account_id: $name";
        
        $logSql = "INSERT INTO admin_activity_log (log_id, admin_id, action_by, action, created_at) 
                   VALUES (?, ?, ?, ?, NOW())";
        $logStmt = $conn->prepare($logSql);
        $logStmt->bind_param("ssss", $logId, $_SESSION['Account_ID'], $_SESSION['Account_Role'], $action);
        $logStmt->execute();
        
        header("Location: admin_management.php?success=staff_added&tab=staff");
    } else {
        header("Location: admin_management.php?error=staff_add_failed&tab=staff");
    }
    exit();
}

header("Location: admin_management.php");
exit();
?>