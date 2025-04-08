<?php
require_once 'account.php';
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['User_Data']['Resident_ID']) && isset($_POST['resident_id']) && isset($_POST['delete_reason'])) {
    $residentId = $_POST['resident_id'];
    $reason = $_POST['delete_reason'];
    $deleteId = uniqid('DEL_');
    
    $query = "INSERT INTO delete_member_tbl 
              (Delete_ID, Resident_ID, Delete_Reason, Status, Date_Created) 
              VALUES (?, ?, ?, 'Pending', CURRENT_TIMESTAMP)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $deleteId, $residentId, $reason);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        $_SESSION['success_message'] = "Removal request submitted for approval";
    } else {
        $_SESSION['error_message'] = "Failed to submit removal request";
    }
 
    $stmt->close();
    header("Location: ../html/profile.php");
    exit();
} else {
  
    header("Location: ../html/profile.php");
    exit();
}
?>