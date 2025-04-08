<!DOCTYPE html>
<html lang="en">
<head>
<?php

require '../src/connect.php'; // Use 'include' or 'require' to load the file
require '../src/account.php';
require '../src/residentInfo.php';


$FirstName = $_SESSION['User_Data']['FirstName'] ?? '';
$LastName = $_SESSION['User_Data']['LastName'] ?? '';
$Address = $_SESSION['User_Data']['Address']?? '';
$userEmail =  $_SESSION['User_Data']['Resident_Email'] ?? '';
$isHead = $_SESSION['User_Data']['Resident_Role'] == 'Head';



$familyID = $_SESSION['User_Data']['Family_Name_ID'] ?? '';
$familyMembers = []; // Initialize an empty array


// Fetch residents with the same Family ID
$query = "SELECT Resident_ID, Resident_Email, Role FROM residents_information_tbl WHERE Family_Name_ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $familyID);
$stmt->execute();
$result = $stmt->get_result();

$members = [];
while ($row = $result->fetch_assoc()) {
    $members[] = $row;
}


//for account

if ($familyID) {
    $query = "SELECT r.Resident_ID, r.FirstName, r.Role 
              FROM residents_information_tbl r
              LEFT JOIN family_name_tbl f ON r.Family_Name_ID = f.Family_Name_ID
              LEFT JOIN account_tbl acc ON f.Account_ID = acc.Account_ID
              LEFT JOIN account_setting_tbl a ON r.Resident_ID = a.Resident_ID
              WHERE r.Family_Name_ID = ? 
              AND (r.Role = 'Head' OR a.Profile_ID IS NOT NULL)";
    
    $stmtAccount = $conn->prepare($query);

    if (!$stmtAccount) {
        die("🔥 SQL Error: " . $conn->error); // Debugging output
    }
    
    $stmtAccount->bind_param("s", $familyID);
    $stmtAccount->execute();
    $result = $stmtAccount->get_result();

    while ($row = $result->fetch_assoc()) {
        $familyMembers[] = $row;
    }
}



?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../pics/logo.png">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../design.css"> 

    <title>Register</title>
    <style>
        body {
            background-image: url('../pics/BarangayBaritan.png'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed; 

        }
        .modal {
            z-index: 1055 !important;
        }
        .modal-backdrop {
            z-index: 1045 !important;
        }
        /* Custom Styles for the Steps Graphic */
    .step-circle {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-left: 37%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .step-text {
      text-align: left;
    }

    hr {
      height: 3px;
      background-color: #1C3A5B /* Bootstrap primary color */
    }

    .active {
      background-color: #1C3A5B; /* Bootstrap primary color */
    }

    .inactive {
      background-color: gray;
    }

    .button {
    margin: -5% 0% 0% 1%;
    padding: 1.2% 3%;
    font-size: 20px;
    color: white;
    border-radius: 0%;
    background-color: #1C3A5B;
    
    }
    li a {
  color: #017fb1;
}   
    </style>

</head>
<body>
<?php 
        $profilePic = isset($_SESSION['User_Data']['Pic_Path']) && !empty($_SESSION['User_Data']['Pic_Path']) 
            ? '../resident_folder/profile/' . $_SESSION['User_Data']['Pic_Path'] 
            : '../pics/profile.jpg';
        ?>

    <!-- Header -->
    <header class="container-fluid  text-white py-2 px-3" style="background-color: #1C3A5B;">
    <div class="row align-items-center">
        <!-- Logo -->
        <div class="col-auto">
            <img src="../pics/logo.png" alt="Barangay Baritan Logo" class="img-fluid" style="max-width: 75px;">
        </div>
        
        <!-- Barangay Info -->
        <div class="col-auto">
            <h4 class="mb-0">Barangay Baritan</h4>
            <small class="d-block">Malabon City, Metro Manila, Philippines</small>
        </div>
        
        <!-- Navigation - Pushed to right -->
        <div class="col ms-auto">
            <nav class="d-flex justify-content-end align-items-center">
                <div class="d-flex align-items-center">
                    <div class="nav-item px-2">
                        <a href="../index.php" class="text-white text-decoration-none">Home</a>
                    </div>
                    <div class="vr text-white mx-1 d-none d-md-block"></div>
                    <div class="nav-item px-2">
                        <a href="about.php" class="text-white text-decoration-none">About Us</a>
                    </div>
                    <div class="vr text-white mx-1 d-none d-md-block"></div>
                    <div class="nav-item px-2">
                        <a href="service.php" class="text-white text-decoration-none">Services</a>
                    </div>
                    <div class="vr text-white mx-1 d-none d-md-block"></div>
                    <div class="nav-item px-2">
                        <a href="../index.php?#contact" class="text-white text-decoration-none">Contact Us</a>
                    </div>
                    
                    <!-- Profile Dropdown -->
                    <div class="dropdown ms-3" id="profileSection" hidden>
                        <button class="btn dropdown-toggle p-0" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo isset($profilePic) ? $profilePic : '../pics/profile.jpg'; ?>" alt="Profile" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li>
                                <form action="../src/logout.php" method="POST">
                                    <button type="submit" class="dropdown-item" name="logoutButton">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Login Button -->
                    <div class="ms-3" id="loginSection">
                        <a href="login.php" class="btn btn-danger">Log In</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>

    <script>
            // Example code to toggle between login and profile sections
    document.addEventListener('DOMContentLoaded', function() {
        const isLoggedIn = <?php echo isset($_SESSION['User_Data']) ? 'true' : 'false'; ?>;
        
        if (isLoggedIn) {
            document.getElementById('profileSection').removeAttribute('hidden');
            document.getElementById('loginSection').style.display = 'none';
        } else {
            document.getElementById('loginSection').style.display = 'block';
        }
    });
    </script>

    <!-- END HEADER -->

    <?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success m-3" ><?= $_SESSION['success_message']; ?></div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger m-3"><?= $_SESSION['error_message']; ?></div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

    <div class="container mt-5 text-center" style="background-color: white; padding: 3%; margin-bottom: 5%;"> 
    <div class="row" style="width: 95%; height: auto; margin: auto; padding: 10px;">
    <!-- Profile Picture Column -->
    <div class="col-md-2 mt-4">
        <!-- Current Profile Picture -->
        
        <img src="<?= $profilePic ?>" id="profilePreview" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
        
        <!-- Upload Form -->
        <form id="profilePicForm" action="../src/update_profile_pic.php" method="POST" enctype="multipart/form-data" class="mt-3 text-center">
            <input type="file" id="profilePicInput" name="profile_pic" accept="image/*" class="d-none">
            <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('profilePicInput').click()">
                <i class="fas fa-camera"></i> Change Photo
            </button>
            <button type="submit" class="btn btn-success btn-sm mt-2" id="uploadBtn" style="display: none;">
                <i class="fas fa-upload"></i> Save Image
            </button>
        </form>
    </div>

    <!-- Profile Info Column -->
    <div class="col-md-8" style="text-align: left;">
        <div class="container">
            <h4 class="mt-4"><?= htmlspecialchars($FirstName . ' ' . $LastName) ?></h4>
            <div class="h1">
                <?= htmlspecialchars($LastName) ?> <span class="lead d-inline">Family</span>
            </div>
            <div class="lead" style="font-size: 16px;">
                <?= htmlspecialchars($userEmail) ?>
            </div>
            <div class="lead" style="font-size: 16px;">
                <?= htmlspecialchars($Address) ?>
            </div>
        </div>
    </div>

    <!-- Action Buttons Column -->
    <div class="col-md-2 d-flex flex-column justify-content-end">
        <div class="d-flex flex-column gap-2">
            <button type="button" id="switch_button" class="btn btn-primary" 
                data-bs-toggle="modal" data-bs-target="#account">
                Switch Account
            </button>

            <?php if (!$isHead): ?>  
            <button id="edit_button" class="btn btn-warning text-white" 
                data-bs-toggle="modal" data-bs-target="#editModal">
                Edit Profile
            </button>
            <?php endif; ?>

            <?php if ($isHead): ?>  
            <button type="button" id="add_account_button" class="btn btn-primary" 
                data-bs-toggle="modal" data-bs-target="#registerModal">
                Add Member
            </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Preview image before upload
document.getElementById('profilePicInput').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('profilePreview').src = e.target.result;
            document.getElementById('uploadBtn').style.display = 'inline-block';
        }
        
        reader.readAsDataURL(this.files[0]);
    }
});

// Show loading indicator during upload
document.getElementById('profilePicForm').addEventListener('submit', function() {
    document.getElementById('uploadBtn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
    document.getElementById('uploadBtn').disabled = true;
});
</script>



        <hr>
     <!-- Family Table -->
     <div class="display-5" style="text-align: left;">
    Family Members
</div>
<div class="table-responsive">
<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Full Name</th>
            <th scope="col">Relationship</th>
            <th scope="col">Age</th>
            <th scope="col">Contact</th>
            <?php if ($isHead): ?>
                <th scope="col" class="text-center">Actions</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody id="tableBody">
        <?php
        if ($familyID) {
            // First get all pending delete requests
            $deleteRequests = [];
            $deleteQuery = "SELECT Resident_ID, Status FROM delete_member_tbl WHERE Status = 'Pending'";
            $deleteResult = $conn->query($deleteQuery);
            while ($deleteRow = $deleteResult->fetch_assoc()) {
                $deleteRequests[$deleteRow['Resident_ID']] = $deleteRow['Status'];
            }
            
            // Then get family members, ordered with Head first
            $query = "SELECT 
                Resident_ID,
                Address,
                FirstName,
                COALESCE(MiddleName, '') AS MiddleName,
                LastName,
                COALESCE(Suffix, '') AS Suffix,
                Sex,
                Date_of_Birth,
                Role,
                Contact_Number,
                Resident_Email,
                Religion,
                Eligibility_Status,
                Civil_Status,
                Emergency_Person,
                Emergency_Contact_No,
                Relationship_to_Person,
                Emergency_Address,
                Occupation,
                TIMESTAMPDIFF(YEAR, Date_of_Birth, CURDATE()) AS Age
            FROM Residents_information_tbl
            WHERE Family_Name_ID = ?
            ORDER BY CASE WHEN Role = 'Head' THEN 0 ELSE 1 END, FirstName";
            
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                die("Query preparation failed: " . $conn->error);
            }
            $stmt->bind_param("s", $familyID);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $count = 0;
            while ($row = $result->fetch_assoc()) {
                $count++;
                $fullName = htmlspecialchars($row['FirstName']) . 
                           (!empty($row['MiddleName']) ? ' ' . htmlspecialchars(substr($row['MiddleName'], 0, 1)) . '.' : '') . 
                           ' ' . htmlspecialchars($row['LastName']) . 
                           (!empty($row['Suffix']) ? ' ' . htmlspecialchars($row['Suffix']) : '');
                
                // Check if this member has a pending delete request
                $isPendingDelete = isset($deleteRequests[$row['Resident_ID']]) && $deleteRequests[$row['Resident_ID']] == 'Pending';
                
                // Highlight the Head row differently
                $isHeadMember = $row['Role'] === 'Head';
                ?>
                <tr <?= $isPendingDelete ? 'class="table-secondary"' : ($isHeadMember ? 'class="table-primary"' : '') ?>>
                    <th scope="row"><?= $count ?></th>
                    <td>
                        <div class="fw-bold"><?= $fullName ?>
                            <?php if ($isHeadMember): ?>
                                <span class="badge bg-primary ms-2">Head</span>
                            <?php endif; ?>
                        </div>
                        <small class="text-muted"><?= htmlspecialchars($row['Resident_Email']) ?></small>
                    </td>
                    <td><?= htmlspecialchars($row['Role']) ?></td>
                    <td><?= htmlspecialchars($row['Age']) ?></td>
                    <td>
                        <div><?= htmlspecialchars($row['Contact_Number']) ?></div>
                        <small class="text-muted"><?= htmlspecialchars($row['Occupation']) ?></small>
                    </td>
                    
                    <?php if ($isHead): ?>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <button class="btn btn-outline-warning" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal"
                                    onclick="populateEditModal(
                                        '<?= htmlspecialchars($row['Resident_ID']) ?>', 
                                        '<?= htmlspecialchars($row['FirstName']) ?>', 
                                        '<?= htmlspecialchars($row['MiddleName']) ?>', 
                                        '<?= htmlspecialchars($row['LastName']) ?>', 
                                        '<?= htmlspecialchars($row['Suffix']) ?>',
                                        '<?= htmlspecialchars($row['Sex']) ?>', 
                                        '<?= htmlspecialchars($row['Date_of_Birth']) ?>', 
                                        '<?= htmlspecialchars($row['Resident_Email']) ?>', 
                                        '<?= htmlspecialchars($row['Contact_Number']) ?>', 
                                        '<?= htmlspecialchars($row['Occupation']) ?>', 
                                        '<?= htmlspecialchars($row['Religion']) ?>', 
                                        '<?= htmlspecialchars($row['Eligibility_Status']) ?>', 
                                        '<?= htmlspecialchars($row['Civil_Status']) ?>', 
                                        '<?= htmlspecialchars($row['Address']) ?>', 
                                        '<?= htmlspecialchars($row['Emergency_Person']) ?>', 
                                        '<?= htmlspecialchars($row['Emergency_Contact_No']) ?>', 
                                        '<?= htmlspecialchars($row['Relationship_to_Person']) ?>', 
                                        '<?= htmlspecialchars($row['Emergency_Address']) ?>', 
                                        '<?= htmlspecialchars($row['Role']) ?>'
                                    )"
                                    <?= $isPendingDelete ? 'disabled' : '' ?>>
                                    <i class="fas fa-edit"></i>
                                </button>
                                <?php if (!$isHeadMember): // Don't allow removal of Head ?>
                                    <button class="btn btn-outline-danger" 
                                        onclick="showDeleteModal('<?= htmlspecialchars($row['Resident_ID']) ?>', '<?= $fullName ?>')"
                                        <?= $isPendingDelete ? 'disabled' : '' ?>>
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                <?php endif; ?>
                                <?php if ($isPendingDelete): ?>
                                    <span class="badge bg-warning text-dark ms-2">Pending Removal</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php
            }

            if ($count === 0) {
                echo '<tr><td colspan="' . ($isHead ? '6' : '5') . '" class="text-center py-4">No family members found.</td></tr>';
            }

            $stmt->close();
        } else {
            echo '<tr><td colspan="' . ($isHead ? '6' : '5') . '" class="text-center py-4">No family members found.</td></tr>';
        }
        ?>
    </tbody>
</table>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Remove Family Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../src/process_delete_member.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="deleteResidentId" name="resident_id">
                    <p>You are about to request removal of: <strong id="deleteMemberName"></strong></p>
                    <div class="mb-3">
                        <label for="deleteReason" class="form-label">Reason for removal:</label>
                        <textarea class="form-control" id="deleteReason" name="delete_reason" rows="3" required></textarea>
                    </div>
                    <div class="alert alert-info">
                        Note: This request will need to be approved by an administrator.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Submit Removal Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showDeleteModal(residentId, fullName) {
    document.getElementById('deleteResidentId').value = residentId;
    document.getElementById('deleteMemberName').textContent = fullName;
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

function confirmDelete(residentId) {
    if (confirm('Are you sure you want to request removal of this family member?')) {
        // You can add AJAX call here if you want to handle it without page reload
        window.location.href = '../src/process_delete_member.php?resident_id=' + residentId;
    }
}
</script>
     <!-- Document Request Table -->
        <div class="display-5" style="text-align: left; padding-top: 2%;">
    Document Requests
</div>
<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th scope="col">Request ID</th>
            <th scope="col">Document Type</th>
            <th scope="col">Purpose</th>
            <th scope="col">Request Date</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Query to get document requests for the current resident
        $query = "SELECT 
                    Request_ID,
                    Document_Type,
                    Purpose,
                    FirstName,
                    MiddleName,
                    LastName,
                    Suffix,
                    DATE_FORMAT(Request_Date, '%M %d, %Y') AS Formatted_Date,
                    Request_Status,
                    Denial_Reason
                  FROM request_document_tbl
                  WHERE Resident_ID = ?
                  ORDER BY Request_Date DESC";
        
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Query preparation failed: " . $conn->error);
        }
        $stmt->bind_param("s", $_SESSION['User_Data']['Resident_ID']); // Assuming you store resident ID in session
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $fullName = htmlspecialchars($row['FirstName']) . 
                           (!empty($row['MiddleName']) ? ' ' . htmlspecialchars(substr($row['MiddleName'], 0, 1)) . '.' : '') . 
                           ' ' . htmlspecialchars($row['LastName']) . 
                           (!empty($row['Suffix']) ? ' ' . htmlspecialchars($row['Suffix']) : '');
                
                $statusBadge = '';
                switch ($row['Request_Status']) {
                    case 'Pending':
                        $statusBadge = '<span class="badge bg-warning text-dark">Pending</span>';
                        break;
                    case 'Rejected':
                        $statusBadge = '<span class="badge bg-danger">Rejected</span>';
                        break;
                    case 'Approved':
                        $statusBadge = '<span class="badge bg-success">Approved</span>';
                        break;
                    default:
                        $statusBadge = '<span class="badge bg-secondary">' . htmlspecialchars($row['Request_Status']) . '</span>';
                }
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['Request_ID']) ?></td>
                    <td><?= htmlspecialchars($row['Document_Type']) ?></td>
                    <td><?= htmlspecialchars($row['Purpose']) ?></td>
                    <td><?= htmlspecialchars($row['Formatted_Date']) ?></td>
                    <td><?= $statusBadge ?></td>
                    <td>
                        <?php if ($row['Request_Status'] == 'Pending'): ?>
                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                <i class="fas fa-info-circle"></i> Details
                            </button>
                        <?php elseif ($row['Request_Status'] == 'Rejected'): ?>
                            <button class="btn btn-outline-danger btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#requestDetailsModal"
                                    onclick="showRequestDetails(
                                        '<?= htmlspecialchars($row['Request_ID']) ?>',
                                        '<?= htmlspecialchars($row['Document_Type']) ?>',
                                        '<?= htmlspecialchars($row['Purpose']) ?>',
                                        '<?= $fullName ?>',
                                        '<?= htmlspecialchars($row['Formatted_Date']) ?>',
                                        'Rejected',
                                        '<?= htmlspecialchars($row['Denial_Reason']) ?>'
                                    )">
                                <i class="fas fa-info-circle"></i> Details
                            </button>
                        <?php elseif ($row['Request_Status'] == 'Approved'): ?>
                            <button class="btn btn-outline-success btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#requestDetailsModal"
                                    onclick="showRequestDetails(
                                        '<?= htmlspecialchars($row['Request_ID']) ?>',
                                        '<?= htmlspecialchars($row['Document_Type']) ?>',
                                        '<?= htmlspecialchars($row['Purpose']) ?>',
                                        '<?= $fullName ?>',
                                        '<?= htmlspecialchars($row['Formatted_Date']) ?>',
                                        'Approved',
                                        ''
                                    )">
                                <i class="fas fa-info-circle"></i> Details
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo '<tr><td colspan="6" class="text-center py-4">No document requests found.</td></tr>';
        }
        $stmt->close();
        ?>
    </tbody>
</table>

<!-- Request Details Modal -->
<div class="modal fade" id="requestDetailsModal" tabindex="-1" aria-labelledby="requestDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestDetailsModalLabel">Request Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Request ID:</strong> <span id="detailRequestId"></span></p>
                        <p><strong>Document Type:</strong> <span id="detailDocumentType"></span></p>
                        <p><strong>Purpose:</strong> <span id="detailPurpose"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Request Date:</strong> <span id="detailRequestDate"></span></p>
                        <p><strong>Status:</strong> <span id="detailStatus"></span></p>
                        <p><strong>Requested By:</strong> <span id="detailRequesterName"></span></p>
                    </div>
                </div>
                <div class="alert" id="statusAlert">
                    <!-- Status message will appear here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               
            </div>
        </div>
    </div>
</div>

<script>
function showRequestDetails(requestId, documentType, purpose, requesterName, requestDate, requestStatus, denialReason) {
    // Set basic details
    document.getElementById('detailRequestId').textContent = requestId;
    document.getElementById('detailDocumentType').textContent = documentType;
    document.getElementById('detailPurpose').textContent = purpose;
    document.getElementById('detailRequesterName').textContent = requesterName;
    document.getElementById('detailRequestDate').textContent = requestDate;
    
    // Set status with appropriate styling
    const statusElement = document.getElementById('detailStatus');
    statusElement.innerHTML = '';
    let statusBadge;
    switch(requestStatus) {
        case 'Pending':
            statusBadge = '<span class="badge bg-warning text-dark">Pending</span>';
            break;
        case 'Rejected':
            statusBadge = '<span class="badge bg-danger">Rejected</span>';
            break;
        case 'Approved':
            statusBadge = '<span class="badge bg-success">Approved</span>';
            break;
        default:
            statusBadge = '<span class="badge bg-secondary">' + requestStatus + '</span>';
    }
    statusElement.innerHTML = statusBadge;
    
    // Set status message and show/hide download button
    const alertElement = document.getElementById('statusAlert');
    const downloadBtn = document.getElementById('downloadBtn');
    alertElement.className = 'alert'; // Reset classes
    
    if (requestStatus === 'Rejected') {
        alertElement.classList.add('alert-danger');
        alertElement.innerHTML = `<strong>Rejection Reason:</strong> ${denialReason || 'No reason provided.'}`;
        downloadBtn.style.display = 'none';
    } else if (requestStatus === 'Approved') {
        alertElement.classList.add('alert-success');
        alertElement.innerHTML = `<strong>Approval Notice:</strong> Your document is ready for pickup at the barangay office.`;
        downloadBtn.style.display = 'block';
        downloadBtn.onclick = function() {
            window.location.href = `download_document.php?request_id=${requestId}`;
        };
    } else {
        alertElement.classList.add('alert-info');
        alertElement.innerHTML = `<strong>Status:</strong> Your request is currently being processed.`;
        downloadBtn.style.display = 'none';
    }
}
</script>






<!-- Barangay ID Table -->
<div class="display-5" style="text-align: left; padding-top: 2%;">
    Barangay ID Requests
</div>
<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th scope="col">ID Number</th>
            <th scope="col">Full Name</th>
            <th scope="col">Request Date</th>
            <th scope="col">Valid Until</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Query to get Barangay ID requests for the current resident
        $query = "SELECT 
                    Barangay_ID,
                    FullName,
                    DATE_FORMAT(Date_Created, '%M %d, %Y') AS Formatted_Date,
                    Valid_Until,
                    Status,
                    TwoByTwo,
                    Denial_Reason
                  FROM barangay_id_tbl
                  WHERE Resident_ID = ?
                  ORDER BY Date_Created DESC";
        
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Query preparation failed: " . $conn->error);
        }
        $stmt->bind_param("s", $_SESSION['User_Data']['Resident_ID']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Format Valid_Until to match April 08, 2025 format
                $requestDate = $row['Formatted_Date'];
                $validUntilFormatted = '';
                if (!empty($row['Valid_Until'])) {
                    $validUntilDate = DateTime::createFromFormat('F j, Y', $row['Valid_Until']);
                    if ($validUntilDate) {
                        $validUntilFormatted = $validUntilDate->format('F d, Y');
                    } else {
                        $validUntilFormatted = $row['Valid_Until']; // fallback if formatting fails
                    }
                }
                
                $statusBadge = '';
                switch ($row['Status']) {
                    case 'Pending':
                        $statusBadge = '<span class="badge bg-warning text-dark">Pending</span>';
                        break;
                    case 'Rejected':
                        $statusBadge = '<span class="badge bg-danger">Rejected</span>';
                        break;
                    case 'Approved':
                        $statusBadge = '<span class="badge bg-success">Approved</span>';
                        break;
                    default:
                        $statusBadge = '<span class="badge bg-secondary">' . htmlspecialchars($row['Status']) . '</span>';
                }
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['Barangay_ID']) ?></td>
                    <td><?= htmlspecialchars($row['FullName']) ?></td>
                    <td><?= htmlspecialchars($row['Formatted_Date']) ?></td>
                    <td><?= htmlspecialchars($validUntilFormatted) ?></td>
                    <td><?= $statusBadge ?></td>
                    <td>
                        <?php if ($row['Status'] == 'Pending'): ?>
                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                <i class="fas fa-info-circle"></i> Details
                            </button>
                        <?php elseif ($row['Status'] == 'Rejected'): ?>
                            <button class="btn btn-outline-danger btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#idDetailsModal"
                                    onclick="showIdDetails(
                                        '<?= htmlspecialchars($row['Barangay_ID']) ?>',
                                        '<?= htmlspecialchars($row['FullName']) ?>',
                                        '<?= htmlspecialchars($row['Formatted_Date']) ?>',
                                        '<?= htmlspecialchars($validUntilFormatted) ?>',
                                        'Rejected',
                                        '<?= htmlspecialchars($row['Denial_Reason']) ?>',
                                        '<?= htmlspecialchars($row['TwoByTwo']) ?>'
                                    )">
                                <i class="fas fa-info-circle"></i> Details
                            </button>
                        <?php elseif ($row['Status'] == 'Approved'): ?>
                            <button class="btn btn-outline-success btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#idDetailsModal"
                                    onclick="showIdDetails(
                                        '<?= htmlspecialchars($row['Barangay_ID']) ?>',
                                        '<?= htmlspecialchars($row['FullName']) ?>',
                                        '<?= htmlspecialchars($row['Formatted_Date']) ?>',
                                        '<?= htmlspecialchars($validUntilFormatted) ?>',
                                        'Approved',
                                        '',
                                        '<?= htmlspecialchars($row['TwoByTwo']) ?>'
                                    )">
                                <i class="fas fa-info-circle"></i> Details
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo '<tr><td colspan="6" class="text-center py-4">No Barangay ID requests found.</td></tr>';
        }
        $stmt->close();
        ?>
    </tbody>
</table>

<!-- ID Details Modal -->
<div class="modal fade" id="idDetailsModal" tabindex="-1" aria-labelledby="idDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="idDetailsModalLabel">Barangay ID Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID Number:</strong> <span id="detailIdNumber"></span></p>
                        <p><strong>Full Name:</strong> <span id="detailFullName"></span></p>
                        <p><strong>Request Date:</strong> <span id="detailRequestDate"><?php echo htmlspecialchars($requestDate); ?></span></p>
                        <p><strong>Valid Until:</strong> <span id="detailValidUntil"></span></p>
                    </div>
                    <div class="col-md-6 text-center">
                        <img id="detailPhoto" src="" class="img-thumbnail" style="max-height: 200px;" alt="ID Photo">
                    </div>
                </div>
                <div class="alert mt-3" id="statusAlert">
                    <!-- Status message will appear here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               
            </div>
        </div>
    </div>
</div>

<script>
function showIdDetails(idNumber, fullName, requestDate, validUntil, status, denialReason, photoPath) {
    // Set basic details
    document.getElementById('detailIdNumber').textContent = idNumber;
    document.getElementById('detailFullName').textContent = fullName;
    document.getElementById('detailRequestDate').textContent = requestDate;
    document.getElementById('detailValidUntil').textContent = validUntil;
    
    // Set photo
    if (photoPath) {
        document.getElementById('detailPhoto').src = '../resident_folder/2x2pic/' + photoPath;
    }
    
    // Set status with appropriate styling
    const statusElement = document.getElementById('statusAlert');
    statusElement.className = 'alert'; // Reset classes
    
    if (status === 'Rejected') {
        statusElement.classList.add('alert-danger');
        statusElement.innerHTML = `<strong>Rejection Reason:</strong> ${denialReason || 'No reason provided.'}`;
        document.getElementById('modalDownloadBtn').style.display = 'none';
    } else if (status === 'Approved') {
        statusElement.classList.add('alert-success');
        statusElement.innerHTML = `<strong>Approval Notice:</strong> Your Barangay ID is ready for download.`;
        document.getElementById('modalDownloadBtn').style.display = 'block';
        document.getElementById('modalDownloadBtn').onclick = function() {
            window.location.href = `download_id.php?id=${idNumber}`;
        };
    } else {
        statusElement.classList.add('alert-info');
        statusElement.innerHTML = `<strong>Status:</strong> Your request is currently being processed.`;
        document.getElementById('modalDownloadBtn').style.display = 'none';
    }
}

function downloadId(idNumber) {
    window.location.href = `download_id.php?id=${idNumber}`;
}
</script>


      
    </div>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    let editButton = document.getElementById("edit_button"); // This is for non-head users

    if (editButton) {
        editButton.addEventListener("click", function () {
            console.log("🟢 Non-head user clicked Edit!");

            // Populate using session data
            <?php if (isset($_SESSION['User_Data'])): ?>
                let sessionData = <?php echo json_encode($_SESSION['User_Data'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;


                console.log("✅ Populating Modal with Session Data:", sessionData);

                populateEditModal(
                    sessionData.Resident_ID || "",
                    sessionData.FirstName || "",
                    sessionData.MiddleName || "",
                    sessionData.LastName || "",
                    sessionData.Suffix || "",
                    sessionData.Sex || "",
                    sessionData.Date_of_Birth || "",
                    sessionData.Resident_Email || "",
                    sessionData.Contact_Number || "",
                    sessionData.Occupation || "",
                    sessionData.Religion || "",
                    sessionData.Eligibility_Status || "",
                    sessionData.Civil_Status || "",
                    sessionData.Address || "",
                    sessionData.Emergency_Person || "",
                    sessionData.Emergency_Contact_No || "",
                    sessionData.Relationship_to_Person || "",
                    sessionData.Emergency_Address || "",
                    sessionData.Resident_Role || ""
                );
            <?php else: ?>
                console.error("❌ Session data not found!");
                alert("Error: Could not load user data.");
            <?php endif; ?>
        });
    } else {
        console.log("ℹ️ No edit button found (possibly for non-head users).");
    }
});
</script>









<!-- Edit Resident Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editResidentModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1C3A5B; color: white;">
                <h5 class="modal-title text-center" id="editResidentModalLabel">Edit Resident Information</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="editResidentForm" action="../src/editProfile.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><strong>Resident ID:</strong></label>
                                <input type="text" class="form-control" id="editResidentId" name="residentID" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>First Name:</strong></label>
                                <input type="text" class="form-control" id="editResidentFirstName" name="first_name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Middle Name:</strong></label>
                                <input type="text" class="form-control" id="editResidentMiddleName" name="middle_name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Last Name:</strong></label>
                                <input type="text" class="form-control" id="editResidentLastName" name="last_name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Suffix:</strong></label>
                                <input type="text" class="form-control" id="editResidentSuffix" name="suffix">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Age:</strong></label>
                                <input type="text" class="form-control" id="editResidentAge" name="age" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Sex:</strong></label>
                                <select class="form-select" id="editResidentSex" name="sex">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Date of Birth:</strong></label>
                                <input type="date" class="form-control" id="editResidentDob" name="dob">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><strong>Role:</strong></label>
                                <select class="form-control" id="editResidentRole" name="role">
                                    <option value="Head">Head of the Family</option>
                                    <option value="Father">Father</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Daughter">Daughter</option>
                                    <option value="Son">Son</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Address:</strong></label>
                                <input type="text" class="form-control" id="editResidentAddress" name="address">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Occupation:</strong></label>
                                <input type="text" class="form-control" id="editResidentOccupation" name="occupation">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Eligibility Status:</strong></label>
                                <!-- <input type="text" class="form-control" id="editResidentEligibility" name="eligibility_status"> -->
                                <select class="form-control" id="editResidentEligibility" name="eligibility_status">
                                  <option value="Person with Disability">PWD (Person with Disability)</option>
                                  <option value="Single Parent">Single Parent</option>
                                  <option value="Employed">Employed</option>
                                  <option value="Unemployed">Unemployed</option>
                                  <option value="Student">Student</option>
                                  <option value="Senior Citizen">Senior Citizen</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Civil Status:</strong></label>
                                <select class="form-select" id="editResidentCivilStatus" name="civil_status">
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Contact Number:</strong></label>
                                <input type="text" class="form-control" id="editResidentContact" name="contact_number">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Email:</strong></label>
                                <input type="email" class="form-control" id="editResidentEmail" name="email">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Religion:</strong></label>
                                <!-- <input type="text" class="form-control" id="editResidentReligion" name="religion"> -->
                                <select class="form-control" id="editResidentReligion" name="religion">
                                    <option value="Roman Catholic" >Roman Catholic</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Jehovah’s Witnesses">Jehovah’s Witnesses</option>
                                    <option value="Christian">Christian</option>
                                    <option value="Iglesia ni Cristo (INC)">Iglesia ni Cristo (INC)</option>
                                    
                                  </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <h6 class="text-center" style="color: #1C3A5B; font-weight: bold;">Emergency Contact</h6>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Emergency Contact Person:</strong></label>
                                <input type="text" class="form-control" id="editResidentEmergencyPerson" name="emergency_person">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Emergency Contact Number:</strong></label>
                                <input type="text" class="form-control" id="editResidentEmergencyContact" name="emergency_contact">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Relationship:</strong></label>
                                <input type="text" class="form-control" id="editResidentRelationship" name="relationship">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label"><strong>Address of the Emergency Contact:</strong></label>
                                <input type="text" class="form-control" id="editResidentEmergencyAddress" name="emergencyAddress">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function setInputValue(id, value) {
    let input = document.getElementById(id);
    if (input) {
        input.value = value || "";
    } else {
        console.warn(`Element not found: ${id}`);
    }
}

function setSelectValue(id, value) {
    let select = document.getElementById(id);
    if (select) {
        let optionExists = [...select.options].some(option => option.value === value);
        select.value = optionExists ? value : select.options[0].value;
    } else {
        console.warn(`Dropdown not found: ${id}`);
    }
}

function calculateAge(dob) {
    if (!dob) return 'N/A';
    let birthDate = new Date(dob);
    let today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    if (today.getMonth() < birthDate.getMonth() || 
        (today.getMonth() === birthDate.getMonth() && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}
function populateEditModal(
    residentId, firstName, middleName, lastName, suffix,  
    sex, dob, email, contact, occupation, religion, 
    eligibility, civilStatus, address, emergencyPerson, 
    emergencyContact, relationship, emergencyAddress, role
) {
    document.getElementById('editResidentId').value = residentId;
    document.getElementById('editResidentFirstName').value = firstName;
    document.getElementById('editResidentMiddleName').value = middleName;
    document.getElementById('editResidentLastName').value = lastName;
    document.getElementById('editResidentSuffix').value = suffix || "";  
    document.getElementById('editResidentSex').value = sex;
    document.getElementById('editResidentDob').value = dob;
    document.getElementById('editResidentEmail').value = email;
    document.getElementById('editResidentContact').value = contact;
    document.getElementById('editResidentOccupation').value = occupation;
    document.getElementById('editResidentReligion').value = religion;
    document.getElementById('editResidentEligibility').value = eligibility;
    document.getElementById('editResidentCivilStatus').value = civilStatus;
    document.getElementById('editResidentAddress').value = address;
    document.getElementById('editResidentEmergencyPerson').value = emergencyPerson;
    document.getElementById('editResidentEmergencyContact').value = emergencyContact;
    document.getElementById('editResidentRelationship').value = relationship;
    document.getElementById('editResidentEmergencyAddress').value = emergencyAddress;
    document.getElementById('editResidentRole').value = role;

    // ✅ Calculate and set Age  
    document.getElementById('editResidentAge').value = calculateAge(dob);
}

function setSelectValue(id, value) {
    let select = document.getElementById(id);
    if (select) {
        select.value = value || select.options[0].value; // Default to the first option if empty
    }
}


</script>





<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalTitle">
    <div class="modal-dialog modal-dialog-centered" role="document" >
      <div class="modal-content"  style="width:  280%;  ">
        <div class="modal-header">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="40" fill="currentColor" class="bi bi-info" viewBox="0 0 16 16">
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
              </svg>
          <h5 class="modal-title" id="exampleModalLongTitle">Privacy Notice
            
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class=" tc_body">
            <ol>
                <li>
                    <h3>Terms of Use</h3>
                    <ul>
                    <li>The terms and conditions set forth in this document govern the use of all services offered by Barangay Baritan, Malabon.</li>
                    <li>By accessing or using any of our services, you agree to comply with these terms.</li>
                    <li>Failure to comply with the terms may result in restricted access or termination of services.</li>
                    <li>For more information, refer to the <a href="https://www.officialgazette.gov.ph/2012/07/23/republic-act-no-10173/" target="_blank">Data Privacy Act of 2012</a> for privacy guidelines.</li>
                    </ul>
                </li>
                <li>
                    <h3>Intellectual Property Rights</h3>
                    <ul>
                    <li>All content, logos, trademarks, and materials provided through the Barangay Baritan Information Management System are protected by intellectual property laws.</li>
                    <li>Unauthorized use or reproduction of materials without prior written consent from Barangay Baritan is prohibited.</li>
                    <li>Barangay Baritan retains ownership over the system’s software and data provided to users.</li>
                    <li>For more information, refer to the <a href="https://www.wipo.int/treaties/en/ip/ptoc/index.html" target="_blank">Intellectual Property Code of the Philippines</a> (Republic Act No. 8293).</li>
                    </ul>
                </li>
                <li>
                    <h3>Prohibited Activities</h3>
                    <ul>
                    <li>Engaging in any activity that disrupts or harms the operation of the Barangay Baritan Information Management System is prohibited.</li>
                    <li>Users must not upload, share, or distribute any malicious content or engage in hacking activities.</li>
                    <li>Any use of the system for fraudulent activities or to violate local laws is strictly prohibited.</li>
                    <li>For more information on online security, refer to the <a href="https://www.officialgazette.gov.ph/2012/04/16/republic-act-no-10175/" target="_blank">Cybercrime Prevention Act of 2012</a>.</li>
                    </ul>
                </li>
                <li>
                    <h3>Termination Clause</h3>
                    <ul>
                    <li>Barangay Baritan reserves the right to suspend or terminate access to the system if users violate the terms outlined in this agreement.</li>
                    <li>Users may request termination of their accounts in accordance with the Barangay Baritan policies.</li>
                    <li>Upon termination, all personal data and access rights may be revoked, subject to applicable laws.</li>
                    <li>For more information on termination and rights of the parties, refer to the <a href="https://www.officialgazette.gov.ph/1991/06/11/republic-act-no-7641/" target="_blank">Labor Code of the Philippines</a> (Book VI: Termination of Employment).</li>
                    </ul>
                </li>
                <li>
                    <h3>Governing Law</h3>
                    <ul>
                    <li>These terms are governed by and construed in accordance with the laws of the Philippines.</li>
                    <li>Any disputes arising from the use of the Barangay Baritan Information Management System will be resolved under the jurisdiction of the courts in Malabon City.</li>
                    <li>Users agree to resolve any disputes amicably before resorting to legal actions.</li>
                    <li>For a comprehensive guide to Philippine law, refer to the <a href="https://www.officialgazette.gov.ph/constitution/" target="_blank">1987 Philippine Constitution</a>.</li>
                    </ul>
                </li>
            </ol>

              </div>
        </div>
        <div class="modal-footer">
         
                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="termsCheckbox">
                            <label class="form-check-label" for="termsCheckbox">
                              I have read and agree to the <br>  <a href="#" style="text-decoration: none;color: #94c8ff; ">Terms and Conditions</a>
                            </label>
                          </div>
                          
                    </div>
                    <div class="col text-center" >
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.reload();">Close</button>
                        <button type="button" class="btn btn-primary" id="submitBtn" disabled style="background-color: #1C3A5B;" data-bs-dismiss="modal" >I Accept</button>
                    
                    </div>
                </div>

                <script>
    document.getElementById("termsCheckbox").addEventListener("change", function() {
        let submitBtn = document.getElementById("submitBtn");
        submitBtn.disabled = !this.checked;
    });

    document.getElementById("submitBtn").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent default behavior (useful in forms)
   
        // Close the current modal
        var registerModal = new bootstrap.Modal(document.getElementById("registerModal"));
        registerModal.hide();  // Close the register modal
        
        // Open the next modal (questionModal)
        var questionModal = new bootstrap.Modal(document.getElementById("questionModal"));
        questionModal.show();  // Open the question modal
    });
</script>
        
                
 
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="registerModalTitle">
    <div class="modal-dialog modal-dialog-centered" role="document">
   

        <div class="modal-content">
            <div class="modal-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="40" fill="currentColor" class="bi bi-info" viewBox="0 0 16 16">
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg>
                <h5 class="modal-title" id="exampleModalLongTitle">Add Member</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Initial text showing options -->
                <p>If you choose "With Account," you will be asked to set a password. If you choose "Without Account," no password will be required.</p>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <!-- Close Button -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.reload();">Close</button>
                </div>

                <div class="text-center mt-3">
                    <!-- Grouped Buttons for With and Without Account -->
                   
                        <div class="btn-group" role="group">
                        <form action="addMember.php" method="POST" id="accountForm">
                            <input type="hidden" id="accountTypeField" name="accountType" value="">
                            <button type="submit" class="btn btn-primary" onclick="setAccountType('with')">With Password</button>
                            <!-- <button type="submit" class="btn btn-primary" onclick="setAccountType('without')">Without Password</button> -->
                        </form>

                        <script>
                            function setAccountType(value) {
                                document.getElementById('accountTypeField').value = value;
                            }
                        </script>
                        </div>
              

                    
                </div>
            </div>
        </div>

    </div>
</div>


 
<!-- Account Selection Modal -->
<div class="modal fade" id="account" tabindex="-1" aria-labelledby="accountModalLabel" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="accountModalLabel">Select Account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center">
          <?php 
          // Sort family members - Head first
          usort($familyMembers, function($a, $b) {
              if ($a['Role'] === 'Head') return -1;
              if ($b['Role'] === 'Head') return 1;
              return 0;
          });
          
          foreach ($familyMembers as $member): 
            // Get profile picture path safely
            $profilePic = isset($member['Pic_Path']) && !empty($member['Pic_Path']) 
              ? '../resident_folder/profile/' . $member['Pic_Path']
              : '../pics/profile.jpg';
              
            // Verify the image file exists
            $imagePath = (isset($member['Pic_Path']) && file_exists('../resident_folder/profile/' . $member['Pic_Path']))
              ? '../resident_folder/profile/' . $member['Pic_Path']
              : '../pics/profile.jpg';
          ?>
            <div class="col-6 d-flex flex-column align-items-center text-center mb-4">
              <a href="#" class="text-decoration-none text-dark account-select" 
                 data-resident-id="<?= htmlspecialchars($member['Resident_ID']) ?>"
                 data-role="<?= htmlspecialchars($member['Role']) ?>"
                 data-is-head="<?= $member['Role'] === 'Head' ? 'true' : 'false' ?>"
                 data-bs-dismiss="modal">
                <img src="<?= $imagePath ?>" 
                     alt="<?= htmlspecialchars($member['FirstName']) ?>" 
                     class="img-fluid rounded-circle profile-img border border-2"
                     style="width: 85px; height: 85px; object-fit: cover; transition: transform 0.3s ease;"
                     onerror="this.onerror=null;this.src='../pics/profile.jpg';">
                <div class="mt-2">
                  <div class="fw-bold">
                    <?= htmlspecialchars($member['FirstName']) ?>
                    <?= isset($member['LastName']) ? ' ' . htmlspecialchars($member['LastName']) : '' ?>
                  </div>
                  <div class="text-muted small"><?= htmlspecialchars($member['Role']) ?></div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
// Account selection handler
document.querySelectorAll('.account-select').forEach(item => {
  item.addEventListener('click', function(e) {
    e.preventDefault();
    const residentId = this.getAttribute('data-resident-id');
    const role = this.getAttribute('data-role');
    const isHead = this.getAttribute('data-is-head') === 'true';
    
    if (isHead) {
      // Directly switch for Head without password
      switchAccount(residentId, role);
    } else {
      // Show password modal for non-Head members
      document.getElementById('residentID').value = residentId;
      const passwordModal = new bootstrap.Modal(document.getElementById('accountPassword'));
      passwordModal.show();
    }
  });
});

// Hover effect for profile images
document.querySelectorAll('.profile-img').forEach(img => {
  img.addEventListener('mouseenter', function() {
    this.style.transform = 'scale(1.1)';
  });
  img.addEventListener('mouseleave', function() {
    this.style.transform = 'scale(1)';
  });
});

function switchAccount(residentId, role) {
  // Submit form via AJAX or redirect
  fetch('../src/switch_account.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `Resident_ID=${encodeURIComponent(residentId)}`
  })
  .then(response => {
    if (response.redirected) {
      window.location.href = response.url;
    } else {
      return response.text().then(text => {
        if (text.includes('Error')) {
          alert(text);
        } else {
          window.location.reload();
        }
      });
    }
  })
  .catch(error => console.error('Error:', error));
}
</script>

<!-- Password Modal -->
<div class="modal fade" id="accountPassword" tabindex="-1" aria-labelledby="accountPasswordLabel" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-white bg-primary">
        <h5 class="modal-title" id="accountPasswordLabel">Enter Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
      </div>
      <div class="modal-body text-center">
        <form id="passwordForm" action="../src/switch_account.php" method="POST">
          <input type="hidden" id="residentID" name="Resident_ID">
          <div class="mb-3 text-start">
            <label for="passwordMember" class="form-label">Password</label>
            <input type="password" name="passwordMember" id="passwordMember" 
                   class="form-control" required placeholder="Enter Password"
                   autocomplete="current-password">
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success">Login</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>







  <script>
    document.getElementById("accountForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Stop default form submission
    this.submit(); // Manually submit
});

      // Handle form submission
      document.getElementById("accountForm").addEventListener("submit", function(event) {
        // Prevent default form submission
        event.preventDefault();

        // Perform validation first
        var firstInvalid = validateInputs();
        
        // If there are validation errors, focus on the first invalid field
        if (firstInvalid) {
            firstInvalid.focus();
        } else {
            // If no validation errors, manually submit the form
            this.submit();
        }
    });

    // Hide or show elements based on session state
    document.addEventListener("DOMContentLoaded", function () {
        var profile = document.getElementById("profile");
        var start = document.getElementById("start");

        <?php if (isset($_SESSION['userEmail'])) { ?>
            profile.hidden = false;
            start.hidden = true;
        <?php } else { ?>
            profile.hidden = true;
            start.hidden = false;
        <?php } ?>
    });

    $(document).ready(function () {
        $("#saveChanges").click(function (event) {
            // Prevent form submission to run validation first
            event.preventDefault();

            // Run the validation function
            var firstInvalid = validateInputs();

            // If there is an invalid field, prevent form submission and focus on the first invalid field
            if (firstInvalid) {
                firstInvalid.focus(); // Focus on the first invalid field
            } else {
                // If no validation errors, manually submit the form
                $('#editResidentForm').submit();
            }
        });
    });

    function validateInputs() {
        var firstInvalid = null;
        var generalRegex = /[^a-zA-Z0-9ñ ]/; // Blocks special characters except space (for general fields)
        var lastNameRegex = /^[a-zA-Zñ -]+$/; // Allows letters, spaces, and hyphens for last name
        var emailRegex = /^[a-zA-Z0-9@.]+$/; // Allows only letters, numbers, @, and .
        var passwordRegex = /^(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/; // Password: 8+ chars, 1 uppercase, 1 special char

        // Loop through all required fields
        $("input[required], select[required]").each(function () {
            var value = $(this).val() ? $(this).val().trim() : ''; // Avoid `.trim()` on null
            var inputType = $(this).attr("type");
            var inputId = $(this).attr("id");
            var isEmail = inputType === "email";
            var isDate = inputType === "date";
            var isPassword = inputId === "password" || inputId === "rePassword";

            // Empty input field check
            if (!value) {
                showError(this, "This field is required.");
                if (!firstInvalid) firstInvalid = this;
            } 
            // Email validation
            else if (isEmail && !emailRegex.test(value)) {
                showError(this, "Only letters, numbers, @, and . are allowed.");
                if (!firstInvalid) firstInvalid = this;
            } 
            // Password validation
            else if (isPassword && !passwordRegex.test(value)) {
                showError(this, "Password must be at least 8 characters, contain an uppercase letter, and a special character.");
                if (!firstInvalid) firstInvalid = this;
            }
            // Last name validation (allows hyphens)
            else if (inputId === "lastName" && !lastNameRegex.test(value)) {
                showError(this, "Only letters, spaces, and hyphens are allowed.");
                if (!firstInvalid) firstInvalid = this;
            }
            // General fields validation (blocks special characters)
            else if (!isEmail && !isDate && !isPassword && inputId !== "lastName" && generalRegex.test(value)) {
                showError(this, "Special characters are not allowed.");
                if (!firstInvalid) firstInvalid = this;
            } 
            // Valid input, remove any previous error message
            else {
                removeError(this);
            }
        });

        return firstInvalid; // Return the first invalid field if any, otherwise null
    }

    // Show error message
    function showError(element, message) {
        $(element).addClass("is-invalid").removeClass("is-valid");
        $(element).next(".invalid-feedback").remove();
        $(element).after('<div class="invalid-feedback">' + message + '</div>');
    }

    // Remove error message
    function removeError(element) {
        $(element).removeClass("is-invalid").addClass("is-valid");
        $(element).next(".invalid-feedback").remove();
    }




// ✅ Show error message
function showError(element, message) {
    $(element).addClass("is-invalid").removeClass("is-valid");
    $(element).next(".invalid-feedback").remove();
    $(element).after('<div class="invalid-feedback">' + message + '</div>');
}

// ✅ Remove error message
function removeError(element) {
    $(element).removeClass("is-invalid").addClass("is-valid");
    $(element).next(".invalid-feedback").remove();
}
    
</script>





</body>
</html>