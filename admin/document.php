<?php
require ('../src/connect.php');
require ('../src/account.php');

if (isset($_SESSION['Account_Role'])) {
    if (($_SESSION['type'] === "Super Admin") || ($_SESSION['type'] === "Admin") || ($_SESSION['type'] === "Editor")) {
        $_SESSION['Account_Role'];
    }
    else {
        header("Location: ../index.php");
        exit(); 
    }
} else {
    header("Location: ../index.php");
    exit();
}

// Count pending documents
$pendingCount = $conn->query("SELECT COUNT(*) FROM request_document_tbl WHERE Request_Status = 'Pending'")->fetch_row()[0];
// Count approved documents
$approvedCount = $conn->query("SELECT COUNT(*) FROM request_document_tbl WHERE Request_Status = 'Approved'")->fetch_row()[0];
// Count denied documents
$deniedCount = $conn->query("SELECT COUNT(*) FROM request_document_tbl WHERE Request_Status = 'Rejected'")->fetch_row()[0];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Baritan Official Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="pics/logo.png">
    <link rel="stylesheet" href="adminDesign.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <style>
        body {
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        /* Sidebar styling */
        .sidebar {
            background-color: #1C3A5B;
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 120px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 15px 20px;
            font-size: 16px;
        }

        .sidebar a:hover {
            background-color: #2a4d6e;
        }

        .sidebar a.active {
            background-color: #2a4d6e;
            font-weight: bold;
        }

        .sidebar i {
            margin-right: 10px;
        }

        /* Header styling */
        .header {
            background-color: #1C3A5B;
            color: white;
            padding: 1%;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header .logo-section {
            display: flex;
            align-items: center;
        }

        .header .logo-section img {
            width: 75px;
            margin-right: 10px;
        }

        .header .profile-dropdown {
            margin-right: 20px;
        }

        .header .profile-dropdown .btn {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
        }

        .header .profile-dropdown .dropdown-menu {
            right: 0;
            left: auto;
        }

        .header .profile-dropdown .btn::after {
            display: none;
        }

        /* Main content styling */
        .main-content {
            margin-left: 270px;
            padding: 20px;
            margin-top: 6%;
            width: calc(100% - 270px);
        }
        /* Search bar and filter styling */
        .search-filter {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-bar {
            width: 250px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .table-container {
            max-height: 500px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .documents-table {
            width: 100%;
            border-collapse: collapse;
        }

        .documents-table th,
        .documents-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 12px;
        }

        .documents-table th {
            background-color: #1C3A5B;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .documents-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .documents-table tr:hover {
            background-color: #f1f1f1;
        }

        /* Status badges */
        .badge-pending {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-approved {
            background-color: #28a745;
            color: white;
        }

        .badge-denied {
            background-color: #dc3545;
            color: white;
        }

        /* Action buttons */
        .btn-view {
            background-color: #17a2b8;
            color: white;
        }

        .btn-approve {
            background-color: #28a745;
            color: white;
        }

        .btn-deny {
            background-color: #dc3545;
            color: white;
        }

        /* Tab styling */
        .nav-tabs {
            margin-bottom: 20px;
            border-bottom: 2px solid #1C3A5B;
        }
        
        .nav-tabs .nav-link {
            color: #1C3A5B;
            border: none;
            padding: 10px 20px;
            font-weight: 500;
        }
        
        .nav-tabs .nav-link.active {
            color: #fff;
            background-color: #1C3A5B;
            border: none;
            border-radius: 5px 5px 0 0;
        }
        
        .nav-tabs .nav-link:hover:not(.active) {
            background-color: #f1f1f1;
        }
        
        .tab-content {
            padding: 20px 0;
        }

        /* Document details modal */
        .document-details dt {
            font-weight: 600;
        }
        .document-details dd {
            margin-bottom: 10px;
        }
        /* Add this to your existing style section */
    .modal-backdrop {
        z-index: 1040 !important;
    }
    
    #viewDocumentModal, #pdfViewerModal {
        z-index: 1060 !important;
    }
    
    #confirmActionModal {
        z-index: 1050 !important;
    }
    
    /* This ensures the deny modal stays above the confirm modal */
    #denyDocumentModal {
        z-index: 1070 !important;
    }
    .hidden-backdrop {
    display: none !important;
}
/* Modal stacking */
#confirmActionModal {
        z-index: 1050;
    }
    
    #pdfViewerModal {
        z-index: 1060;
    }
    
    /* Make sure backdrops stack properly */
    .modal-backdrop.show:not(:first-child) {
        opacity: 0;
    }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
            <div class="logo-section">
                <img src="pics/logo.png" alt="Barangay Baritan Logo">
                <div>
                    <h4 style="margin: 0;">Barangay Baritan</h4>
                    <h6 style="font-size: 10.5px; margin: 0;">Malabon City, Metro Manila, Philippines</h6>
                </div>
            </div>
            <div class="profile-dropdown">
                <div class="dropdown">
                    <?php if (isset($_SESSION['Account_Role'])): ?>
                        <span style="margin-right: 10px; color: white; font-size: 15px; font-weight: Semi-Bold;">
                            <?php echo $_SESSION['Account_Role']; ?>
                        </span>
                    <?php endif; ?>
                    <button class="btn dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="#" onclick="document.getElementById('logoutForm').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        <form id="logoutForm" action="../src/logout.php" method="POST" style="display: none;">
                            <input type="hidden" name="logoutButton" value="1">
                        </form>
                    </ul>
                </div>
            </div>
        </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="residents.php"><i class="fas fa-users"></i>Residents</a>
        <a href="announcement.php"><i class="fas fa-bullhorn"></i>Announcement</a>
        <a href="document.php" class="active"><i class="fas fa-file-alt"></i>Documents</a>
        <a href="approved_document.php"><i class="fas fa-file-signature"></i>Approved Documents</a>
        <a href="blotter_report.php"><i class="fas fa-clipboard-list"></i>Blotter Report</a>
        <a href="complaint_report.php"><i class="fas fa-exclamation-circle"></i>Complaint Report</a>
        <a href="reservation.php"><i class="fas fa-calendar-alt"></i>Reservations</a>
        <a href="tracking_records.php"><i class="fas fa-calendar-alt"></i>Tracking Records</a>
        <a href="admin_management.php"><i class="fas fa-tools"></i>Admin Management</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Document Management</h2>
        
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="documentTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-tab-pane" type="button" role="tab" aria-controls="pending-tab-pane" aria-selected="true">
                    <i class="fas fa-clock"></i> Pending <span class="badge bg-warning"><?php echo $pendingCount; ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved-tab-pane" type="button" role="tab" aria-controls="approved-tab-pane" aria-selected="false">
                    <i class="fas fa-check-circle"></i> Approved 
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="denied-tab" data-bs-toggle="tab" data-bs-target="#denied-tab-pane" type="button" role="tab" aria-controls="denied-tab-pane" aria-selected="false">
                    <i class="fas fa-times-circle"></i> Denied
                </button>
            </li>
        </ul>

        <div class="tab-content" id="documentTabsContent">
            <!-- Pending Documents Tab -->
            <div class="tab-pane fade show active" id="pending-tab-pane" role="tabpanel" aria-labelledby="pending-tab" tabindex="0">
            <div class="search-filter">
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-primary">
                        Total Pending: <?php echo $pendingCount; ?>
                    </span>
                </div>
                <div class="input-group" style="width: 300px;">
                    <input type="text" id="pendingSearch" class="form-control" placeholder="Search pending documents...">
                    <button class="btn btn-primary" type="button" style="background-color: #1C3A5B; border-color: #1C3A5B;" id="pendingSearchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

                <div class="table-container">
                    <table class="documents-table">
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Resident Name</th>
                                <th>Document Type</th>
                                <th>Purpose</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $pendingQuery = "SELECT r.*, CONCAT(res.FirstName, ' ', res.LastName) AS resident_name 
                                          FROM request_document_tbl r
                                          JOIN residents_information_tbl res ON r.Resident_ID = res.Resident_ID
                                          WHERE r.Request_Status = 'Pending'
                                          ORDER BY r.Request_Date DESC";
                            $pendingResult = $conn->query($pendingQuery);
                            
                            while ($row = $pendingResult->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?php echo $row['Request_ID']; ?></td>
                                <td><?php echo htmlspecialchars($row['resident_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Document_Type']); ?></td>
                                <td><?php echo htmlspecialchars($row['Purpose']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($row['Request_Date'])); ?></td>
                                <td><span class="badge badge-pending">Pending</span></td>
                                <td>
                                <button class="btn btn-sm btn-view" data-bs-toggle="modal" data-bs-target="#viewDocumentModal" 
                                    data-document-id="<?php echo $row['Request_ID']; ?>"
                                    data-document-type="<?php echo htmlspecialchars($row['Document_Type']); ?>"
                                    data-purpose="<?php echo htmlspecialchars($row['Purpose']); ?>"
                                    data-resident-name="<?php echo htmlspecialchars($row['resident_name']); ?>"
                                    data-request-date="<?php echo date('M d, Y', strtotime($row['Request_Date'])); ?>">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                    <button class="btn btn-sm btn-approve approve-doc" data-document-id="<?php echo $row['Request_ID']; ?>">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <button class="btn btn-sm btn-deny deny-doc" data-document-id="<?php echo $row['Request_ID']; ?>">
                                        <i class="fas fa-times"></i> Deny
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Approved Documents Tab -->
            <div class="tab-pane fade" id="approved-tab-pane" role="tabpanel" aria-labelledby="approved-tab" tabindex="0">
                <div class="search-filter">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary">
                            Total Approved: <?php echo $approvedCount; ?>
                        </span>
                    </div>
                    <div class="input-group" style="width: 300px;">
                        <input type="text" id="approvedSearch" class="form-control" placeholder="Search approved documents...">
                        <button class="btn btn-primary" type="button" style="background-color: #1C3A5B; border-color: #1C3A5B;" id="approvedSearchBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="table-container">
                    <table class="documents-table">
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Resident Name</th>
                                <th>Document Type</th>
                                <th>Purpose</th>
                                <th>Request Date</th>
                                <th>Approved Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $approvedQuery = "SELECT r.*, CONCAT(res.FirstName, ' ', res.LastName) AS resident_name 
                                             FROM request_document_tbl r
                                             JOIN residents_information_tbl res ON r.Resident_ID = res.Resident_ID
                                             WHERE r.Request_Status = 'Approved'
                                             ORDER BY r.Request_Date DESC";
                            $approvedResult = $conn->query($approvedQuery);
                            
                            while ($row = $approvedResult->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?php echo $row['Request_ID']; ?></td>
                                <td><?php echo htmlspecialchars($row['resident_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Document_Type']); ?></td>
                                <td><?php echo htmlspecialchars($row['Purpose']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($row['Request_Date'])); ?></td>
                                <td><?php echo isset($row['Process_Date']) ? date('M d, Y', strtotime($row['Process_Date'])) : 'N/A'; ?></td>
                                <td><span class="badge badge-approved">Approved</span></td>
                                <td>
                                <button class="btn btn-sm btn-view" data-bs-toggle="modal" data-bs-target="#viewDocumentModal" 
                                    data-document-id="<?php echo $row['Request_ID']; ?>"
                                    data-document-type="<?php echo htmlspecialchars($row['Document_Type']); ?>"
                                    data-purpose="<?php echo htmlspecialchars($row['Purpose']); ?>"
                                    data-resident-name="<?php echo htmlspecialchars($row['resident_name']); ?>"
                                    data-request-date="<?php echo date('M d, Y', strtotime($row['Request_Date'])); ?>">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Denied Documents Tab -->
            <div class="tab-pane fade" id="denied-tab-pane" role="tabpanel" aria-labelledby="denied-tab" tabindex="0">
                <div class="search-filter">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary">
                            Total Denied: <?php echo $deniedCount; ?>
                        </span>
                    </div>
                    <div class="input-group" style="width: 300px;">
                        <input type="text" id="deniedSearch" class="form-control" placeholder="Search denied documents...">
                        <button class="btn btn-primary" type="button" style="background-color: #1C3A5B; border-color: #1C3A5B;" id="deniedSearchBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="table-container">
                    <table class="documents-table">
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Resident Name</th>
                                <th>Document Type</th>
                                <th>Purpose</th>
                                <th>Request Date</th>
                                <th>Denied Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $deniedQuery = "SELECT r.*, CONCAT(res.FirstName, ' ', res.LastName) AS resident_name 
                                          FROM request_document_tbl r
                                          JOIN residents_information_tbl res ON r.Resident_ID = res.Resident_ID
                                          WHERE r.Request_Status = 'Rejected'
                                          ORDER BY r.Request_Date DESC";
                            $deniedResult = $conn->query($deniedQuery);
                            
                            while ($row = $deniedResult->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?php echo $row['Request_ID']; ?></td>
                                <td><?php echo htmlspecialchars($row['resident_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Document_Type']); ?></td>
                                <td><?php echo htmlspecialchars($row['Purpose']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($row['Request_Date'])); ?></td>
                                <td><?php echo isset($row['Process_Date']) ? date('M d, Y', strtotime($row['Process_Date'])) : 'N/A'; ?></td>
                                <td><span class="badge badge-denied">Denied</span></td>
                                <td>
                                <button class="btn btn-sm btn-view" data-bs-toggle="modal" data-bs-target="#viewDocumentModal" 
                                    data-document-id="<?php echo $row['Request_ID']; ?>"
                                    data-document-type="<?php echo htmlspecialchars($row['Document_Type']); ?>"
                                    data-purpose="<?php echo htmlspecialchars($row['Purpose']); ?>"
                                    data-resident-name="<?php echo htmlspecialchars($row['resident_name']); ?>"
                                    data-request-date="<?php echo date('M d, Y', strtotime($row['Request_Date'])); ?>">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- View Document Modal -->
<div class="modal fade" id="viewDocumentModal" tabindex="-1" aria-labelledby="viewDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewDocumentModalLabel">Document Request Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <dl class="document-details">
                            <dt>Request ID:</dt>
                            <dd id="modalRequestId">-</dd>
                            
                            <dt>Resident Name:</dt>
                            <dd id="modalResidentName">-</dd>
                            
                            <dt>Document Type:</dt>
                            <dd id="modalDocumentType">-</dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="document-details">
                            <dt>Request Date:</dt>
                            <dd id="modalRequestDate">-</dd>
                            
                            <dt>Purpose:</dt>
                            <dd id="modalPurpose">-</dd>
                            
                            <dt>Status:</dt>
                            <dd><span class="badge" id="modalStatus">-</span></dd>
                        </dl>
                    </div>
                </div>
                
                <!-- Denial Reason Section (hidden by default) -->
                <div id="denialReasonSection" style="display: none;" class="mt-4">
                    <h5>Reason for Denial</h5>
                    <div class="mb-3">
                        <label for="denyReason" class="form-label">Reason:</label>
                        <select class="form-select" id="denyReason" required>
                            <option value="" selected disabled>Select a reason</option>
                            <option value="Incomplete information">Incomplete information</option>
                            <option value="Invalid purpose">Invalid purpose</option>
                            <option value="Unverified resident">Unverified resident</option>
                            <option value="Other">Other (please specify)</option>
                        </select>
                    </div>
                    <div class="mb-3" id="otherReasonContainer" style="display: none;">
                        <label for="otherReason" class="form-label">Specify Reason</label>
                        <textarea class="form-control" id="otherReason" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="confirmDenialBtn" class="btn btn-danger" style="display: none;">
                    <i class="fas fa-times me-1"></i> Confirm Denial
                </button>
            </div>
        </div>
    </div>
</div>
   

    <!-- PDF Viewer Modal (for View action) -->
<div class="modal fade" id="pdfViewerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Document Preview</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="pdfPreviewFrame" style="width:100%; height:500px; border:none;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a id="downloadPdfBtn" class="btn btn-primary" download>
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>

 <!-- Approval Confirmation Modal -->
 <div class="modal fade" id="approveDocumentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Confirm Document Approval</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <dl class="document-details">
                                <dt>Request ID:</dt>
                                <dd id="approveRequestId">-</dd>
                                
                                <dt>Resident Name:</dt>
                                <dd id="approveResidentName">-</dd>
                                
                                <dt>Document Type:</dt>
                                <dd id="approveDocumentType">-</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="document-details">
                                <dt>Request Date:</dt>
                                <dd id="approveRequestDate">-</dd>
                                
                                <dt>Purpose:</dt>
                                <dd id="approvePurpose">-</dd>
                                
                                <dt>Status:</dt>
                                <dd><span class="badge badge-pending">Pending</span></dd>
                            </dl>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-center mb-3">
                        <button id="viewDocumentForApproveBtn" class="btn btn-primary">
                            <i class="fas fa-file-pdf me-2"></i> View Document
                        </button>
                    </div>
                    
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Are you sure you want to approve this document request?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="post" action="process_document.php" style="display:inline;">
                    <input type="hidden" name="action" value="approve">
                    <input type="hidden" name="request_id" value="<?php echo $row['Request_ID']; ?>">
                    <button type="button" id="confirmApproveBtn" class="btn btn-success">
                        <i class="fas fa-check me-1"></i> Confirm Approval
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Denial Confirmation Modal -->
<div class="modal fade" id="denyDocumentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Document Denial</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <dl class="document-details">
                            <dt>Request ID:</dt>
                            <dd id="denyRequestId">-</dd>
                            
                            <dt>Resident Name:</dt>
                            <dd id="denyResidentName">-</dd>
                            
                            <dt>Document Type:</dt>
                            <dd id="denyDocumentType">-</dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="document-details">
                            <dt>Request Date:</dt>
                            <dd id="denyRequestDate">-</dd>
                            
                            <dt>Purpose:</dt>
                            <dd id="denyPurpose">-</dd>
                            
                            <dt>Status:</dt>
                            <dd><span class="badge badge-pending">Pending</span></dd>
                        </dl>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="denyModalReason" class="form-label">Reason for Denial:</label>
                    <select class="form-select" id="denyModalReason" required>
                        <option value="" selected disabled>Select a reason</option>
                        <option value="Incomplete information">Incomplete information</option>
                        <option value="Invalid purpose">Invalid purpose</option>
                        <option value="Unverified resident">Unverified resident</option>
                        <option value="Other">Other (please specify)</option>
                    </select>
                </div>

                <div class="mb-3" id="denyModalOtherReasonContainer" style="display: none;">
                    <label for="denyModalOtherReason" class="form-label">Specify Reason</label>
                    <textarea class="form-control" id="denyModalOtherReason" rows="3" placeholder="Please specify the reason..."></textarea>
                </div>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> This action cannot be undone. Please provide a clear reason for denial.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmDenyBtn" class="btn btn-danger">
                    <i class="fas fa-times me-1"></i> Confirm Denial
                </button>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
$(document).ready(function() {
    // Search functionality for pending documents
    $('#pendingSearchBtn').click(function() {
        searchDocuments('pending');
    });
    
    $('#pendingSearch').keypress(function(e) {
        if (e.which === 13) { // Enter key
            searchDocuments('pending');
        }
    });
    
    // Search functionality for approved documents
    $('#approvedSearchBtn').click(function() {
        searchDocuments('approved');
    });
    
    $('#approvedSearch').keypress(function(e) {
        if (e.which === 13) { // Enter key
            searchDocuments('approved');
        }
    });
    
    // Search functionality for denied documents
    $('#deniedSearchBtn').click(function() {
        searchDocuments('denied');
    });
    
    $('#deniedSearch').keypress(function(e) {
        if (e.which === 13) { // Enter key
            searchDocuments('denied');
        }
    });
    
    function searchDocuments(status) {
        const searchTerm = $(`#${status}Search`).val().toLowerCase();
        const table = $(`#${status}-tab-pane table tbody tr`);
        
        table.each(function() {
            const row = $(this);
            const requestId = row.find('td:eq(0)').text().toLowerCase();
            const residentName = row.find('td:eq(1)').text().toLowerCase();
            const docType = row.find('td:eq(2)').text().toLowerCase();
            const requestDate = row.find('td:eq(4)').text().toLowerCase();
            
            // Check if search term matches any of these fields
            if (requestId.includes(searchTerm) || 
                residentName.includes(searchTerm) || 
                docType.includes(searchTerm) ||
                requestDate.includes(searchTerm)) {
                row.show();
            } else {
                row.hide();
            }
        });
    }

    let currentRequestId = null; // Store the current request ID
    
    // View Document Modal handling
    $('#viewDocumentModal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const requestId = button.data('document-id');
        const documentType = button.data('document-type');
        const purpose = button.data('purpose');
        const residentName = button.data('resident-name');
        const requestDate = button.data('request-date');
        
        const modal = $(this);
        modal.find('#modalRequestId').text(requestId);
        modal.find('#modalDocumentType').text(documentType);
        modal.find('#modalPurpose').text(purpose);
        modal.find('#modalResidentName').text(residentName);
        modal.find('#modalRequestDate').text(requestDate);
        
        // Set status badge based on which tab it's from
        if (button.closest('#pending-tab-pane').length) {
            modal.find('#modalStatus').text('Pending').removeClass().addClass('badge badge-pending');
        } else if (button.closest('#approved-tab-pane').length) {
            modal.find('#modalStatus').text('Approved').removeClass().addClass('badge badge-approved');
        } else if (button.closest('#denied-tab-pane').length) {
            modal.find('#modalStatus').text('Denied').removeClass().addClass('badge badge-denied');
        }
    });
    
    // Approve button clicked
    $('.approve-doc').click(function() {
        currentRequestId = $(this).data('document-id');
        
        $.ajax({
            url: 'fetch_request_details.php',
            method: 'POST',
            data: { request_id: currentRequestId },
            dataType: 'json',
            success: function(response) {
                // Populate the approval modal with document details
                $('#approveRequestId').text(response.request_id);
                $('#approveResidentName').text(response.resident_name);
                $('#approveDocumentType').text(response.document_type);
                $('#approvePurpose').text(response.purpose);
                $('#approveRequestDate').text(response.request_date);
                
                $('#approveDocumentModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error fetching request details:", error);
                alert("Failed to load document details. Please try again.");
            }
        });
    });

    // Deny button clicked
    $('.deny-doc').click(function() {
        currentRequestId = $(this).data('document-id');
        
        $.ajax({
            url: 'fetch_request_details.php',
            method: 'POST',
            data: { request_id: currentRequestId },
            dataType: 'json',
            success: function(response) {
                // Populate the denial modal with document details
                $('#denyRequestId').text(response.request_id);
                $('#denyResidentName').text(response.resident_name);
                $('#denyDocumentType').text(response.document_type);
                $('#denyPurpose').text(response.purpose);
                $('#denyRequestDate').text(response.request_date);
                
                // Reset the deny form
                $('#denyModalReason').val('').trigger('change');
                $('#denyModalOtherReason').val('');
                
                $('#denyDocumentModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error fetching request details:", error);
                alert("Failed to load document details. Please try again.");
            }
        });
    });

    // Show/hide other reason textarea based on deny reason selection
    $(document).on('change', '#denyModalReason', function() {
        if ($(this).val() === 'Other') {
            $('#denyModalOtherReasonContainer').show();
            $('#denyModalOtherReason').prop('required', true);
        } else {
            $('#denyModalOtherReasonContainer').hide();
            $('#denyModalOtherReason').prop('required', false);
        }
    });

    // View document button in approval modal
    $('#viewDocumentForApproveBtn').click(function() {
        if (currentRequestId) {
            $('#approveDocumentModal').modal('hide');
            $('#pdfPreviewFrame').attr('src', `generate_document.php?request_id=${currentRequestId}`);
            $('#downloadPdfBtn').attr('href', `generate_document.php?request_id=${currentRequestId}&download=1`);
            $('#pdfViewerModal').modal('show');
        }
    });

    // When PDF viewer is closed, show the approval modal again
    $('#pdfViewerModal').on('hidden.bs.modal', function() {
        $('#approveDocumentModal').modal('show');
    });

    


});
</script>
   
</body>
</html>