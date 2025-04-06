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

   
    <!-- Header -->
    
    <!--header-->
    <div style="background-color:#1C3A5B;top:0;color: white;padding: 1%; position:fixed; width: 100%;">
        <div class="row">
           <div class="col-1" style="width: 5.3%; ">
               <img src="../pics/logo.png" alt="Barangay Baritan Logo" style="width: 75px; display: inline;">
               
           </div>
           <div class="col-7" >
               <h4 style="padding-top:0.4%;">Barangay Baritan</h4>
               <h6 style="font-size: 10.5px;">Malabon City, Metro Manila, Philippines</h6>
           </div>
           <div class="col" style=" text-align: center; padding-top: 1.5%;">
               <div style="display: flex; ">
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

 

        <div class="container " style="margin-top: 10%;">
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