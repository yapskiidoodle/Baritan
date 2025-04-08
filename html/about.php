<!DOCTYPE html>
<html lang="en">
<head>
<?php
require '../src/account.php';
require '../src/connect.php'; // Use 'include' or 'require' to load the file



if (isset($_SESSION['deactivated']) && $_SESSION['deactivated'] === true) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('deactivatedModal'));
            myModal.show();
        });
    </script>";
    unset($_SESSION['deactivated']); // Clear the session variable
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
    </style>



</head>
<body>
   <!-- Floating chat icon -->
<div class="chatbot-icon" id="chatbot-icon">
        <img src="https://cdn-icons-png.flaticon.com/512/2099/2099192.png" alt="Chat">
    </div>
    
    <!-- Chat container (hidden by default) -->
    <div class="chatbot-container" id="chatbot-container">
        <div class="chat-header">
            <span id="chat-title">Help Center Bot</span>
            <div class="chat-header-controls">
                <button class="chat-btn lang-btn" id="lang-btn">Filipino</button>
                <button class="chat-btn close-btn" id="close-btn">×</button>
            </div>
        </div>
        <div class="chat-messages" id="chat-messages">
            <div class="welcome-message" id="welcome-message">Click on a question below to get an instant answer</div>
        </div>
        <div class="questions-container" id="questions-container" style="overflow-y: scroll; height: 10em;">
            <!-- Questions will be inserted here by JavaScript -->
        </div>
    </div>
    <script src="../chatbot.js"> </script>
    <link rel="stylesheet" href="../chatbot.css">

   
    
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

 

        <div class="container " style="margin-top: 5%;">
            <div class="display-4 text-center" style="font-weight:bold;">
                    History
                    <p class="lead mt-4" style="text-align: justify; font-size: 24px;">
                        &nbsp;&nbsp;&nbsp;&nbsp; In the early days of its existence, Baritan was partially a grassy and muddy place. The whole barrio was almost totally covered by grass called "baret" which was used as feed for horses. For this reason it later came to be known as Baritan with a total land area of 33.01 hectares. It's major economic sources are fishing and other commercial. Barangay Baritan is situated at East- Muzon River; North - Barangay Flores; South - Barangay Concepcion and West is the Malabon-NavotasRiver.It's current location is at #1 Sta. Rita St., Sto. Rosario Village, Baritan, Malabon City.With 10,193 total population (as of 2015 PSA survey), 2,530 households, 4,375 no. of families and 7,722 registered voters. <br> <br>

                        &nbsp;&nbsp;&nbsp;&nbsp;It is headed by Barangay Captain Gleen P. Santiago, Barangay Kagawads are Edwin G. Hio, Noel A. Espino, Rodelio E. Santos, Virgilio K. Que Christopher Don R. Lucas, Ma. Concepcion S. Santiago, and Bersigo R. Martin Jr. SK Jaymie Dianne Bautista. Barangay Secretary Jennifer D. Mangahas and Barangay Treasurer Elisha Emile D. Gungon. Philippine Long Distance Co. (PLDT], RufinaPatis and Metro Oil Gasoline Station are some thewell known business establishments in our Barangay. Schools are Amang Rodriguez. Elementary School(ARES) and Arellano University. <br><br>
           
                        &nbsp;&nbsp;&nbsp;&nbsp; The Baritan Sports Complex is a venue for doing recreational sports, meetings and assemblies. Today, Barangay Baritan is categorized as an Urban area/community wherein jeepneys, pedicahs, tricycles, motorcycles, motor tricycles, e-jeepneys and e-trikes are the existing means of transportation.
                    </p>
            </div>
        </div>
        <div class="container" style="background-color: #1C3A5B;margin-top: 10%;">
            <div class="row">
                <div class="col">
                    <img src="../pics/BarangayBaritan.png" class="" style="height:550px; width: 630px; object-fit: cover; margin-left: -2% ;"> 

                </div>
                
                <div class="col text-white mt-5" >
                    <div >
                        <ul style="font-size: 30px; list-style: none; text-align: justify; padding: 30px; ">
                            <li >Vision</li>
                                <ul>
                                    <li style="font-size: 20px;">
                                        To be a model barangay that upholds transparency, integrity, and responsiveness in serving the needs of its residents, fostering a safe and thriving community for all
                                    </li>
                                </ul>
                            <li style="margin-top: 10%;">Mission</li>
                                <ul>
                                    <li style="font-size: 20px;">
                                        Our mission is to provide efficient and effective public service to the residents of Barangay Baritan, promoting good governance, community empowerment, and sustainable development. We are committed to serving with honesty, fairness, and dedication, always putting the welfare of our constituents first.

                                    </li>
                                </ul>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <div>
                <img src="../pics/4.png" alt="" class="img-fluid " style=" margin-top:3%; height: 528px;"> 
            </div>
            <div>
                <img src="../pics/5.png" alt="" class="img-fluid" style=" margin-top:3%; height: 500px;">
            </div>
        </div>  



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Bundle (includes Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script src="../script.js"></script>



</body>
</html>