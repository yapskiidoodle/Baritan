<?php
require ('../src/connect.php');
require ('../src/account.php');



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
        .register-button {
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

        .register-button:hover {
            background-color: #2a4d6e;
        }

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
    transition: background-color 0.2s;
}

#residentsTableBody tr:hover {
    background-color: #f1f1f1;
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
                <button class="btn dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                    <!--<li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a></li>
                    <li><hr class="dropdown-divider"></li> -->
                    <li><form action="../src/logout.php"><a class="dropdown-item" href="index.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li></form>
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
    </div>

    <!-- Main Content -->
       
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
        <!-- Register Resident Button -->
        <div class="search-filter">
            <!-- Register Resident Button -->
            <button class="register-button" onclick="window.open('register.php', '_blank')">
                <i class="fas fa-user-plus"></i> Register Resident
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
                    <td>{$row['Address']}</td> <!-- Address is included here -->
                    <td>{$row['Resident_Email']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No residents found</td></tr>";
    }
            
        ?>
   
                </tbody>
            </table>
        </div>
    </div>
    <?php
   
    echo "<h1>Session started for user: KUMAG " . $_SESSION['userEmail'] . "</h1>";
    ?>

    <script>
       document.addEventListener("DOMContentLoaded", function () {
    const tableRows = document.querySelectorAll("#residentsTableBody tr");

    tableRows.forEach((row) => {
        row.addEventListener("click", function () {
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
        });
    });
});
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