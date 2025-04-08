<?php
require ('../src/connect.php');
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['Account_Role'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id']) && isset($_POST['action'])) {
    $requestId = $_POST['request_id'];
    $action = $_POST['action'];
    
    // Validate action
    if (!in_array($action, ['approve', 'reject'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        exit;
    }
    
    $newStatus = $action === 'approve' ? 'Approved' : 'Rejected';
    
    $query = "UPDATE request_document_tbl SET Request_Status = ? WHERE Request_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $newStatus, $requestId);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Document status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating document status']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>