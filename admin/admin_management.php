<?php
require ('../src/connect.php');

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
    <title>Admin Management - Barangay Baritan</title>
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

        /* Main content styling */
        .main-content {
            margin-left: 250px; /* Adjust for sidebar width */
            padding: 20px;
            margin-top: 80px; /* Adjust for header height */
        }

        /* Table styling */
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

        <!-- Logout at the Bottom -->
        <div style="position: absolute; bottom: 0; width: 100%;">
            <a href="#" onclick="document.getElementById('logoutForm').submit();" style="color: white; text-decoration: none; display: block; padding: 15px 20px; font-size: 16px;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logoutForm" action="../src/logout.php" method="POST" style="display: none;">
                <input type="hidden" name="logoutButton" value="1">
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Admin Management</h2>

        <!-- Add New Admin Button -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAdminModal">
            <i class="fas fa-plus"></i> Add New Admin
        </button>

        <!-- Admin Table -->
<div class="table-container">
    <table class="admins-table">
        <thead>
            <tr>
                <th>Account ID</th>
                <th>Email</th>
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
                        <?php endif; ?>

                        <!-- Activate/Deactivate Buttons for Family Accounts -->
                        <?php if ($admin['Type'] === 'Family Account'): ?>
                            <?php if ($admin['Status'] === 'Deactivated'): ?>
                                <button class="btn btn-sm btn-success" onclick="activateAccount(<?php echo $admin['Account_ID']; ?>)">
                                    <i class="fas fa-check"></i> Activate
                                </button>
                            <?php else: ?>
                                <button class="btn btn-sm btn-danger" onclick="deactivateAccount(<?php echo $admin['Account_ID']; ?>)">
                                    <i class="fas fa-times"></i> Deactivate
                                </button>
                            <?php endif; ?>
                        <?php else: ?>
                            <!-- Delete Button for Non-Family Accounts -->
                            <button class="btn btn-sm btn-danger" onclick="deleteAccount(<?php echo $admin['Account_ID']; ?>)">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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
                        <label for="editEmail" class="form-label">Username</label>
                        <input type="email" class="form-control" id="editEmail" name="User_Email" required>
                    </div>
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

    <!-- Delete Admin Modal -->
    <div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAdminModalLabel">Delete Admin</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this admin?</p>
                    <form id="deleteAdminForm" action="delete_admin.php" method="POST">
                        <input type="hidden" id="deleteAdminId" name="id">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>

        // Function to delete an admin account
function deleteAccount(accountId) {
    if (confirm("Are you sure you want to delete this admin account?")) {
        fetch('delete_admin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${accountId}`, // Send the account ID in the request body
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok.");
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert("Admin account deleted successfully!");
                    location.reload(); // Refresh the page
                } else {
                    alert("Failed to delete admin account: " + (data.error || "Unknown error"));
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred while deleting the admin account.");
            });
    }
}

        // Function to populate the edit form
    function populateEditForm(id) {
        fetch(`get_admin.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.Type === 'Family Account') {
                    alert("Editing is restricted for Family Accounts.");
                    return;
                }
                document.getElementById('editAdminId').value = data.Account_ID;
                document.getElementById('editEmail').value = data.User_Email;
                document.getElementById('editRole').value = data.Role;
                document.getElementById('editAccountType').value = data.Type;
                document.getElementById('editStatus').value = data.Status;
            });
    }

    // Function to activate an account
function activateAccount(accountId) {
    if (confirm("Are you sure you want to activate this account?")) {
        fetch(`activate_account.php?id=${accountId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok.");
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert("Account activated successfully!");
                    location.reload(); // Refresh the page
                } else {
                    alert("Failed to activate account: " + (data.error || "Unknown error"));
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred while activating the account.");
            });
    }
}

    // Function to deactivate an account
    function deactivateAccount(accountId) {
        if (confirm("Are you sure you want to deactivate this account?")) {
            fetch(`deactivate_account.php?id=${accountId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Account deactivated successfully!");
                        location.reload(); // Refresh the page
                    } else {
                        alert("Failed to deactivate account.");
                    }
                });
        }
    }

    // Function to populate the edit form
    function populateEditForm(id) {
        fetch(`get_admin.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editAdminId').value = data.Account_ID;
                document.getElementById('editEmail').value = data.User_Email;
                document.getElementById('editRole').value = data.Role;
                document.getElementById('editAccountType').value = data.Type;
                document.getElementById('editStatus').value = data.Status;
            });
    }

    // Function to set the delete ID
    function setDeleteId(id) {
        document.getElementById('deleteAdminId').value = id;
    }
</script>
</body>
</html>