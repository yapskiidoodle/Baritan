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


// Fetch all admin accounts
$sql = "SELECT Account_ID, User_Email, Role, Type, Status FROM account_tbl";
$result = $conn->query($sql);
$admins = $result->fetch_all(MYSQLI_ASSOC);
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
            padding-top: 120px; /* Increased padding to create space below the logo */
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
            background-color: #2a4d6e; /* Highlight color */
            font-weight: bold; /* Optional: Make the text bold */
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
            padding: 0; /* Remove padding to align icon properly */
        }

        .header .profile-dropdown .dropdown-menu {
            right: 0;
            left: auto;
        }

        /* Remove the dropdown icon */
        .header .profile-dropdown .btn::after {
            display: none;
        }

        /* Main content styling */
        .main-content {
            margin-left: 250px; /* Adjust for sidebar width */
            padding: 20px;
            margin-top: 80px; /* Adjust for header height */
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

        .sort-by {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .sort-by select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .table-container {
            max-height: 490px; /* Adjust height as needed */
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

        .residents-table {
            width: 100%;
            border-collapse: collapse;
        }

        .residents-table th,
        .residents-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .residents-table th {
            background-color: #1C3A5B;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .residents-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .residents-table tr:hover {
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
                <!-- Display Account Role next to the profile icon -->
                <?php if (isset($_SESSION['Account_Role'])): ?>
                    <span style="margin-right: 10px; color: white; font-size: 15px; font-weight: Semi-Bold;">
                        <?php echo $_SESSION['Account_Role']; ?>
                    </span>
                <?php endif; ?>
                <button class="btn dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                    <!--<li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a></li>
                    <li><hr class="dropdown-divider"></li> -->
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
        <h2>Admin Management</h2>

        <!-- Add New Admin Button -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAdminModal">
            <i class="fas fa-plus"></i> Add New Admin
        </button>

        <!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to update the account status?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmActionButton">Confirm</button>
            </div>
        </div>
    </div>
</div>

        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center"> <!-- Add text-center class here -->
                        <h5 class="modal-title w-100" id="successModalLabel">Action Success</h5> <!-- Add w-100 class for full width -->
                        
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body text-center" id="successModalBody"> <!-- Add text-center class here -->
                        <!-- Success message will be inserted here -->
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer justify-content-center"> <!-- Add justify-content-center class here -->
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Admin Table -->
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
                    <!-- Conditional Buttons -->
                    <?php if ($admin['Type'] !== 'Family Account'): ?>
                        <!-- Edit Button for Non-Family Accounts -->
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAdminModal" onclick="populateEditForm(<?php echo $admin['Account_ID']; ?>)">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <!-- Delete Button here -->
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" onclick="setDeleteAccountId(<?php echo $admin['Account_ID']; ?>)">
                            <i class="fas fa-trash"></i> Delete
                        </button>

                        <!-- Hidden Form for Delete -->
                        <form id="deleteForm" action="delete_admin.php" method="POST" style="display: none;">
                            <input type="hidden" id="deleteAccountId" name="Account_ID" value="<?php echo $admin['Account_ID']; ?>">
                        </form>
                        
                    <?php else: ?>
                        <!-- Activate/Deactivate Buttons for Family Accounts -->
                        <?php if ($admin['Status'] === 'Deactivated'): ?>
                        <!-- Activate Form -->
                        <form id="activateForm" action="activate_account.php" method="POST" style="display: inline;">
                            <input type="hidden" name="Account_ID" value="<?php echo $admin['Account_ID']; ?>">
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                                <i class="fas fa-check"></i> Activate
                            </button>
                        </form>
                        <?php else: ?>
                            <!-- Deactivate Form -->
                            <form id="activateForm" action="deactivate_account.php" method="POST" style="display: inline;">
                                <input type="hidden" name="Account_ID" value="<?php echo $admin['Account_ID']; ?>">
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                                    <i class="fas fa-check"></i> Deactivate
                                </button>
                            </form>
                            
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
                </tbody>
            </table>
        </div>

<div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel">Action Completed</h5>
                
            </div>
            <!-- Modal Body -->
            <div class="modal-body" id="resultModalBody">
                <!-- Message will be inserted here -->
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <!-- Add New Admin Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAdminModalLabel">Add New Admin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAdminForm" action="add_admin.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Username</label>
                        <input type="text" class="form-control" id="email" name="User_Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control" id="role" name="Role" required>
                    </div>
                    <div class="mb-3">
                        <label for="accountType" class="form-label">Account Type</label>
                        <select class="form-select" id="accountType" name="Type" required>
                            <option value="Super Admin">Super Admin</option>
                            <option value="Admin">Admin</option>
                            <option value="Editor">Editor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="Password" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="Status" required>
                            <option value="Activated">Activated</option>
                            <option value="Deactivated">Deactivated</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Admin</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Edit Admin Modal -->
    <div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAdminModalLabel">Edit Admin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAdminForm" action="edit_admin.php" method="POST">
                    <input type="hidden" id="editAdminId" name="Account_ID">
                    <div class="mb-3">
                        <label for="editRole" class="form-label">Role</label>
                        <input type="text" class="form-control" id="editRole" name="Role" required>
                    </div>
                    <div class="mb-3">
                        <label for="editAccountType" class="form-label">Account Type</label>
                        <select class="form-select" id="editAccountType" name="Type" required>
                            <option value="Super Admin">Super Admin</option>
                            <option value="Admin">Admin</option>
                            <option value="Editor">Editor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-select" id="editStatus" name="Status" required>
                            <option value="Activated">Activated</option>
                            <option value="Deactivated">Deactivated</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this admin account?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>

        // Function to set the Account_ID for deletion
function setDeleteAccountId(accountId) {
    document.getElementById('deleteAccountId').value = accountId;
}

// Handle delete confirmation
document.addEventListener('DOMContentLoaded', function () {
    const confirmDeleteButton = document.getElementById('confirmDeleteButton');
    confirmDeleteButton.addEventListener('click', function () {
        // Submit the delete form
        document.getElementById('deleteForm').submit();
    });
});

        document.addEventListener('DOMContentLoaded', function () {
    // Get references to the form and confirmation button
    const activateForm = document.getElementById('activateForm');
    const confirmActionButton = document.getElementById('confirmActionButton');

    // Add a click event listener to the confirmation button
    confirmActionButton.addEventListener('click', function () {
        // Submit the form when the user confirms
        activateForm.submit();
    });
});

        // Check for success or error query parameters
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const error = urlParams.get('error');

    if (success === '1') {
        // Show success modal
        document.getElementById('successModalBody').innerText = 'Account status updated successfully!';
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    } if (success === '2') {
        document.getElementById('successModalBody').innerText = 'Admin account deleted successfully!';
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    } 
    else if (error === '1') {
        // Show error modal
        document.getElementById('successModalBody').innerText = 'Failed to update account status.';
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    }
});



    
    </script>
</body>
</html>