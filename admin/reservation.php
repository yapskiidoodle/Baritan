<?php
// Database connection settings
$host = "localhost"; // Change if needed
$username = "root"; // Change if needed
$password = ""; // Change if needed
$database = "Barangay_Baritan"; // Change to your actual database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
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
        <a href="reservation.php" class="active"><i class="fas fa-calendar-alt"></i>Reservations</a>
        <a href="tracking_records.php"><i class="fas fa-calendar-alt"></i>Tracking Records</a>
        <a href="admin_management.php"><i class="fas fa-tools"></i>Admin Management</a>
    </div>



    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>