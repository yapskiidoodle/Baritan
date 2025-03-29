    <?php
    require '../src/connect.php';
    require '../src/account.php';

    if (isset($_SESSION['Account_Role'])) {
        if (($_SESSION['type'] === "Super Admin") || ($_SESSION['type'] === "Admin") || ($_SESSION['type'] === "Editor")) {
            $_SESSION['Account_Role'];
        } else {
            header("Location: ../index.php");
            exit();
        }
    } else {
        header("Location: ../index.php");
        exit();
    }

    $sql = "SELECT * FROM announcement_tbl WHERE delivery_channels = 'Website'";
    $result = $conn->query($sql);
    $announcements = []; // Initialize an empty array
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $announcements[] = $row; // Store each announcement in the array
        }
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Barangay Baritan Official Website</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                margin-left: 250px; /* Adjust based on sidebar width */
                padding: 20px;
                margin-top: 5%; /* Adjust based on header height */
                position: relative; /* Ensure the button is positioned relative to this container */
            }
            .main-content h2 {
                margin-top: 10px; /* Reduced from default */
                margin-bottom: 20px; /* Added to maintain spacing */
                font-size: 1.75rem; /* Slightly smaller font size */
            }

            /* Adjust the form container spacing */
            .main-content form {
                margin-top: 10px; /* Reduced spacing */
            }

            /* Smaller font size for labels */
            .form-label {
                font-size: 0.9rem; /* Reduced from default */
            }

            /* Smaller font size for select dropdown */
            .form-select {
                font-size: 0.9rem; /* Reduced from default */
            }

            /* Announcement Cards */
            .card {
                border: 1px solid #ddd;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                max-height: 460px;
                overflow: hidden;
                
            }

            .card-img-top {
                max-height: 80px;
                object-fit: cover;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
            }

            .card-body {
                padding: 30px;
            }

            .card-title {
                font-size: 1rem;
                font-weight: 600;
                color: #1C3A5B;
            }

            .card-text {
                font-size: .8rem;
                color: #333;
            }

            .text-muted {
                font-size: 0.9rem;
                color: #666;
            }

            /* View Active Announcements Button */
            .view-active-btn {
                position: absolute; /* Position the button absolutely within .main-content */
                top: 15%; /* Align to the top */
                z-index: 2;
                right: 20px; /* Align to the right with some padding */
                background-color: #1C3A5B; /* Match the header color */
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .view-active-btn:hover {
                background-color: #2a4d6e; /* Slightly lighter shade for hover effect */
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
        <a href="announcement.php" class="active"><i class="fas fa-bullhorn"></i>Announcement</a>
        <a href="document.php"><i class="fas fa-file-alt"></i>Documents</a>
        <a href="approved_document.php"><i class="fas fa-file-signature"></i>Approved Documents</a>
        <a href="blotter_report.php"><i class="fas fa-clipboard-list"></i>Blotter Report</a>
        <a href="complaint_report.php"><i class="fas fa-exclamation-circle"></i>Complaint Report</a>
        <a href="reservation.php"><i class="fas fa-calendar-alt"></i>Reservations</a>
        <a href="tracking_records.php"><i class="fas fa-calendar-alt"></i>Tracking Records</a>
        <a href="admin_management.php"><i class="fas fa-tools"></i>Admin Management</a>
    </div>

    <!-- View Active Announcements Button -->
    <button class="btn btn-primary view-active-btn" data-bs-toggle="modal" data-bs-target="#activeAnnouncementsModal">
        <i class="fas fa-bullhorn"></i> View Active Announcements
    </button>

    <!-- All Announcements Modal -->
<div class="modal fade" id="allAnnouncementsModal" tabindex="-1" aria-labelledby="allAnnouncementsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="allAnnouncementsModalLabel">All Announcements</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                // Fetch all announcements (active and inactive)
                $sql_all = "SELECT * FROM announcement_tbl";
                $result_all = $conn->query($sql_all);
                $all_announcements = [];
                if ($result_all->num_rows > 0) {
                    while ($row = $result_all->fetch_assoc()) {
                        $all_announcements[] = $row;
                    }
                }
                ?>

                <?php if (empty($all_announcements)): ?>
                    <!-- Display this if there are no announcements -->
                    <div class="text-center">
                        <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                        <p class="text-muted">There are no announcements.</p>
                    </div>
                <?php else: ?>
                    <!-- Display all announcements -->
                    <div class="row justify-content-center">
                        <?php foreach ($all_announcements as $announcement): ?>
                            <div class="col-md-6 col-lg-5 mb-4">
                                <div class="card h-100">
                                    <?php if (!empty($announcement['image_path'])): ?>
                                        <img src="<?php echo $announcement['image_path']; ?>" class="card-img-top" alt="Announcement Image">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($announcement['category']); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars($announcement['message']); ?></p>
                                        <p class="text-muted">
                                            <small>
                                                <strong>Start Date:</strong> <?php echo date('M d, Y h:i A', strtotime($announcement['start_date'])); ?><br>
                                                <strong>End Date:</strong> <?php echo date('M d, Y h:i A', strtotime($announcement['end_date'])); ?><br>
                                                <strong>Status:</strong> <?php echo (strtotime($announcement['end_date']) >= time()) ? 'Active' : 'Inactive'; ?>
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <!-- Active Announcements Modal -->
<div class="modal fade" id="activeAnnouncementsModal" tabindex="-1" aria-labelledby="activeAnnouncementsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activeAnnouncementsModalLabel">Active Announcements</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (empty($announcements)): ?>
                    <!-- Display this if there are no active announcements -->
                    <div class="text-center">
                        <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                        <p class="text-muted">There are no active announcements.</p>
                    </div>
                <?php else: ?>
                    <!-- Display active announcements -->
                    <div class="row justify-content-center">
                        <?php foreach ($announcements as $announcement): ?>
                            <div class="col-md-6 col-lg-5 mb-4">
                                <div class="card h-100">
                                    <?php if (!empty($announcement['image_path'])): ?>
                                        <img src="<?php echo $announcement['image_path']; ?>" class="card-img-top" alt="Announcement Image">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($announcement['category']); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars($announcement['message']); ?></p>
                                        <p class="text-muted">
                                            <small>
                                                <strong>Start Date:</strong> <?php echo date('M d, Y h:i A', strtotime($announcement['start_date'])); ?><br>
                                                <strong>End Date:</strong> <?php echo date('M d, Y h:i A', strtotime($announcement['end_date'])); ?>
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <!-- Button to view all announcements -->
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#allAnnouncementsModal">
                    <i class="fas fa-list"></i> View All Announcements
                </button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


    


    <div class="main-content">
        <h2 class="mb-2">Create Announcement</h2>
        <form id="announcementForm" action="sample1.php" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
            <!-- Category -->
            <div class="mb-3">
                <label for="category" class="form-label fw-bold">Category</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="" selected disabled>Choose here</option>
                    <option value="Health and Sanitation">Health and Sanitation</option>
                    <option value="Events and Activities">Events and Activities</option>
                    <option value="Government Programs and Services">Government Programs and Services</option>
                    <option value="Environmental Concerns">Environmental Concerns</option>
                    <option value="Infrastructure and Utilities">Infrastructure and Utilities</option>
                    <option value="Public Safety and Security">Public Safety and Security</option>
                    <option value="Social Services">Social Services</option>
                </select>
            </div>

            <!-- Message -->
            <div class="mb-3">
                <label for="message" class="form-label fw-bold">Message</label>
                <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
            </div>

            <!-- Target Audience -->
            <div class="mb-2">
                <label class="form-label fw-bold">Target Audience</label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="all_residents" name="target_audience[]" value="All Residents" onchange="toggleAllResidents()">
                            <label class="form-check-label" for="all_residents">All Residents</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="head_of_family" name="target_audience[]" value="Head of the Family">
                            <label class="form-check-label" for="head_of_family">Head of the Family</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="senior_citizen" name="target_audience[]" value="Senior Citizen">
                            <label class="form-check-label" for="senior_citizen">Senior Citizen</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="pwd" name="target_audience[]" value="PWD">
                            <label class="form-check-label" for="pwd">Person with Disability</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="male_age_range" name="target_audience[]" value="Male (Age Range)" onchange="toggleAgeRange('male')">
                            <label class="form-check-label" for="male_age_range">Male (Age Range)</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="female_age_range" name="target_audience[]" value="Female (Age Range)" onchange="toggleAgeRange('female')">
                            <label class="form-check-label" for="female_age_range">Female (Age Range)</label>
                        </div>
                    </div>
                </div>

                <!-- Male Age Range Input -->
                <div class="row mt-3" id="male-age-range" style="display: none;">
                    <div class="col-md-6">
                        <label for="male_min_age" class="form-label">Male Minimum Age</label>
                        <input type="number" class="form-control" id="male_min_age" name="male_min_age"  min="0" max="100">
                    </div>
                    <div class="col-md-6">
                        <label for="male_max_age" class="form-label">Male Maximum Age</label>
                        <input type="number" class="form-control" id="male_max_age" name="male_max_age" min="0" max="100">
                    </div>
                </div>

                <!-- Female Age Range Input -->
                <div class="row mt-3" id="female-age-range" style="display: none;">
                    <div class="col-md-6">
                        <label for="female_min_age" class="form-label">Female Minimum Age</label>
                        <input type="number" class="form-control" id="female_min_age" name="female_min_age" min="0" max="100">
                    </div>
                    <div class="col-md-6">
                        <label for="female_max_age" class="form-label">Female Maximum Age</label>
                        <input type="number" class="form-control" id="female_max_age" name="female_max_age" min="0" max="100">
                    </div>
                </div>
            </div>

            <!-- Delivery Channels -->
            <div class="mb-3">
                <label class="form-label fw-bold">Delivery Channels</label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="website" name="delivery_channels" value="Website" onchange="toggleWebsiteFields()">
                        <label class="form-check-label" for="website">Website</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="email" name="delivery_channels" value="Email/SMS" onchange="toggleWebsiteFields()">
                        <label class="form-check-label" for="email">Email/SMS</label>
                    </div>
                </div>
            </div>

            <!-- Image Upload (Conditional) -->
            <div class="mb-4" id="image-field" style="display: none;">
                <label for="image" class="form-label fw-bold">Upload Image (for Website only)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            <!-- Start and End Date (Conditional) -->
            <div class="row mb-4" id="date-fields" style="display: none;">
                <div class="col-md-6">
                    <label for="start_date" class="form-label fw-bold">Start Date</label>
                    <input type="datetime-local" class="form-control" id="start_date" name="start_date">
                </div>
                <div class="col-md-6">
                    <label for="end_date" class="form-label fw-bold">End Date</label>
                    <input type="datetime-local" class="form-control" id="end_date" name="end_date">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Create Announcement</button>
            </div>
        </form>
    </div>

    <!-- JavaScript -->
    <script>

        

        // Function to handle "All Residents" checkbox
        function toggleAllResidents() {
            const allResidentsCheckbox = document.getElementById('all_residents');
            const otherCheckboxes = document.querySelectorAll('input[name="target_audience[]"]:not(#all_residents)');

            if (allResidentsCheckbox.checked) {
                // If "All Residents" is checked, disable all other checkboxes
                otherCheckboxes.forEach(checkbox => {
                    checkbox.disabled = true;
                    checkbox.checked = false; // Uncheck other checkboxes
                });
            } else {
                // If "All Residents" is unchecked, enable all other checkboxes
                otherCheckboxes.forEach(checkbox => {
                    checkbox.disabled = false;
                });
            }
        }

        // Function to toggle website-specific fields
        function toggleWebsiteFields() {
            const websiteCheckbox = document.getElementById('website');
            const dateFields = document.getElementById('date-fields');
            const imageField = document.getElementById('image-field');

            if (websiteCheckbox.checked) {
                dateFields.style.display = 'flex';
                imageField.style.display = 'block';
            } else {
                dateFields.style.display = 'none';
                imageField.style.display = 'none';
            }
        }

        // Function to toggle age range inputs
        function toggleAgeRange(gender) {
            const maleAgeRange = document.getElementById('male-age-range');
            const femaleAgeRange = document.getElementById('female-age-range');

            if (gender === 'male') {
                maleAgeRange.style.display = document.getElementById('male_age_range').checked ? 'flex' : 'none';
            } else if (gender === 'female') {
                femaleAgeRange.style.display = document.getElementById('female_age_range').checked ? 'flex' : 'none';
            }
        }

        // Reload the page when the success modal is closed
        document.getElementById('successModal').addEventListener('hidden.bs.modal', function () {
            window.location.reload();
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>