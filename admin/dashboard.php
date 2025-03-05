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
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
        <a href="#"><i class="fas fa-users"></i>Residents</a>
        <a href="#"><i class="fas fa-bullhorn"></i>Announcement</a>
        <a href="#"><i class="fas fa-file-alt"></i>Documents</a>
        <a href="#"><i class="fas fa-file-signature"></i>Approved Documents</a>
        <a href="#"><i class="fas fa-clipboard-list"></i>Blotter Report</a>
        <a href="#"><i class="fas fa-exclamation-circle"></i>Complaint Report</a>
        <a href="#"><i class="fas fa-calendar-alt"></i>Reservations</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Welcome to the Admin Panel</h1>
        <p>This is the main content area. You can add your content here.</p>
    </div>

    <script>
        function logout() {
            alert("Logout clicked!");
            // Add your logout logic here
        }
    </script>

    <!-- Bootstrap JS (required for dropdown functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>