<?php
require_once('../src/connect.php');
require ('../src/account.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_POST['action'], $_POST['request_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
    exit;
}

$action = $_POST['action'];
$requestId = $_POST['request_id'];
$adminId = $_SESSION['Account_Role']; // Assuming you store admin ID in session

try {
    if ($action === 'approve') {
        // Update the document request status to Approved
        $stmt = $conn->prepare("UPDATE request_document_tbl 
                               SET Request_Status = 'Approved', 
                                   Process_Date = NOW(),    
                                   Processed_By = ?
                               WHERE Request_ID = ?");
        $stmt->bind_param("ss", $adminId, $requestId);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Document approved successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update database']);
        }
    } 
    elseif ($action === 'deny') {
        $reason = $_POST['reason'] ?? 'No reason provided';
        
        $stmt = $conn->prepare("UPDATE request_document_tbl 
                               SET Request_Status = 'Rejected', 
                                   Request_Date = NOW(), 
                                   Processed_By = ?,
                                   Denial_Reason = ?
                               WHERE Request_ID = ?");
        $stmt->bind_param("ss", $adminId, $reason, $requestId);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Document denied successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update database']);
        }
    } 
    else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>