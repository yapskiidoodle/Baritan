<?php
require ('../src/connect.php');
require ('../src/account.php');

// Check admin permissions
if (!isset($_SESSION['Account_Role']) || 
   ($_SESSION['type'] !== "Super Admin" && $_SESSION['type'] !== "Admin")) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    $required = ['staff_id', 'name', 'role', 'start_term'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            header("Location: admin_management.php?error=missing_fields&tab=staff");
            exit();
        }
    }

    

    // Prepare data
    $staff_id = $_POST['staff_id'];
    $name = $_POST['name'];
    $role = $_POST['role'];
    $start_term = $_POST['start_term'];

    if ($role === 'SK') {
        $countSk = "SELECT COUNT(*) as sk_count FROM account_tbl WHERE role = 'SK'";
        $result = $conn->query($countSk);
    
        if ($result) {
            $row = $result->fetch_assoc();
            $skCount = (int)$row['sk_count'];
            if ($skCount >= 1) {
                // Return JSON response for AJAX or set session error
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    echo json_encode(['error' => 'Only one(1) SK is allowed.']);
                    exit();
                } else {
                    $_SESSION['role_limit_error'] = "SK is already exist. Only one(1) SK is allowed.";
                    header("Location: admin_management.php?tab=staff");
                    exit();
                }
            }
        }
    }

    if ($role === 'Lupon') {
        $countLupon = "SELECT COUNT(*) as lupon_count FROM account_tbl WHERE role = 'Lupon'";
        $result = $conn->query($countLupon);
    
        if ($result) {
            $row = $result->fetch_assoc();
            $luponCount = (int)$row['lupon_count'];
            if ($luponCount >= 2) {
                // Return JSON response for AJAX or set session error
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    echo json_encode(['error' => 'Only two(2) Lupon is allowed.']);
                    exit();
                } else {
                    $_SESSION['role_limit_error'] = "Two(2) Lupon is already exist. Only two(2) Lupon is allowed.";
                    header("Location: admin_management.php?tab=staff");
                    exit();
                }
            }
        }
    }

    if ($role === 'Counselor') {
        $countCounselor = "SELECT COUNT(*) as counselor_count FROM account_tbl WHERE role = 'Counselor'";
        $result = $conn->query($countCounselor);
    
        if ($result) {
            $row = $result->fetch_assoc();
            $counselorCount = (int)$row['counselor_count'];
            if ($counselorCount >= 2) {
                // Return JSON response for AJAX or set session error
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    echo json_encode(['error' => 'Only twelve(12) Counselor is allowed.']);
                    exit();
                } else {
                    $_SESSION['role_limit_error'] = "There is already twelve(12) Counselor exist. Only twelve(12) Counselor is allowed.";
                    header("Location: admin_management.php?tab=staff");
                    exit();
                }
            }
        }
    }

    if ($role === 'Treasurer') {
        $countTreasurer = "SELECT COUNT(*) as treasurer_count FROM account_tbl WHERE role = 'Treasurer'";
        $result = $conn->query($countTreasurer);
    
        if ($result) {
            $row = $result->fetch_assoc();
            $treasurerCount = (int)$row['treasurer_count'];
            if ($treasurerCount >= 1) {
                // Return JSON response for AJAX or set session error
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    echo json_encode(['error' => 'Only one Treasurer is allowed.']);
                    exit();
                } else {
                    $_SESSION['role_limit_error'] = "Treasurer is already exist. Only one Treasurer is allowed.";
                    header("Location: admin_management.php?tab=staff");
                    exit();
                }
            }
        }
    }

    if ($role === 'Secretary') {
        $countSecretary = "SELECT COUNT(*) as secretary_count FROM account_tbl WHERE role = 'Secretary'";
        $result = $conn->query($countSecretary);
    
        if ($result) {
            $row = $result->fetch_assoc();
            $secretaryCount = (int)$row['secretary_count'];
            if ($secretaryCount >= 1) {
                // Return JSON response for AJAX or set session error
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    echo json_encode(['error' => 'Only one Secretary is allowed.']);
                    exit();
                } else {
                    $_SESSION['role_limit_error'] = "Secretary is already exist. Only one Secretary is allowed.";
                    header("Location: admin_management.php?tab=staff");
                    exit();
                }
            }
        }
    }

    if ($role === 'Chairman') {
        $countChairman = "SELECT COUNT(*) as chairman_count FROM account_tbl WHERE role = 'Chairman'";
        $result = $conn->query($countChairman);
    
        if ($result) {
            $row = $result->fetch_assoc();
            $chairmanCount = (int)$row['chairman_count'];
            if ($chairmanCount >= 1) {
                // Return JSON response for AJAX or set session error
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    echo json_encode(['error' => 'Only one Chairman is allowed.']);
                    exit();
                } else {
                    $_SESSION['role_limit_error'] = "Chairman is already exist. Only one Chairman is allowed.";
                    header("Location: admin_management.php?tab=staff");
                    exit();
                }
            }
        }
    }

    $updateRole = "UPDATE account_tbl Set Role = '$role' WHERE staff_id = '$staff_id'";
    $conn->query($updateRole);

    // Update staff record
    $sql = "UPDATE staff_information_tbl 
            SET name = ?, 
                role = ?, 
                start_term = ?
            WHERE staff_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $role, $start_term, $staff_id);
    
    if ($stmt->execute()) {
        // Log the activity
        $logIdPrefix = strtoupper(substr($_SESSION['Account_Role'], 0, 3)); // First 3 letters of the admin role
        $logIdDateTime = date("YmdHis"); // Current date and time in YYYYMMDDHHMMSS format
        $logId = $logIdPrefix . $logIdDateTime; // Combine prefix and date-time
        $action = "Updated staff: $name (ID: $staff_id)";
        $logSql = "INSERT INTO admin_activity_log (log_id, admin_id, action_by, action, created_at) 
                   VALUES (?, ?, ?, ?, NOW())";
        $logStmt = $conn->prepare($logSql);
        $logStmt->bind_param("ssss", $logId, $_SESSION['Account_ID'], $_SESSION['Account_Role'], $action);
        $logStmt->execute();
        
        header("Location: admin_management.php?success=staff_updated&tab=staff");
    } else {
        header("Location: admin_management.php?error=staff_update_failed&tab=staff");
    }
    exit();
}

header("Location: admin_management.php");
exit();
?>