<?php
require ('../src/connect.php');
require ('../src/account.php');

if (isset($_SESSION['Account_Role'])) {
    if (($_SESSION['type'] === "Super Admin") || ($_SESSION['type'] === "Admin") || ($_SESSION['type'] === "Editor")) {
        $_SESSION['Account_Role'];
    }
    else {
        echo json_encode(['Unauthorized access']);
        header("Location: ../index.php");
        exit(); 
    }
} else {
    header("Location: ../index.php");
    exit();
}
// At the top with other queries (around line 50)
$staffSql = "SELECT * FROM staff_information_tbl";
$staffResult = $conn->query($staffSql);
$totalStaff = $staffResult ? $staffResult->num_rows : 0;

// At the top with other queries
$logSql = "SELECT * FROM admin_activity_log ORDER BY created_at DESC";
$logResult = $conn->query($logSql);
$totalLogs = $logResult ? $logResult->num_rows : 0;

// Fetch all admin accounts (Super Admin, Admin, Editor)
$adminSql = "SELECT Account_ID, User_Email, Role, Type, Status FROM account_tbl WHERE Type IN ('Super Admin', 'Admin', 'Editor')";
$adminResult = $conn->query($adminSql);
$admins = $adminResult->fetch_all(MYSQLI_ASSOC);

// Fetch all resident accounts (Family Account)
$residentSql = "SELECT Account_ID, User_Email, Role, Type, Status FROM account_tbl WHERE Type = 'Family Account'";
$residentResult = $conn->query($residentSql);
$residents = $residentResult->fetch_all(MYSQLI_ASSOC);
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
            margin-left: 250px;
            padding: 20px;
            margin-top: 75px;
        }

        /* Search bar and filter styling */
        .search-filter {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0;
        }

        .search-bar {
            width: 250px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-button,
        .register-button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            background-color: #1C3A5B;
            color: white;
            cursor: pointer;
        }

        .search-button:hover,
        .register-button:hover {
            background-color: #2a4d6e;
        }

        .table-container {
            max-height: 390px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 0;
        }

        .admins-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admins-table th,
        .admins-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .admins-table th {
            background-color: #1C3A5B;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .admins-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .admins-table tr:hover {
            background-color: #f1f1f1;
        }

        /* Modal styling */
        .modal-content {
            border-radius: 10px;
        }

        .modal-header {
            background-color: #1C3A5B;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            border-top: none;
        }

        /* Activity Log Modal Styles */
        .modal-xl {
            max-width: 90%;
        }

        #activityLogModal .table-container {
            max-height: 60vh;
            overflow-y: auto;
        }

        #activityLogModal table {
            width: 100%;
        }

        #activityLogModal th {
            position: sticky;
            top: 0;
            background-color: #1C3A5B;
            color: white;
            z-index: 10;
        }

        #activityLogModal tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Search bar styling */
        .input-group {
            margin-right: 10px;
        }

        #adminSearch, #residentSearch {
            border-radius: 5px 0 0 5px;
        }

        #searchButton, #residentSearchButton {
            border-radius: 0 5px 5px 0;
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
        /* Add some styling for the password requirements */
#passwordHelp ul {
    margin-top: 0.5rem;
    margin-bottom: 0;
}

#passwordHelp li {
    font-size: 0.875rem;
    line-height: 1.5;
}

.text-success {
    color: #28a745 !important;
}

.text-danger {
    color: #dc3545 !important;
}
/* Real-time validation feedback styles */
.form-text i.fa-spin {
    margin-right: 5px;
}

.text-success, .text-danger {
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
/* Validation feedback styles */
.form-text.small {
    font-size: 0.8rem;
    margin-top: 0.25rem;
}

.form-text span {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

/* Input group validation states */
.input-group.is-valid {
    border-color: #28a745;
    border-radius: 0.25rem;
}

.input-group.is-valid .form-control {
    border-color: #28a745;
}

.input-group.is-invalid {
    border-color: #dc3545;
    border-radius: 0.25rem;
}

.input-group.is-invalid .form-control {
    border-color: #dc3545;
}

/* Remove checkmark for invalid inputs */
.input-group.is-invalid .form-control:valid {
    background-image: none;
}

/* Password toggle button */
#togglePassword {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
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
            <a href="document.php"><i class="fas fa-file-alt"></i>Documents</a>
            <a href="approved_document.php"><i class="fas fa-file-signature"></i>Approved Documents</a>
            <a href="blotter_report.php"><i class="fas fa-clipboard-list"></i>Blotter Report</a>
            <a href="complaint_report.php"><i class="fas fa-exclamation-circle"></i>Complaint Report</a>
            <a href="reservation.php"><i class="fas fa-calendar-alt"></i>Reservations</a>
            <a href="tracking_records.php"><i class="fas fa-calendar-alt"></i>Tracking Records</a>
            <a href="admin_management.php" class="active"><i class="fas fa-tools"></i>Admin Management</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
        <h2>Account Management</h2>

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="accountTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin-tab-pane" type="button" role="tab" aria-controls="admin-tab-pane" aria-selected="true">Admin Accounts</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="resident-tab" data-bs-toggle="tab" data-bs-target="#resident-tab-pane" type="button" role="tab" aria-controls="resident-tab-pane" aria-selected="false">Resident Accounts</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="staff-tab" data-bs-toggle="tab" data-bs-target="#staff-tab-pane" type="button" role="tab" aria-controls="staff-tab-pane" aria-selected="false">Staff Information</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="activity-log-tab" data-bs-toggle="tab" data-bs-target="#activity-log-tab-pane" type="button" role="tab" aria-controls="activity-log-tab-pane" aria-selected="false">Admin Activity Log</button>
            </li>
        </ul>


        <div class="tab-content" id="accountTabsContent">
            <!-- Admin Accounts Tab -->
            <div class="tab-pane fade show active" id="admin-tab-pane" role="tabpanel" aria-labelledby="admin-tab" tabindex="0">
                <div class="d-flex justify-content-between mb-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary">
                        Total Admin Account: <?php echo count($admins); ?>
                    </span>
                </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="input-group" style="width: 250px;">
                            <input type="text" id="adminSearch" class="form-control" placeholder="Search by ID or Username...">
                            <button class="btn btn-primary" type="button" id="searchButton" style="background-color: #1C3A5B; border-color: #1C3A5B;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    <table class="admins-table">
                        <thead>
                            <tr>
                                <th>Account ID</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Account Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($admins as $admin): ?>
                            <tr>
                                <td><?php echo $admin['Account_ID']; ?></td>
                                <td><?php echo $admin['User_Email']; ?></td>
                                <td><?php echo $admin['Role']; ?></td>
                                <td><?php echo $admin['Type']; ?></td>
                                <td><?php echo $admin['Status']; ?></td>
                                <td>
                                    <?php if ($admin['Status'] === 'Deactivated'): ?>
                                        <button type="button" class="btn btn-sm btn-success" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#activateModal"
                                            data-account-id="<?php echo $admin['Account_ID']; ?>"
                                            data-current-tab="admin">
                                            <i class="fas fa-check"></i> Activate
                                        </button>
                                    <?php else: ?>
                                        <?php if ($admin['Role'] !== 'Chairman'): ?>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deactivateModal"
                                                data-account-id="<?php echo $admin['Account_ID']; ?>">
                                                <i class="fas fa-times"></i> Deactivate
                                            </button>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Protected</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Resident Accounts Tab -->
            <div class="tab-pane fade" id="resident-tab-pane" role="tabpanel" aria-labelledby="resident-tab" tabindex="0">
            <div class="d-flex justify-content-between mb-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary">
                        Total Resident Account: <?php echo count($residents); ?>
                    </span>
                </div>
                    <div class="input-group" style="width: 250px;">
                        <input type="text" id="residentSearch" class="form-control" placeholder="Search by ID or Username...">
                        <button class="btn btn-primary" type="button" id="residentSearchButton" style="background-color: #1C3A5B; border-color: #1C3A5B;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="table-container">
                    <table class="admins-table">
                        <thead>
                            <tr>
                                <th>Account ID</th>
                                <th>User Email</th>
                                <th>Role</th>
                                <th>Account Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($residents as $resident): ?>
                            <tr>
                                <td><?php echo $resident['Account_ID']; ?></td>
                                <td><?php echo $resident['User_Email']; ?></td>
                                <td><?php echo $resident['Role']; ?></td>
                                <td><?php echo $resident['Type']; ?></td>
                                <td><?php echo $resident['Status']; ?></td>
                                <td>
                                    <?php if ($resident['Status'] === 'Deactivated'): ?>
                                        <button type="button" class="btn btn-sm btn-success" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#activateModal"
                                            data-account-id="<?php echo $resident['Account_ID']; ?>"
                                            data-current-tab="resident">
                                            <i class="fas fa-check"></i> Activate
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deactivateModal"
                                            data-account-id="<?php echo $resident['Account_ID']; ?>">
                                            <i class="fas fa-times"></i> Deactivate
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Staff Information Tab -->
    <div class="tab-pane fade" id="staff-tab-pane" role="tabpanel" aria-labelledby="staff-tab" tabindex="0">
        <div class="d-flex justify-content-between mb-3">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary">
                Total Staff: <?php echo $totalStaff; ?>
            </span>
            
        </div>
        <div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                    <i class="fas fa-plus"></i> Add New Staff
                </button>
        </div>
        <div class="input-group" style="width: 250px;">
            <input type="text" id="staffSearch" class="form-control" placeholder="Search staff...">
            <button class="btn btn-primary" type="button" id="staffSearchButton" style="background-color: #1C3A5B; border-color: #1C3A5B;">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <div class="table-container">
        <table class="admins-table">
            <thead>
                <tr>
                    <th>Staff ID</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Term Start</th>
                    <th>Term End</th>
                    <th>Actions</th>
                    <th>Account ID</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $staffSql = "SELECT * FROM staff_information_tbl";
                $staffResult = $conn->query($staffSql);
                while($staff = $staffResult->fetch_assoc()): 
                ?>
                <tr>
                    <td><?= $staff['staff_id'] ?></td>
                    <td><?= $staff['name'] ?></td>
                    <td><?= $staff['role'] ?></td>
                    <td><?= date('M d, Y', strtotime($staff['start_term'])) ?></td>
                    <td><?= date('M d, Y', strtotime($staff['end_term'])) ?></td>
                    <td>
                        <?php if ($staff['role'] !== 'Chairman'): ?>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editStaffModal" 
                                data-staff-id="<?= $staff['staff_id'] ?>"
                                data-name="<?= $staff['name'] ?>"
                                data-role="<?= $staff['role'] ?>"
                                data-start-term="<?= $staff['start_term'] ?>">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStaffModal" 
                                data-staff-id="<?= $staff['staff_id'] ?>">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        <?php else: ?>
                            <span class="badge bg-secondary">Protected</span>
                        <?php endif; ?>
                    </td>
                    <td>
                            <span class="badge bg-success">Account Assigned</span>
                            <small class="text-muted d-block">ID: <?= $staff['account_id'] ?></small>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
            
            <!-- Admin Activity Log Tab -->
<div class="tab-pane fade" id="activity-log-tab-pane" role="tabpanel" aria-labelledby="activity-log-tab" tabindex="0">
    <div class="d-flex justify-content-between mb-3">
    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-primary">
            Total Logs: <?php echo $logResult->num_rows; ?>
        </span>
    </div>
        <div class="input-group" style="width: 250px;">
            <input type="text" id="activityLogSearch" class="form-control" placeholder="Search logs...">
            <button class="btn btn-primary" type="button" id="activityLogSearchButton" style="background-color: #1C3A5B; border-color: #1C3A5B;">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <div class="table-container">
        <table class="admins-table">
            <thead>
                <tr>
                    <th>Log ID</th>
                    <th>Admin ID</th>
                    <th>Action By</th>
                    <th>Action</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $logSql = "SELECT * FROM admin_activity_log ORDER BY created_at DESC";
                $logResult = $conn->query($logSql);
                
                if ($logResult->num_rows > 0) {
                    while($log = $logResult->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>'.$log['log_id'].'</td>';
                        echo '<td>'.$log['admin_id'].'</td>';
                        echo '<td>'.$log['action_by'].'</td>';
                        echo '<td>'.$log['action'].'</td>';
                        echo '<td>'.$log['created_at'].'</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5" class="text-center">No activity logs found</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
        </div>

        

        

<!-- Edit Staff Modal -->
<div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStaffModalLabel">Edit Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="edit_staff.php" method="POST">
                <input type="hidden" id="editStaffId" name="staff_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editStaffName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="editStaffName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStaffRole" class="form-label">Position/Role</label>
                        <select class="form-select" id="editStaffRole" name="role" required>
                            <option value="Chairman">Chairman</option>
                            <option value="Counselor">Counselor</option>
                            <option value="Secretary">Secretary</option>
                            <option value="Treasurer">Treasurer</option>
                            <option value="Lupon">Lupon</option>
                            <option value="SK">SK</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editStaffStartTerm" class="form-label">Term Start Date</label>
                        <input type="date" class="form-control" id="editStaffStartTerm" name="start_term" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Staff Confirmation Modal -->
<div class="modal fade" id="deleteStaffModal" tabindex="-1" aria-labelledby="deleteStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteStaffModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteStaffForm" action="delete_staff.php" method="POST">
                <input type="hidden" id="deleteStaffId" name="staff_id">
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> This action is irreversible and will permanently delete the staff member and their associated account.
                    </div>
                    <div class="mb-3">
                        <label for="chairmanPasswordDelete" class="form-label">Chairman Password*</label>
                        <input type="password" class="form-control" id="chairmanPasswordDelete" name="chairman_password" required>
                        <div class="form-text">This action requires chairman authorization</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Deletion</button>
                </div>
            </form>
        </div>
    </div>
</div>

       
        <!-- Activation Modal -->
        <div class="modal fade" id="activateModal" tabindex="-1" aria-labelledby="activateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="activateModalLabel">Activate Account</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="activateForm" action="activate_account.php" method="POST">
                        <input type="hidden" id="activateAccountId" name="Account_ID">
                        <input type="hidden" id="activateCurrentTab" name="current_tab">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="activateChairmanPassword" class="form-label">Chairman Password*</label>
                                <input type="password" class="form-control" id="activateChairmanPassword" name="chairman_password" required>
                            </div>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> This action requires Chairman approval and will be logged.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Confirm Activation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Deactivate Modal -->
        <div class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="deactivateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deactivateModalLabel">Deactivate Account</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="deactivateForm" action="deactivate_account.php" method="POST">
                        <input type="hidden" id="deactivateAccountId" name="Account_ID">
                        <input type="hidden" name="current_tab" id="deactivateCurrentTab">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="deactivateReason" class="form-label">Reason for Deactivation*</label>
                                <select class="form-select" id="deactivateReason" name="reason" required onchange="toggleOtherReason()">
                                    <option value="" selected disabled>Select a reason</option>
                                    <option value="Inactive account">Inactive account</option>
                                    <option value="Policy violation">Policy violation</option>
                                    <option value="Role change">Role change</option>
                                    <option value="Security concerns">Security concerns</option>
                                    <option value="Other">Other (please specify)</option>
                                </select>
                            </div>
                            <div class="mb-3" id="otherReasonContainer" style="display: none;">
                                <label for="otherReasonDetails" class="form-label">Specify Reason*</label>
                                <textarea class="form-control" id="otherReasonDetails" name="other_reason" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="chairmanPassword" class="form-label">Chairman Password*</label>
                                <input type="password" class="form-control" id="chairmanPassword" name="chairman_password" required>
                            </div>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> This action requires Chairman approval and will be logged.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Confirm Deactivation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add New Staff Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addAdminModalLabel"><i class="fas fa-user-plus me-2"></i>Add New Staff Member</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAdminForm" action="add_admin.php" method="POST" class="needs-validation" novalidate>
                    <div class="row g-3">
                        <!-- Basic Information Section -->
                        <div class="col-md-6">
                            <div class="card h-100 border-primary">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-id-card me-2"></i>Basic Information</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Resident ID Field -->
                                    <div class="mb-3">
    <label for="residentID" class="form-label">Resident ID <span class="text-danger">*</span></label>
    <div class="input-group">
        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
        <input type="text" class="form-control <?= isset($_SESSION['validation_errors']['residentID']) ? 'is-invalid' : '' ?>" 
               id="residentID" name="residentID" maxlength="24" required
               value="<?= isset($_SESSION['form_data']['residentID']) ? htmlspecialchars($_SESSION['form_data']['residentID']) : '' ?>">
    </div>
    <div id="residentIDFeedback" class="form-text"></div>
    <?php if (isset($_SESSION['validation_errors']['residentID'])): ?>
        <div class="invalid-feedback d-block">
            <?= $_SESSION['validation_errors']['residentID'] ?>
        </div>
    <?php endif; ?>
</div>

<!-- Username Field -->
<div class="mb-3">
    <label for="email" class="form-label">Username <span class="text-danger">*</span></label>
    <div class="input-group">
        <span class="input-group-text"><i class="fas fa-user"></i></span>
        <input type="text" class="form-control" 
               id="email" name="User_Email" maxlength="24" required
               minlength="8"
               value="<?= isset($_SESSION['form_data']['User_Email']) ? htmlspecialchars($_SESSION['form_data']['User_Email']) : '' ?>">
    </div>
    <div id="usernameFeedback" class="form-text small"></div>
    <?php if (isset($_SESSION['validation_errors']['User_Email'])): ?>
        <div class="invalid-feedback d-block">
            <?= $_SESSION['validation_errors']['User_Email'] ?>
        </div>
    <?php endif; ?>
</div>
                                    
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" id="password" name="Password" maxlength="24" required 
                                                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}"
                                                   oninput="validatePassword()">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <div class="invalid-feedback">
                                                Password must meet all requirements.
                                            </div>
                                        </div>
                                        <div id="passwordHelp" class="form-text mt-2">
                                            <small class="fw-bold">Password Requirements:</small>
                                            <div class="row mt-2">
                                                <div class="col-6">
                                                    <span id="length" class="d-flex align-items-center text-danger">
                                                        <i class="fas fa-circle-notch fa-spin me-2"></i>
                                                        <small>8+ characters</small>
                                                    </span>
                                                    <span id="lowercase" class="d-flex align-items-center text-danger">
                                                        <i class="fas fa-circle-notch fa-spin me-2"></i>
                                                        <small>Lowercase letter</small>
                                                    </span>
                                                </div>
                                                <div class="col-6">
                                                    <span id="uppercase" class="d-flex align-items-center text-danger">
                                                        <i class="fas fa-circle-notch fa-spin me-2"></i>
                                                        <small>Uppercase letter</small>
                                                    </span>
                                                    <span id="number" class="d-flex align-items-center text-danger">
                                                        <i class="fas fa-circle-notch fa-spin me-2"></i>
                                                        <small>Number</small>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <span id="special" class="d-flex align-items-center text-danger">
                                                    <i class="fas fa-circle-notch fa-spin me-2"></i>
                                                    <small>Special character</small>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Role & Status Section -->
                        <div class="col-md-6">
                            <div class="card h-100 border-primary">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-user-tie me-2"></i>Role & Status</h6>
                                </div>
                                <div class="card-body">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Position/Role <span class="text-danger">*</span></label>
                                    <select class="form-select <?= isset($_SESSION['validation_errors']['Role']) ? 'is-invalid' : '' ?>" 
                                            id="role" name="Role" required onchange="updateAccountTypeOptions()">
                                        <option value="" disabled <?= !isset($_SESSION['form_data']['Role']) ? 'selected' : '' ?>>Select a position</option>
                                        <option value="Chairman" <?= isset($_SESSION['form_data']['Role']) && $_SESSION['form_data']['Role'] === 'Chairman' ? 'selected' : '' ?>>Chairman</option>
                                        <option value="Secretary" <?= isset($_SESSION['form_data']['Role']) && $_SESSION['form_data']['Role'] === 'Secretary' ? 'selected' : '' ?>>Secretary</option>
                                        <option value="Treasurer" <?= isset($_SESSION['form_data']['Role']) && $_SESSION['form_data']['Role'] === 'Treasurer' ? 'selected' : '' ?>>Treasurer</option>
                                        <option value="Counselor" <?= isset($_SESSION['form_data']['Role']) && $_SESSION['form_data']['Role'] === 'Counselor' ? 'selected' : '' ?>>Counselor</option>
                                        <option value="Lupon" <?= isset($_SESSION['form_data']['Role']) && $_SESSION['form_data']['Role'] === 'Lupon' ? 'selected' : '' ?>>Lupon</option>
                                        <option value="SK" <?= isset($_SESSION['form_data']['Role']) && $_SESSION['form_data']['Role'] === 'SK' ? 'selected' : '' ?>>SK</option>
                                    </select>
                                    <?php if (isset($_SESSION['validation_errors']['Role'])): ?>
                                        <div class="invalid-feedback d-block">
                                            <?= $_SESSION['validation_errors']['Role'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                    
                                    <div class="mb-3">
                                        <label for="accountType" class="form-label">Account Type <span class="text-danger">*</span></label>
                                        <select class="form-select" id="accountType" name="Type" required>
                                            <option value="" selected disabled>Select role first</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select an account type.
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Account Status <span class="text-danger">*</span></label>
                                        <select class="form-select" id="status" name="Status" required>
                                            <option value="Activated" selected>Activated</option>
                                            <option value="Deactivated">Deactivated</option>
                                        </select>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="staffStartTerm" class="form-label">Term Start <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="staffStartTerm" name="start_term" required>
                                            <div class="invalid-feedback">
                                                Please select a start date.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="staffEndTerm" class="form-label">Term End <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="staffEndTerm" name="end_term" required>
                                            <div class="invalid-feedback">
                                                Please select an end date.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="button" class="btn btn-primary" onclick="validateRoleBeforeSubmit()">
                            <i class="fas fa-save me-2"></i>Save Staff Member
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        <!-- Role Limit Modal -->
        <div class="modal fade" id="roleLimitModal" tabindex="-1" aria-labelledby="roleLimitModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="roleLimitModalLabel">Role Limit Reached</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="roleLimitMessage">
                        <!-- Message will be inserted here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white justify-content-center">
                        <h5 class="modal-title text-center w-100">Action Success</h5>
                        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h4 id="successModalBody">Action completed successfully</h4>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Modal -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white text-center justify-content-center">
                        <h5 class="modal-title w-100 text-center">Action Error</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center" id="errorModalBody">
                        <!-- Error message will be inserted here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('errorModalBody').textContent = '<?php echo $_SESSION['error']; ?>';
            var modal = new bootstrap.Modal(document.getElementById('errorModal'));
            modal.show();
            <?php unset($_SESSION['error']); ?>
        });
    </script>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('successModalBody').textContent = '<?php echo $_SESSION['success']; ?>';
            var modal = new bootstrap.Modal(document.getElementById('successModal'));
            modal.show();
            <?php unset($_SESSION['success']); ?>
        });
    </script>
<?php endif; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Real-time Resident ID validation with debounce
let residentIdTimer;
document.getElementById('residentID').addEventListener('input', function() {
    clearTimeout(residentIdTimer);
    const residentID = this.value.trim();
    const feedbackElement = document.getElementById('residentIDFeedback');
    const inputGroup = this.closest('.input-group');
    
    if (residentID.length === 0) {
        feedbackElement.innerHTML = '';
        inputGroup.classList.remove('is-valid', 'is-invalid');
        return;
    }
    
    // Show loading indicator
    feedbackElement.innerHTML = '<span class="text-muted"><i class="fas fa-circle-notch fa-spin"></i> Checking Resident ID...</span>';
    inputGroup.classList.remove('is-valid', 'is-invalid');
    
    // Debounce to avoid too many requests
    residentIdTimer = setTimeout(() => {
        fetch(`check_resident.php?residentID=${encodeURIComponent(residentID)}`)
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    if (data.hasAccount) {
                        feedbackElement.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle"></i> Already assigned to Account ID: ' + data.accountId + '</span>';
                        inputGroup.classList.add('is-invalid');
                        inputGroup.classList.remove('is-valid');
                    } else {
                        feedbackElement.innerHTML = '<span class="text-success"><i class="fas fa-check-circle"></i> Valid Resident ID</span>';
                        inputGroup.classList.add('is-valid');
                        inputGroup.classList.remove('is-invalid');
                    }
                } else {
                    feedbackElement.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle"></i> Resident ID not found</span>';
                    inputGroup.classList.add('is-invalid');
                    inputGroup.classList.remove('is-valid');
                }
            })
            .catch(error => {
                feedbackElement.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-circle"></i> Error checking Resident ID</span>';
                inputGroup.classList.add('is-invalid');
                inputGroup.classList.remove('is-valid');
            });
    }, 500);
});

// Real-time Username validation with debounce and minimum length
let usernameTimer;
document.getElementById('email').addEventListener('input', function() {
    clearTimeout(usernameTimer);
    const username = this.value.trim();
    const feedbackElement = document.getElementById('usernameFeedback');
    const inputGroup = this.closest('.input-group');
    
    // First check minimum length
    if (username.length === 0) {
        feedbackElement.innerHTML = '';
        inputGroup.classList.remove('is-valid', 'is-invalid');
        return;
    }
    
    if (username.length < 8) {
        feedbackElement.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle"></i> Username must be at least 8 characters</span>';
        inputGroup.classList.add('is-invalid');
        inputGroup.classList.remove('is-valid');
        return;
    }
    
    // Show loading indicator
    feedbackElement.innerHTML = '<span class="text-muted"><i class="fas fa-circle-notch fa-spin"></i> Checking username availability...</span>';
    inputGroup.classList.remove('is-valid', 'is-invalid');
    
    // Debounce to avoid too many requests
    usernameTimer = setTimeout(() => {
        fetch(`check_username.php?username=${encodeURIComponent(username)}`)
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    feedbackElement.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle"></i> Username already taken</span>';
                    inputGroup.classList.add('is-invalid');
                    inputGroup.classList.remove('is-valid');
                } else {
                    feedbackElement.innerHTML = '<span class="text-success"><i class="fas fa-check-circle"></i> Username available</span>';
                    inputGroup.classList.add('is-valid');
                    inputGroup.classList.remove('is-invalid');
                }
            })
            .catch(error => {
                feedbackElement.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-circle"></i> Error checking username</span>';
                inputGroup.classList.add('is-invalid');
                inputGroup.classList.remove('is-valid');
            });
    }, 500);
});

// Fixed password toggle functionality
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

        document.addEventListener('DOMContentLoaded', function() {
    // Check if we should show the modal
    const urlParams = new URLSearchParams(window.location.search);
    const showModal = urlParams.get('showModal');
    
    if (showModal === 'addAdmin') {
        const modal = new bootstrap.Modal(document.getElementById('addAdminModal'));
        modal.show();
        
        // Clean the URL but keep the tab parameter
        const cleanUrl = window.location.pathname + '?tab=staff';
        history.replaceState(null, '', cleanUrl);
    }
    
    // Clear form data when modal is hidden
    document.getElementById('addAdminModal').addEventListener('hidden.bs.modal', function() {
        fetch('clear_form_session.php')
            .then(response => response.json())
            .then(data => console.log('Session cleared'))
            .catch(error => console.error('Error:', error));
    });
    
    // Password toggle functionality
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});

        // Password toggle functionality
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

// Update password validation to handle new spinner icons
function validatePassword() {
    const password = document.getElementById('password').value;
    const requirements = {
        length: password.length >= 8,
        lowercase: /[a-z]/.test(password),
        uppercase: /[A-Z]/.test(password),
        number: /\d/.test(password),
        special: /[\W_]/.test(password)
    };

    Object.keys(requirements).forEach(key => {
        const element = document.getElementById(key);
        const icon = element.querySelector('i');
        
        if (requirements[key]) {
            element.classList.remove('text-danger');
            element.classList.add('text-success');
            icon.classList.remove('fa-circle-notch', 'fa-spin');
            icon.classList.add('fa-check');
        } else {
            element.classList.remove('text-success');
            element.classList.add('text-danger');
            icon.classList.remove('fa-check');
            icon.classList.add('fa-circle-notch', 'fa-spin');
        }
    });
}

// Bootstrap form validation
(function () {
    'use strict'
    
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
    
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                
                form.classList.add('was-validated')
            }, false)
        })
})()

    // Search Functionality for all tabs
    function setupSearch(searchInputId, searchButtonId, tablePaneId, excludeLastColumns = 1) {
        const searchInput = document.getElementById(searchInputId);
        const searchButton = document.getElementById(searchButtonId);
        
        const performSearch = () => {
            const searchTerm = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll(`#${tablePaneId} .admins-table tbody tr`);
            
            rows.forEach(row => {
                let found = false;
                // Check all cells except the last specified columns
                const columnsToCheck = row.cells.length - excludeLastColumns;
                for (let i = 0; i < columnsToCheck; i++) {
                    if (row.cells[i].textContent.toLowerCase().includes(searchTerm)) {
                        found = true;
                        break;
                    }
                }
                row.style.display = found ? '' : 'none';
            });
        };
        
        searchButton.addEventListener('click', performSearch);
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }

    // Initialize all search functionalities
    document.addEventListener('DOMContentLoaded', function() {
        // Admin Accounts tab - search all columns except Actions (1 column)
        setupSearch('adminSearch', 'searchButton', 'admin-tab-pane', 1);
        
        // Resident Accounts tab - search all columns except Actions (1 column)
        setupSearch('residentSearch', 'residentSearchButton', 'resident-tab-pane', 1);
        
        // Staff Information tab - search all columns except Actions and Account ID (2 columns)
        setupSearch('staffSearch', 'staffSearchButton', 'staff-tab-pane', 2);
        
        // Activity Log tab - search all columns (0 columns to exclude)
        setupSearch('activityLogSearch', 'activityLogSearchButton', 'activity-log-tab-pane', 0);

        // Check for success/error messages
        const urlParams = new URLSearchParams(window.location.search);
        const success = urlParams.get('success');
        const error = urlParams.get('error');
        const tab = urlParams.get('tab');

        if (tab === 'resident') {
            switchToResidentTab();
        }

        const errorMessages = {
            'missing_fields': 'All required fields must be filled',
            'no_chairman': 'No active Chairman account found',
            'invalid_password': 'Invalid Chairman password',
            'activation_failed': 'Failed to activate account',
            'deactivation_failed': 'Failed to deactivate account'
        };

        if (success === 'activated') {
            document.getElementById('successModalBody').textContent = 'Account activated successfully!';
            new bootstrap.Modal(document.getElementById('successModal')).show();
            cleanUrl();
        } else if (success === 'deactivated') {
            document.getElementById('successModalBody').textContent = 'Account deactivated successfully!';
            new bootstrap.Modal(document.getElementById('successModal')).show();
            cleanUrl();
        } else if (error && errorMessages[error]) {
            document.getElementById('errorModalBody').textContent = errorMessages[error];
            new bootstrap.Modal(document.getElementById('errorModal')).show();
            cleanUrl();
        }

        <?php if (isset($_SESSION['role_limit_error'])): ?>
            document.getElementById('roleLimitMessage').textContent = '<?php echo $_SESSION['role_limit_error']; ?>';
            new bootstrap.Modal(document.getElementById('roleLimitModal')).show();
            <?php unset($_SESSION['role_limit_error']); ?>
        <?php endif; ?>
    });

    function switchToResidentTab() {
        const residentTab = document.getElementById('resident-tab');
        const residentTabPane = document.getElementById('resident-tab-pane');
        
        document.getElementById('admin-tab').classList.remove('active');
        document.getElementById('admin-tab-pane').classList.remove('show', 'active');
        
        residentTab.classList.add('active');
        residentTabPane.classList.add('show', 'active');
    }

    function cleanUrl() {
        const cleanUrl = window.location.pathname;
        history.replaceState(null, '', cleanUrl);
    }

    // Delete Staff Modal Handler
    document.getElementById('deleteStaffModal').addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        document.getElementById('deleteStaffId').value = button.getAttribute('data-staff-id');
        document.getElementById('chairmanPasswordDelete').value = '';
    });

    document.getElementById('deleteStaffForm').addEventListener('submit', function(e) {
        const password = document.getElementById('chairmanPasswordDelete').value;
        if (!password) {
            e.preventDefault();
            alert('Please enter the chairman password');
        }
    });

    // Edit Staff Modal Handler
    document.getElementById('editStaffModal').addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        document.getElementById('editStaffId').value = button.getAttribute('data-staff-id');
        document.getElementById('editStaffName').value = button.getAttribute('data-name');
        document.getElementById('editStaffRole').value = button.getAttribute('data-role');
        document.getElementById('editStaffStartTerm').value = button.getAttribute('data-start-term');
    });

    // Role limits configuration
    const ROLE_LIMITS = {
        'Chairman': 1,
        'Secretary': 1,
        'Treasurer': 1,
        'Counselor': 12,
        'Lupon': 2,
        'SK': 1
    };

    // Set up activate modal
    document.getElementById('activateModal').addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const accountId = button.getAttribute('data-account-id');
        const currentTab = button.getAttribute('data-current-tab');
        
        document.getElementById('activateAccountId').value = accountId;
        document.getElementById('activateCurrentTab').value = currentTab;
    });

    // Set up deactivate modal
    document.getElementById('deactivateModal').addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const accountId = button.getAttribute('data-account-id');
        
        document.getElementById('deactivateAccountId').value = accountId;
        document.getElementById('deactivateCurrentTab').value = 
            button.closest('.tab-pane').id === 'admin-tab-pane' ? 'admin' : 'resident';
    });

    // Toggle other reason field
    function toggleOtherReason() {
        const reasonSelect = document.getElementById('deactivateReason');
        const otherReasonContainer = document.getElementById('otherReasonContainer');
        
        if (reasonSelect.value === 'Other') {
            otherReasonContainer.style.display = 'block';
        } else {
            otherReasonContainer.style.display = 'none';
        }
    }

    // Update account type options based on role
    function updateAccountTypeOptions() {
        const roleSelect = document.getElementById('role');
        const accountTypeSelect = document.getElementById('accountType');
        const selectedRole = roleSelect.value;
        
        accountTypeSelect.innerHTML = '';
        
        if (selectedRole === 'Chairman' || selectedRole === 'Secretary') {
            addOption(accountTypeSelect, 'Super Admin', 'Super Admin');
            addOption(accountTypeSelect, 'Admin', 'Admin');
            addOption(accountTypeSelect, 'Editor', 'Editor');
        } else if (selectedRole === 'Treasurer' || selectedRole === 'Counselor' || selectedRole === 'Lupon') {
            addOption(accountTypeSelect, 'Admin', 'Admin');
            addOption(accountTypeSelect, 'Editor', 'Editor');
        } else if (selectedRole === 'SK') {
            addOption(accountTypeSelect, 'Editor', 'Editor');
        } else {
            addOption(accountTypeSelect, '', 'Select Role first');
        }
    }

    function addOption(selectElement, value, text) {
        const option = document.createElement('option');
        option.value = value;
        option.textContent = text;
        selectElement.appendChild(option);
    }

    // Password validation
    function validatePassword() {
        const password = document.getElementById('password').value;
        const requirements = {
            length: password.length >= 8,
            lowercase: /[a-z]/.test(password),
            uppercase: /[A-Z]/.test(password),
            number: /\d/.test(password),
            special: /[\W_]/.test(password)
        };

        Object.keys(requirements).forEach(key => {
            const element = document.getElementById(key);
            if (requirements[key]) {
                element.classList.remove('text-danger');
                element.classList.add('text-success');
                element.innerHTML = '<i class="fas fa-check"></i> ' + element.textContent.replace(/^[^a-zA-Z]+/, '');
            } else {
                element.classList.remove('text-success');
                element.classList.add('text-danger');
                element.innerHTML = '<i class="fas fa-times"></i> ' + element.textContent.replace(/^[^a-zA-Z]+/, '');
            }
        });
    }

    // Validate role before submitting
    function validateRoleBeforeSubmit() {
    const form = document.getElementById('addAdminForm');
    
    // First check Bootstrap validation
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    // Then check password requirements
    const password = document.getElementById('password').value;
    const passwordValid = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$/.test(password);
    
    if (!passwordValid) {
        alert('Please ensure your password meets all requirements');
        return;
    }

    const selectedRole = document.getElementById('role').value;
    
    if (!selectedRole) {
        alert('Please select a role');
        return;
    }

    // Add this to your validateRoleBeforeSubmit function
    const startTerm = document.getElementById('staffStartTerm').value;
    const endTerm = document.getElementById('staffEndTerm').value;

    if (!startTerm || !endTerm) {
        // Highlight the empty fields
        document.getElementById('staffStartTerm').classList.add('is-invalid');
        document.getElementById('staffEndTerm').classList.add('is-invalid');
        return;
    }

    if (new Date(endTerm) <= new Date(startTerm)) {
        alert('End date must be after start date');
        document.getElementById('staffEndTerm').classList.add('is-invalid');
        return;
    }

    // If all validations pass, proceed with role limit check
    fetch('get_role_counts.php')
        .then(response => response.json())
        .then(data => {
            const currentCount = data[selectedRole] || 0;
            const roleLimit = ROLE_LIMITS[selectedRole];
            
            if (currentCount >= roleLimit) {
                const roleLimitModal = new bootstrap.Modal(document.getElementById('roleLimitModal'));
                const message = `The ${selectedRole} role already has the maximum allowed number of accounts (${roleLimit}).`;
                document.getElementById('roleLimitMessage').textContent = message;
                roleLimitModal.show();
            } else {
                form.submit();
            }
        })
        .catch(error => {
            console.error('Error fetching role counts:', error);
            alert('Error validating role limits. Please try again.');
        });
}

document.getElementById('addAdminForm').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        validateRoleBeforeSubmit();
    }
});

    // Initialize account type options when add admin modal is shown
    document.getElementById('addAdminModal').addEventListener('show.bs.modal', function() {
        updateAccountTypeOptions();
    });
</script>
</body>
</html>