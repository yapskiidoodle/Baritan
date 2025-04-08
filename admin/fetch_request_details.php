<?php
require ('../src/connect.php');

if (isset($_POST['request_id'])) {
    $requestId = $_POST['request_id'];
    
    $query = "SELECT r.*, CONCAT(res.FirstName, ' ', res.LastName) AS resident_name 
              FROM request_document_tbl r
              JOIN residents_information_tbl res ON r.Resident_ID = res.Resident_ID
              WHERE r.Request_ID = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $requestId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            'request_id' => $row['Request_ID'],
            'resident_name' => $row['resident_name'],
            'document_type' => $row['Document_Type'],
            'purpose' => $row['Purpose'],
            'request_date' => date('M d, Y', strtotime($row['Request_Date']))
        ]);
    } else {
        echo json_encode(['error' => 'Document not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>