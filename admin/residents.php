<?php
require ('../src/connect.php');
require ('../src/account.php');

$_SESSION['Account_Role'];


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
            margin-top: 5%; /* Reduced from 80px to 40px */
        }

        /* Search bar and filter styling */
        .search-filter {
            display: flex;
            justify-content: space-between; /* Align items to the start and end */
            align-items: center;
            margin-bottom: 20px;
        }
        .search-bar-container {
            display: flex;
            align-items: center;
            gap: 10px; /* Add spacing between the search bar and button */
            flex-grow: 1; /* Allow the search bar to take up remaining space */
            justify-content: flex-end; /* Align the search bar to the right */
        }

        .search-button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            background-color: #1C3A5B;
            color: white;
            cursor: pointer;
        }


        .search-bar {
            width: 250px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-button,
        .generate-button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            background-color: #1C3A5B;
            color: white;
            cursor: pointer;
        }
        .search-button:hover {
            background-color: #2a4d6e;
        }

        .generate-button:hover {
            background-color: #2a4d6e;
        }

        .generate-button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            background-color: #1C3A5B;
            color: white;
            cursor: pointer;
        }

        .search-button:hover,
        .generate-button:hover {
            background-color: #2a4d6e;
        }

        /* Table styling */
        .table-container {
            max-height: 500px; /* Adjust height as needed */
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 20px;
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
            text-align: center;
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
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    padding: 0; /* Remove padding to ensure header sticks to the top */
    margin: 0; /* Remove margin */
}
.modal-dialog.modal-sm {
    max-width: 800px;
}
.modal-header .modal-title {
    width: 100%; /* Ensure the title takes full width */
}


.modal-header {
    background-color: #1C3A5B; /* Dark blue */
    color: white;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    padding: 15px 20px;
    
}

.modal-title {
    font-size: 1.25rem;
    font-weight: bold;
}
.modal-body {
    padding: 20px;
}
.modal-body .form-label {
    font-weight: bold;
    color: #1C3A5B; /* Dark blue */
    margin-bottom: 5px;
}
.modal-body .form-control-static {
    padding: 0;
    margin: 0;
    font-size: 14px;
    color: #333;
}

.modal-body p {
    margin: 5px;
    padding: 0;
    font-size: 13px;
    color: #333;
}
.modal-body .row .col-md-6 .mb-2 {
    margin-bottom: 6px !important;
}
/* Make table rows clickable */
#residentsTableBody tr {
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.2s;
}

#residentsTableBody tr:hover {
    background-color: #f1f1f1;
}
.edit-icon:hover {
    color: #2a4d6e; /* Darker blue on hover */
}
.delete-icon:hover {
    color: #c82333; /* Darker red on hover */
}

/* Add this to your existing CSS */
#deleteConfirmationModal .modal-header {
    background-color: #1C3A5B;
    color: white;
}

#deleteConfirmationModal .modal-footer .btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

#deleteConfirmationModal .modal-footer .btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}
.view-icon:hover {
    color: #2a4d6e; /* Darker blue on hover */
}
#resultModal .modal-header {
    background-color: #1C3A5B;
    color: white;
    text-align: center;
}

#resultModal .modal-body {
    font-size: 16px;
    padding: 20px;
    text-align: center;
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
        <a href="residents.php" class="active"><i class="fas fa-users"></i>Residents</a>
        <a href="announcement.php"><i class="fas fa-bullhorn"></i>Announcement</a>
        <a href="document.php"><i class="fas fa-file-alt"></i>Documents</a>
        <a href="approved_document.php"><i class="fas fa-file-signature"></i>Approved Documents</a>
        <a href="blotter_report.php"><i class="fas fa-clipboard-list"></i>Blotter Report</a>
        <a href="complaint_report.php"><i class="fas fa-exclamation-circle"></i>Complaint Report</a>
        <a href="reservation.php"><i class="fas fa-calendar-alt"></i>Reservations</a>
        <a href="tracking_records.php"><i class="fas fa-calendar-alt"></i>Tracking Records</a>
        <a href="admin_management.php"><i class="fas fa-tools"></i>Admin Management</a>
    </div>

    <!-- Main Content -->

    <!-- Success/Failure Modal -->
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

    <!-- Generate List Modal -->
<div class="modal fade" id="generateListModal" tabindex="-1" aria-labelledby="generateListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" style="background-color: #1C3A5B; color: white;">
                <h5 class="modal-title" id="generateListModalLabel">Generate Resident List</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="generateListForm" action="../src/generate_list.php" method="POST" target="_blank">
                    <div class="mb-3">
                        <label class="form-label"><strong>Select Resident Type:</strong></label>
                        <select class="form-select" id="residentType" name="resident_type" required>
                            <option value="" selected disabled>Select a type</option>
                            <option value="Senior Citizen">Senior Citizen</option>
                            <option value="Head of the Family">Head of the Family</option>
                            <option value="pwd">PWD (Person with Disability)</option>
                            <option value="Single Parent">Single Parent</option>
                            <option value="Male Age Range">Male Age Range</option>
                            <option value="Female Age Range">Female Age Range</option>
                        </select>
                    </div>

                    <!-- Age Range for Male -->
                    <div class="mb-3" id="maleAgeRangeContainer" style="display: none;">
                        <label class="form-label"><strong>Male Age Range:</strong></label>
                        <div class="row">
                            <div class="col">
                                <input type="number" class="form-control" id="maleMinAge" name="male_min_age" placeholder="Min Age">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" id="maleMaxAge" name="male_max_age" placeholder="Max Age">
                            </div>
                        </div>
                    </div>

                    <!-- Age Range for Female -->
                    <div class="mb-3" id="femaleAgeRangeContainer" style="display: none;">
                        <label class="form-label"><strong>Female Age Range:</strong></label>
                        <div class="row">
                            <div class="col">
                                <input type="number" class="form-control" id="femaleMinAge" name="female_min_age" placeholder="Min Age">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" id="femaleMaxAge" name="female_max_age" placeholder="Max Age">
                            </div>
                        </div>
                    </div>

                    <!-- Purpose/Reason Field -->
                    <div class="mb-3">
                        <label class="form-label"><strong>Purpose/Reason for Generating List:</strong></label>
                        <textarea class="form-control" id="purpose" name="purpose" rows="3" placeholder="Enter the purpose or reason for generating this list..." required></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Generate List</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Edit Resident Modal -->
<div class="modal fade" id="editResidentModal" tabindex="-1" aria-labelledby="editResidentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" style="background-color: #1C3A5B; color: white;">
                <h5 class="modal-title text-center" id="editResidentModalLabel">Edit Resident Information</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" onclick="redirectToResidents()" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="editResidentForm" action="update_resident.php" method="POST">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <input type="hidden" class="form-control" id="editResidentAge" name="age" readonly>
                            <input type="hidden" class="form-control" id="editResidentId" name="resident_id" readonly>
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
                            <div class="mb-3">
                                <label class="form-label"><strong>Civil Status:</strong></label>
                                <select class="form-select" id="editResidentCivilStatus" name="civil_status">
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><strong>Role:</strong></label>
                                <!-- <input type="text" class="form-control" id="editResidentRole" name="role"> -->
                                <select class="form-control" id="editResidentRole" name="role">
                                    <option value="Head">Head of the Family</option>
                                    <option value="Father">Father</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Daughter">Daughter</option>
                                    <option value="Son">Son</option>
                                    <option value="Grandfather">Grandfather</option>
                                    <option value="Grandmother">Grandmother</option>
                                    <option value="Uncle">Uncle</option>
                                    <option value="Aunt">Aunt</option>
                                    <option value="Cousin">Cousin</option>
                                    <option value="Guardian">Guardian</option>
                                    <option value="Tenant">Tenant</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Address:</strong></label>
                                <input type="text" class="form-control" id="editResidentAddress" name="address">
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
                            
                        </div>
                    </div>

                    <!-- Emergency Contact Section -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="mb-3 text-center" style="color: #1C3A5B; font-weight: bold;"><strong>Emergency Contact Information</strong></h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Contact Person:</strong></label>
                                        <input type="text" class="form-control" id="editResidentEmergencyPerson" name="emergency_person">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Contact Number:</strong></label>
                                        <input type="text" class="form-control" id="editResidentEmergencyContact" name="emergency_contact">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Relationship:</strong></label>
                                        <input type="text" class="form-control" id="editResidentRelationship" name="relationship">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="submit" name="saveChanges" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1C3A5B; color: white;">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Remove</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p style="font-size: 17px; text-align: center;">Are you sure you want to Remove this resident's data?</p>
                <p style="font-size: 17px; text-align: center;">This action cannot be undone.</p>
                <div class="mb-3">
                    <label for="deleteReason" class="form-label"><strong>Reason for Removing:</strong></label>
                    <select class="form-select" id="deleteReasonDropdown" name="delete_reason" required>
                        <option value="" selected disabled>Select a reason</option>
                        <option value="No longer residing in the barangay">No longer residing in the barangay</option>
                        <option value="Deceased">Deceased</option>
                        <option value="Duplicate record">Duplicate record</option>
                        <option value="Incorrect or fake entry">Incorrect or fake entry</option>
                        <option value="Resident requested deletion">Resident requested deletion</option>
                        <option value="Long-term absence">Long-term absence</option>
                        <option value="Legal or administrative reasons">Legal or administrative reasons</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="mb-3" id="otherReasonContainer" style="display: none;">
                    <label for="otherReason" class="form-label"><strong>Specify Reason:</strong></label>
                    <textarea class="form-control" id="otherReason" name="other_reason" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="../src/delete.php" method="POST">
                    <input type="hidden" id="deleteResidentId" name="resident_id">
                    <input type="hidden" id="finalDeleteReason" name="delete_reason">
                    <button type="submit" name="delete_resident" class="btn btn-danger">Remove</button>
                </form>
            </div>
        </div>
    </div>
</div>
       
<!-- Resident Information Modal -->
<div class="modal fade" id="residentInfoModal" tabindex="-1" aria-labelledby="residentInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" style="background-color: #1C3A5B; color: white;">
                <h5 class="modal-title text-center" id="residentInfoModalLabel">Resident Information</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>Resident ID:</strong></label>
                            <p id="residentId" class="form-control-static">N/A</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>First Name:</strong></label>
                            <p id="residentFirstName" class="form-control-static">N/A</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Middle Name:</strong></label>
                            <p id="residentMiddleName" class="form-control-static">N/A</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Last Name:</strong></label>
                            <p id="residentLastName" class="form-control-static">N/A</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Age:</strong></label>
                            <p id="residentAge" class="form-control-static">N/A</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Sex:</strong></label>
                            <p id="residentSex" class="form-control-static">N/A</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Date of Birth:</strong></label>
                            <p id="residentDob" class="form-control-static">N/A</p>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>Role:</strong></label>
                            <p id="residentRole" class="form-control-static">N/A</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Address:</strong></label>
                            <p id="residentAddress" class="form-control-static">N/A</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Contact Number:</strong></label>
                            <p id="residentContact" class="form-control-static">N/A</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Email:</strong></label>
                            <p id="residentEmail" class="form-control-static">N/A</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Religion:</strong></label>
                            <p id="residentReligion" class="form-control-static">N/A</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Eligibility Status:</strong></label>
                            <p id="residentEligibility" class="form-control-static">N/A</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Civil Status:</strong></label>
                            <p id="residentCivilStatus" class="form-control-static">N/A</p>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact Section -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h6 class="mb-3 text-center" style="color: #1C3A5B; font-weight: bold;"><strong>Emergency Contact Information</strong></h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Emergency Contact Person:</strong></label>
                                    <p id="residentEmergencyPerson" class="form-control-static">N/A</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Emergency Contact Number:</strong></label>
                                    <p id="residentEmergencyContact" class="form-control-static">N/A</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Relationship to Person:</strong></label>
                                    <p id="residentRelationship" class="form-control-static">N/A</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="main-content">
        <!-- Generate Resident Button -->
        <div class="search-filter">
            <!-- generate Resident Button -->
            <button class="generate-button" data-bs-toggle="modal" data-bs-target="#generateListModal">
                <i class="fas fa-file-export me-1"></i> Generate a List
            </button>

            <!-- Search Bar -->
            <div class="search-bar-container">
                <input type="text" class="search-bar" id="searchBar" placeholder="Search residents...">
                <button class="search-button" id="searchButton"><i class="fas fa-search"></i></button>
            </div>
        </div>

        <!-- Scrollable Table Container -->
        <div class="table-container">
            <table class="residents-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Contact Number</th>
                        <th>Sex</th>
                        <th>Civil Status</th>
                        <th>Role</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="residentsTableBody">
    <?php
    $sql = "SELECT 
                Resident_ID,
                Address,
                FirstName,
                MiddleName,
                LastName,
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
                TIMESTAMPDIFF(YEAR, Date_of_Birth, CURDATE()) AS Age
            FROM Residents_information_tbl";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr data-resident-id='{$row['Resident_ID']}'
                      data-last-name='{$row['LastName']}'
                      data-first-name='{$row['FirstName']}'
                      data-middle-name='{$row['MiddleName']}'
                      data-dob='{$row['Date_of_Birth']}'
                      data-religion='{$row['Religion']}'
                      data-eligibility='{$row['Eligibility_Status']}'
                      data-emergency-person='{$row['Emergency_Person']}'
                      data-emergency-contact='{$row['Emergency_Contact_No']}'
                      data-relationship='{$row['Relationship_to_Person']}'>
                    <td>{$row['LastName']} {$row['FirstName']} </td>
                    <td>{$row['Age']}</td>
                    <td>{$row['Contact_Number']}</td>
                    <td>{$row['Sex']}</td>
                    <td>{$row['Civil_Status']}</td>
                    <td>{$row['Role']}</td>
                    <td>{$row['Address']}</td>
                    <td>{$row['Resident_Email']}</td>
                    <td>
                        <i class='fas fa-eye view-icon' style='cursor: pointer; margin-right: 10px; color: #1C3A5B;' title='View'></i>
                        <i class='fas fa-edit edit-icon' style='cursor: pointer; margin-right: 10px; color: #1C3A5B;' title='Edit' data-bs-toggle='modal' data-bs-target='#editResidentModal'></i>
                        <i class='fas fa-trash delete-icon' style='cursor: pointer; color: #dc3545;' title='Delete'></i>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='9'>No residents found</td></tr>";
    }
    ?>
</tbody>
            </table>
        </div>
    </div>


    <script>

document.addEventListener("DOMContentLoaded", function () {
    // Get the message from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');

    if (message) {
        // Set the modal body content
        document.getElementById("resultModalBody").textContent = message;

        // Show the modal
        const resultModal = new bootstrap.Modal(document.getElementById("resultModal"));
        resultModal.show();

        // Clear the message parameter from the URL
        const newUrl = window.location.pathname; // Get the URL without query parameters
        history.replaceState({}, document.title, newUrl); // Update the URL
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const generateListForm = document.getElementById("generateListForm");

    generateListForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Show a loading indicator (optional)
        const generateButton = generateListForm.querySelector("button[type='submit']");
        generateButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
        generateButton.disabled = true;

        // Submit the form data to generate_list.php
        const formData = new FormData(generateListForm);
        fetch("generate_list.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.blob()) // Get the PDF as a Blob
        .then(blob => {
            // Create a URL for the Blob
            const url = window.URL.createObjectURL(blob);

            // Open the PDF in a new tab
            window.open(url, "_blank");

            // Revoke the Blob URL after opening
            window.URL.revokeObjectURL(url);
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while generating the list.");
        })
        .finally(() => {
            // Reset the button text and enable it
            generateButton.innerHTML = '<i class="fas fa-user-plus"></i> Generate List';
            generateButton.disabled = false;

            // Close the modal
            const generateListModal = bootstrap.Modal.getInstance(document.getElementById("generateListModal"));
            generateListModal.hide();
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const residentTypeDropdown = document.getElementById("residentType");
    const maleAgeRangeContainer = document.getElementById("maleAgeRangeContainer");
    const femaleAgeRangeContainer = document.getElementById("femaleAgeRangeContainer");

    residentTypeDropdown.addEventListener("change", function () {
        const selectedValue = this.value;

        // Show/hide age range fields based on selection
        if (selectedValue === "Male Age Range") {
            maleAgeRangeContainer.style.display = "block";
            femaleAgeRangeContainer.style.display = "none";
        } else if (selectedValue === "Female Age Range") {
            femaleAgeRangeContainer.style.display = "block";
            maleAgeRangeContainer.style.display = "none";
        } else {
            maleAgeRangeContainer.style.display = "none";
            femaleAgeRangeContainer.style.display = "none";
        }
    });
});

function redirectToResidents() {
    // Close the modal (if not already closed by data-bs-dismiss)
    const modal = bootstrap.Modal.getInstance(document.getElementById('editResidentModal'));
    modal.hide(); // Ensure the modal is closed

    // Redirect to resident.php after a short delay (optional)
    setTimeout(() => {
        window.location.href = 'residents.php';
    }, 100); // 100ms delay to ensure the modal is fully closed
}

document.addEventListener("DOMContentLoaded", function () {
    const tableRows = document.querySelectorAll("#residentsTableBody tr");

    tableRows.forEach((row) => {
        // Add click event for the edit icon only
        const editIcon = row.querySelector(".edit-icon");
        editIcon.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevent the row click event from firing
            populateAndShowEditModal(row);
        });
    });

    // Function to populate and show the edit modal
    function populateAndShowEditModal(row) {
        const cells = row.querySelectorAll("td");
        const residentData = {
            id: row.getAttribute("data-resident-id"),
            firstName: row.getAttribute("data-first-name"),
            middleName: row.getAttribute("data-middle-name"),
            lastName: row.getAttribute("data-last-name"),
            sex: cells[3].textContent,
            dob: row.getAttribute("data-dob"),
            role: cells[5].textContent,
            contactNumber: cells[2].textContent,
            email: cells[7].textContent,
            religion: row.getAttribute("data-religion"),
            eligibility: row.getAttribute("data-eligibility"),
            civilStatus: cells[4].textContent,
            emergencyPerson: row.getAttribute("data-emergency-person"),
            emergencyContact: row.getAttribute("data-emergency-contact"),
            relationship: row.getAttribute("data-relationship"),
            age: cells[1].textContent,
            address: cells[6].textContent,
        };

        // Populate the edit modal
        document.getElementById("editResidentId").value = residentData.id;
        document.getElementById("editResidentFirstName").value = residentData.firstName;
        document.getElementById("editResidentMiddleName").value = residentData.middleName || "";
        document.getElementById("editResidentLastName").value = residentData.lastName;
        document.getElementById("editResidentSex").value = residentData.sex;
        document.getElementById("editResidentDob").value = residentData.dob;
        document.getElementById("editResidentRole").value = residentData.role;
        document.getElementById("editResidentContact").value = residentData.contactNumber;
        document.getElementById("editResidentEmail").value = residentData.email;
        document.getElementById("editResidentReligion").value = residentData.religion;
        document.getElementById("editResidentEligibility").value = residentData.eligibility;
        document.getElementById("editResidentCivilStatus").value = residentData.civilStatus;
        document.getElementById("editResidentEmergencyPerson").value = residentData.emergencyPerson;
        document.getElementById("editResidentEmergencyContact").value = residentData.emergencyContact;
        document.getElementById("editResidentRelationship").value = residentData.relationship;
        document.getElementById("editResidentAge").value = residentData.age;
        document.getElementById("editResidentAddress").value = residentData.address;

        // Show the edit modal
        const editResidentModal = new bootstrap.Modal(document.getElementById("editResidentModal"));
        editResidentModal.show();
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const tableRows = document.querySelectorAll("#residentsTableBody tr");

    tableRows.forEach((row) => {
        // Add click event for the view icon only
        const viewIcon = row.querySelector(".view-icon");
        viewIcon.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevent the row click event from firing
            populateAndShowModal(row);
        });
    });

    // Function to populate and show the modal
    function populateAndShowModal(row) {
        const cells = row.querySelectorAll("td");
        const residentData = {
            id: row.getAttribute("data-resident-id"),
            firstName: row.getAttribute("data-first-name"),
            middleName: row.getAttribute("data-middle-name"),
            lastName: row.getAttribute("data-last-name"),
            sex: cells[3].textContent,
            dob: row.getAttribute("data-dob"),
            role: cells[5].textContent,
            contactNumber: cells[2].textContent,
            email: cells[7].textContent,
            religion: row.getAttribute("data-religion"),
            eligibility: row.getAttribute("data-eligibility"),
            civilStatus: cells[4].textContent,
            emergencyPerson: row.getAttribute("data-emergency-person"),
            emergencyContact: row.getAttribute("data-emergency-contact"),
            relationship: row.getAttribute("data-relationship"),
            age: cells[1].textContent,
            address: cells[6].textContent,
        };

        // Populate the modal
        document.getElementById("residentId").textContent = residentData.id;
        document.getElementById("residentFirstName").textContent = residentData.firstName;
        document.getElementById("residentMiddleName").textContent = residentData.middleName || "N/A";
        document.getElementById("residentLastName").textContent = residentData.lastName;
        document.getElementById("residentSex").textContent = residentData.sex;
        document.getElementById("residentDob").textContent = residentData.dob;
        document.getElementById("residentRole").textContent = residentData.role;
        document.getElementById("residentContact").textContent = residentData.contactNumber;
        document.getElementById("residentEmail").textContent = residentData.email;
        document.getElementById("residentReligion").textContent = residentData.religion;
        document.getElementById("residentEligibility").textContent = residentData.eligibility;
        document.getElementById("residentCivilStatus").textContent = residentData.civilStatus;
        document.getElementById("residentEmergencyPerson").textContent = residentData.emergencyPerson;
        document.getElementById("residentEmergencyContact").textContent = residentData.emergencyContact;
        document.getElementById("residentRelationship").textContent = residentData.relationship;
        document.getElementById("residentAge").textContent = residentData.age;
        document.getElementById("residentAddress").textContent = residentData.address;

        // Show the modal
        const residentInfoModal = new bootstrap.Modal(document.getElementById("residentInfoModal"));
        residentInfoModal.show();
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const deleteIcons = document.querySelectorAll(".delete-icon");
    deleteIcons.forEach((icon) => {
        icon.addEventListener("click", function () {
            console.log("Delete icon clicked!"); // Debugging
            const row = this.closest("tr");
            const residentId = row.getAttribute("data-resident-id");

            // Set the Resident_ID in the hidden input field
            document.getElementById("deleteResidentId").value = residentId;

            // Show the delete confirmation modal
            const deleteModal = new bootstrap.Modal(document.getElementById("deleteConfirmationModal"));
            deleteModal.show();
        });
    });
});

// Delete Confirmation Modal
document.addEventListener("DOMContentLoaded", function () {
    const deleteReasonDropdown = document.getElementById("deleteReasonDropdown");
    const otherReasonContainer = document.getElementById("otherReasonContainer");
    const otherReasonTextarea = document.getElementById("otherReason");
    const finalDeleteReasonInput = document.getElementById("finalDeleteReason");

    // Handle dropdown change
    deleteReasonDropdown.addEventListener("change", function () {
        if (this.value === "Others") {
            otherReasonContainer.style.display = "block"; // Show the textbox
            otherReasonTextarea.setAttribute("required", "required"); // Make it required
        } else {
            otherReasonContainer.style.display = "none"; // Hide the textbox
            otherReasonTextarea.removeAttribute("required"); // Remove the required attribute
            finalDeleteReasonInput.value = this.value; // Set the selected reason
        }
    });

    // Handle form submission
    const deleteForm = document.querySelector("#deleteConfirmationModal form");
    deleteForm.addEventListener("submit", function (event) {
        if (deleteReasonDropdown.value === "Others") {
            finalDeleteReasonInput.value = otherReasonTextarea.value; // Use the custom reason
        } else {
            finalDeleteReasonInput.value = deleteReasonDropdown.value; // Use the selected reason
        }

        // Validate the reason
        if (!finalDeleteReasonInput.value) {
            event.preventDefault(); // Prevent form submission
            alert("Please provide a reason for deletion.");
        }
    });
});

// Search Functionality
function searchResidents() {
    const searchInput = document.getElementById("searchBar").value.toLowerCase();
    const tableBody = document.getElementById("residentsTableBody");
    const rows = tableBody.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName("td");
        let match = false;

        // Loop through all columns
        for (let j = 0; j < cells.length; j++) {
            const cellText = cells[j].textContent.toLowerCase();

            // Special handling for the "Sex" column (index 3)
            if (j === 3) { // "Sex" column
                if (cellText === searchInput) { // Exact match for "Male" or "Female"
                    match = true;
                    break; // Stop checking other columns if a match is found
                }
            } else {
                // For all other columns, check for partial matches
                if (cellText.includes(searchInput)) {
                    match = true;
                    break; // Stop checking other columns if a match is found
                }
            }
        }

        // Show or hide the row based on whether it matches the search input
        if (match) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    }
}

// Add event listener to the search button
document.getElementById("searchButton").addEventListener("click", searchResidents);

// Add event listener to the search bar for "Enter" key
document.getElementById("searchBar").addEventListener("keyup", function(event) {
    if (event.key === "Enter") {
        searchResidents();
    }
});
    </script>
    

    <!-- Bootstrap JS (required for dropdown functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>