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


    <div style="margin: 5% 10%;" class="container">
    <div class="ms-5">
        <div class="display-6">
            Our Services
        </div>
        <div class="lead">Online Services we Offer</div>
    </div>


    <div class="mt-5">
        <div class="row">
  
            <div class="col-md-7">
            

            
                <div class="row">
                    <div class="col">
                        <li style="color: #1C3A5B;" class="h4">Application Forms 
                            <div class="lead ms-4" style="font-size: 18px;">Renewal/Closure/Personal Use</div>
                            <div class="text-center">
                            <a href="<?php echo isset($_SESSION['userEmail']) ? 'application.php' : 'login.php?error=application'; ?>">
                                <button class="learn mt-3" style="padding: 10px 20px">Check Forms</button>
                            </a>

                            </div>
                        </li>
                        <br><br><br>
                        <li style="color: #1C3A5B;" class="h4">Barangay ID 
                            <div class="lead ms-4" style="font-size: 18px;">Barangay ID for the residents
                                of <br> Barangay Baritan</div>
                            <div class="text-center">
                            <button type="button" id="next_button" class="learn mt-3" style="padding: 10px 20px"
                                <?php if (!isset($_SESSION['userEmail'])): ?>
                                    onclick="window.location.href='login.php?error=barangayid';"
                                <?php else: ?>
                                    onclick="window.location.href='services/barangay-id.php';"
                                <?php endif; ?>
                            >
                                Click to Apply
                            </button>


                            </div>
                        </li>
                    </div>
                    <div class="col">
                        <li style="color: #1C3A5B;" class="h4">Reservation
                            <div class="lead ms-4" style="font-size: 18px;">Reserve Tents, Chairs, etc...</div>
                            <div class="text-center">
                            <a href="<?php echo isset($_SESSION['userEmail']) ? 'services/reservation.php' : 'login.php?error=reservation'; ?>">
                                <button class="learn mt-3" style="padding: 10px 20px">Click to Apply</button>
                            </a>


                            </div>
                        </li>
                    </div>
                </div>
             



                <hr class="hr mt-4">
                <div class="row" style="margin-top: 10%;">
                    <div class="col">
                        <li style="color: #1C3A5B;" class="h4">Report Complaint
                            <div class="lead ms-4" style="font-size: 18px;">Report an Incident</div>
                            <div class="text-center">
                                <a href="services/complaint.php"><button class="learn mt-3" style="padding: 10px 20px">Click to Apply</button></a>
                            </div>
                        </li>
                    </div>
                    <div class="col">
                        <li style="color: #1C3A5B;" class="h4">Blotter Report
                            <div class="lead ms-4" style="font-size: 18px;">Report an Incident</div>
                            <div class="text-center">
                                <a href="services/blotter.php"><button class="learn mt-3" style="padding: 10px 20px">Click to Apply</button></a>
                            </div>
                        </li>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <img src="../pics/BarangayBaritan.png" alt="Barangay" style="height: 520px; width: 450px;">
            </div>
        </div>
    </div>
 
</div>




    <!--Login Modal Box-->
    

    <div id="modalLogin" class="modal" style="margin-bottom: -5%; ">
        <!-- Modal content -->
           <div class="modal-content" >
           <span class="close">&times;</span>
           <div class="row">
               <div class="col-md-7">
                   <div class="container display-5" style="padding: 5% 5% 5% 10% ;font-weight: 600; color: #1C3A5B; font-size: 40px;">
                       Login
                       <div class="lead pt-2">Login to continue</div>
                   </div>
                   <form style=" padding: 1% 5% 5% 10% ">
                       <div class="form-group">
                         <label for="exampleInputEmail1" class="lead">Email address</label>
                         <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                         
                       </div>
                       <br> 
                       <div class="form-group">
                         <label for="exampleInputPassword1" class="lead">Password</label>
                         <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                       </div>
                       
                       <br>
                       <div class="row">
                           <div class="col">
                               <button type="submit" class="btn btn-danger" style="width: 100%;">Cancel</button>
                           </div>
                           <div class="col">
                               <button type="submit" class="btn text-white " style="width: 100%; background: #1C3A5B;">Login</button>
                           </div>
                       </div>
                     </form>
               </div>
               <div class="col-md-5" style="  margin-bottom: -2%; margin-right: -2%;">
                   <div style="margin-top:-13.6%  ">
                       <img src="../pics/BarangayBaritan.png" alt="" style=" width:490px; height: 491px ;  position: inherit; border-top-right-radius:10px;  border-bottom-right-radius:10px; "  >
                       <div class="text-white text-center display-5 " style="margin-top: -90%; margin-left: 50px; font-weight: 700; font-size: 36px;">
                           Sign Up
                           <div class="lead mt-3">
                               Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odio velit  
                           </div>
                              <a href="html/register.php"> <button type="submit" class="btn text-white learn" style="width: 50%; background: #1C3A5B; margin-top: 30%; ">Register</button>
                              </a>
                       </div>
                   </div>
               </div>
           </div>
           </div>

     </div>

     <div class="modal fade" id="autofill" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="40" fill="currentColor" class="bi bi-info" viewBox="0 0 16 16">
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                      </svg>
                  <h5 class="modal-title" id="exampleModalLongTitle">Notification
                    
                  </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Do you want to auto fill the requirements? 
                </div>
                <div class="modal-footer">
                    <div class="me-auto">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    
                    </div>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='services/barangay-id.php'">No</button>
                    <button type="button" class="btn btn-primary" onclick="window.location.href='services/barangay-id.php'">Yes</button> 
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Bundle (includes Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script src="../script.js"></script>



</body>
</html>