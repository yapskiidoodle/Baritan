<?php
require ('../src/connect.php');

if (isset($_GET['request_id'])) {
    $requestId = $_GET['request_id'];
    $query = "SELECT * FROM request_document_tbl WHERE Request_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $requestId);
    $stmt->execute();
    $result = $stmt->get_result();
    $document = $result->fetch_assoc();
    
    if ($document) {
        echo '<div class="row mb-3">';
        echo '<div class="col-md-6"><strong>Request ID:</strong> ' . htmlspecialchars($document['Request_ID']) . '</div>';
        echo '<div class="col-md-6"><strong>Resident ID:</strong> ' . htmlspecialchars($document['Resident_ID']) . '</div>';
        echo '</div>';
        
        echo '<div class="row mb-3">';
        echo '<div class="col-md-6"><strong>Name:</strong> ' . 
             htmlspecialchars($document['FirstName'] . ' ' . 
             ($document['MiddleName'] ? substr($document['MiddleName'], 0, 1) . '. ' : '') . 
             $document['LastName'] . 
             ($document['Suffix'] ? ' ' . $document['Suffix'] : '')) . '</div>';
        echo '<div class="col-md-6"><strong>Document Type:</strong> ' . htmlspecialchars($document['Document_Type']) . '</div>';
        echo '</div>';
        
        echo '<div class="row mb-3">';
        echo '<div class="col-md-12"><strong>Address:</strong> ' . htmlspecialchars($document['Address']) . '</div>';
        echo '</div>';
        
        echo '<div class="row mb-3">';
        echo '<div class="col-md-6"><strong>Purpose:</strong> ' . htmlspecialchars($document['Purpose']) . '</div>';
        echo '<div class="col-md-6"><strong>Request Date:</strong> ' . htmlspecialchars($document['Request_Date']) . '</div>';
        echo '</div>';
        
        echo '<div class="row mb-3">';
        echo '<div class="col-md-6"><strong>Status:</strong> <span class="badge ' . 
             ($document['Request_Status'] == 'Approved' ? 'bg-success' : 
              ($document['Request_Status'] == 'Rejected' ? 'bg-danger' : 'bg-warning text-dark')) . '">' . 
             htmlspecialchars($document['Request_Status']) . '</span></div>';
        echo '</div>';
        
        // Add PDF viewer or document preview here if available
        echo '<div class="mt-4">';
        echo '<h5>Document Preview</h5>';
        echo '<div class="border p-3 text-center">';
        echo '<p class="text-muted">PDF document preview would appear here</p>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="alert alert-danger">Document not found.</div>';
    }
} else {
    echo '<div class="alert alert-danger">Invalid request.</div>';
}
?>