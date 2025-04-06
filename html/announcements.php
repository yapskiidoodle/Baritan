<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    session_start(); // Start the session
    require '../src/account.php';
    require '../src/connect.php'; // Use 'include' or 'require' to load the file

    // Check if the account is deactivated
    if (isset($_SESSION['deactivated']) && $_SESSION['deactivated'] === true) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', f unction() {
                var myModal = new bootstrap.Modal(document.getElementById('deactivatedModal'));
                myModal.show();
            });
        </script>";
        unset($_SESSION['deactivated']); // Clear the session variable
    }

    // Fetch active announcements from the database
    $sql = "SELECT * FROM announcement_tbl 
            WHERE delivery_channels = 'Website' 
              AND start_date <= NOW() 
              AND end_date >= NOW()";
    $result = $conn->query($sql);
    $announcements = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $announcements[] = $row; // Store each announcement in the array
        }
    }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Baritan Official Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../pics/logo.png">
    <link rel="stylesheet" href="../design.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            overflow-x: hidden;
        }

        /* Add padding to the top of the announcements container */
        .announcements-container {
            padding-top: 120px; /* Adjust this value based on the header height */
        }

        /* Ensure all cards have the same height */
        .announcement-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
            height: 100%; /* Make all cards the same height */
            display: flex;
            flex-direction: column;
        }

        .announcement-card:hover {
            transform: translateY(-5px); /* Add a slight hover effect */
        }

        .announcement-card img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 15px;
            height: 200px; /* Fixed height for images */
            object-fit: cover; /* Ensure images cover the area without distortion */
        }

        .announcement-card h3 {
            color: #1C3A5B;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .announcement-card p {
            color: #333;
            margin-bottom: 15px;
            flex-grow: 1; /* Allow text to take up remaining space */
        }

        .announcement-card .message-short {
            display: -webkit-box;
            -webkit-line-clamp: 3; /* Limit to 3 lines */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .announcement-card .view-button {
            background-color: #1C3A5B;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
            align-self: center; /* Center the button horizontally */
            margin-top: auto; /* Push the button to the bottom */
        }

        .announcement-card .view-button:hover {
            background-color: #2a4d6e; /* Darker shade on hover */
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 10px;
        }

        .modal-header {
            background-color: #1C3A5B;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            display: flex;
            justify-content: space-between; /* Align title and close button */
            align-items: center; /* Vertically center items */
        }

        .modal-title {
            font-weight: bold;
            margin: 0; /* Remove default margin */
        }

        .modal-body {
            padding: 20px;
        }

        .modal-body img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .modal-footer {
            border-top: none;
            padding: 15px 20px;
            display: flex;
            justify-content: flex-end; /* Align close button to the right */
        }

        .modal-footer .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .modal-footer .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div style="background-color:#1C3A5B;top:0;color: white;padding: 1%; position:fixed; width: 100%; z-index: 1000;">
        <div class="row">
            <div class="col-1" style="width: 5.3%;">
                <img src="../pics/logo.png" alt="Barangay Baritan Logo" style="width: 75px; display: inline;">
            </div>
            <div class="col-7">
                <h4 style="padding-top:0.4%;">Barangay Baritan</h4>
                <h6 style="font-size: 10.5px;">Malabon City, Metro Manila, Philippines</h6>
            </div>
            <div class="col" style="text-align: center; padding-top: 1.5%;">
                <div style="display: flex;">
                    <div style="padding:0% 4%;">
                        <a href="../">Home</a>
                    </div>
                    <div class="vr"></div>
                    <div style="padding:0% 4%;">
                        <a href="about.php">About Us</a>
                    </div>
                    <div class="vr"></div>
                    <div style="padding:0% 4%;">
                        <a href="service.php">Services</a>
                    </div>
                    <div class="vr"></div>
                    <div style="padding:0% 4%;">
                        <a href="../index.php#contact">Contact Us</a>
                    </div>
                    <div class="vr"></div>
                    <?php if (isset($_SESSION['userEmail'])) { ?>
                        <div class="dropdown" id="profile" name="profile">
                            <button class="btn dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="../pics/profile.jpg" alt="" style="border-radius: 50%; width: 30px;">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="../html/profile.php"><i class="fas fa-user"></i> Profile</a></li>
                                <li>
                                    <form action="../src/logout.php" method="POST">
                                        <button class="dropdown-item" name="logoutButton"><i class="fas fa-sign-out-alt"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    <?php } else { ?>
                        <div id="start" name="start">
                            <a href="login.php" class="btn btn-danger ms-2">Log In</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header -->

    <!-- Announcements Container -->
    <div class="container announcements-container">
        <h2 class="text-center mb-4">Announcements</h2>
        <?php if (empty($announcements)): ?>
            <div class="text-center">
                <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                <p class="text-muted">There are no active announcements at the moment.</p>
            </div>
        <?php else: ?>
            <div class="row justify-content-center">
                <?php foreach ($announcements as $announcement): ?>
                    <div class="col-md-<?php echo count($announcements) == 1 ? '6' : '6'; ?> mb-4">
                        <div class="announcement-card">
                            <?php if (!empty($announcement['image_path'])): ?>
                                <img src="../admin/<?php echo $announcement['image_path']; ?>" alt="Announcement Image">
                            <?php endif; ?>
                            <h3><?php echo htmlspecialchars($announcement['category']); ?></h3>
                            <div class="message-short">
                                <?php echo htmlspecialchars($announcement['message']); ?>
                            </div>
                            <!-- Centered "View More" button -->
                            <button class="view-button" data-bs-toggle="modal" data-bs-target="#announcementModal<?php echo $announcement['announcement_id']; ?>">
                                View More
                            </button>
                        </div>
                    </div>

                    <!-- Modal for this announcement -->
                    <div class="modal fade" id="announcementModal<?php echo $announcement['announcement_id']; ?>" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Medium-sized modal -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="announcementModalLabel">Announcement Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin-left: auto;"></button>
                                </div>
                                <div class="modal-body">
                                    <h3><?php echo htmlspecialchars($announcement['category']); ?></h3>
                                    <p><?php echo htmlspecialchars($announcement['message']); ?></p>
                                    <?php if (!empty($announcement['image_path'])): ?>
                                        <img src="../admin/<?php echo $announcement['image_path']; ?>" alt="Announcement Image" class="img-fluid" style="border-radius: 10px;">
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>


    <!-- Bootstrap Bundle (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../script.js"></script>
</body>
</html>