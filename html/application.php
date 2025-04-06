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
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../pics/logo.png">
    <link rel="stylesheet" href="../design.css">
    
    <style>
        body {
            overflow-x: hidden;
        }
        .form-box {
            margin:5% 3% ;
            border-radius: 2%;
            border:1px solid black;
            box-shadow: 5px 5px 5px rgb(187, 185, 185);
            text-align: center;
            justify-content: center;
            img {
                width: 150px;
                height: 200px;
                border: 1px solid black;
                
            }
            button {
                border-radius: 10%;
            }
            button:hover {
                background-color: aliceblue;
                transition: all  0.5s ease-in-out ;
            }
            
             

        }
        .button {
            margin: 0% 0% 4% 1%;
            padding: 1% 3%;
            font-size: 20px;
            color: white;
            border-radius: 0%;
            background-color: #1C3A5B;
            
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

        <div class="container" style="margin-top: 10%;">
            <div class="display-3">
                Available Forms
            </div>
                <div class="row" text-center>
                    <div class="col-md-4">
                        <div class="form-box">
                            <div class="h5 mt-4">
                                Person with Disability <br>
                                (PWD) Form
                                <img src="../pics/pwd.webp" alt="" class="img-fluid d-block mx-auto mt-4">
                            </div>
                            <div class="container-fluid" style="background-color: #1C3A5B; color: white;">
                                <div class="row">
                                    <div class="col m-4">
                                        <a href=""><button  style="padding: 2% 20% ;">View</button></a>
                                    </div>
                                    <div class="col m-4">
                                        <a href=""><button  style="padding: 2% 10% ;">Download</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="form-box">
                            <div class="h5 mt-4">
                                Senior Citizen <br>
                                Application Form
                                <img src="../pics/pwd.webp" alt="" class="img-fluid d-block mx-auto mt-4">
                            </div>
                            <div class="container-fluid" style="background-color: #1C3A5B; color: white;">
                                <div class="row">
                                    <div class="col m-4">
                                        <a href=""><button  style="padding: 2% 20% ;">View</button></a>
                                    </div>
                                    <div class="col m-4">
                                        <a href=""><button  style="padding: 2% 10% ;">Download</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-box">
                            <div class="h5 mt-4">
                                Solo Parent <br> 
                                Form 
                                
                                <img src="../pics/pwd.webp" alt="" class="img-fluid d-block mx-auto mt-4">
                            </div>
                            <div class="container-fluid" style="background-color: #1C3A5B; color: white;">
                                <div class="row">
                                    <div class="col m-4">
                                        <a href=""><button  style="padding: 2% 20% ;">View</button></a>
                                    </div>
                                    <div class="col m-4">
                                        <a href=""><button  style="padding: 2% 10% ;">Download</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="display-5 mt-5 ">
                    Available Certificates/Clearance/Permit
                </div>
                <div class="row mt-4" style="font-size: 20px;">
                    <div class="col " >
                        <ul>
                            <li>SSS Requirements</li>
                            <li>PLDT Requirements</li>
                            <li>Demolition Permit</li>
                            <li>Renovation Permit</li>
                            <li>Postal ID Requirements</li>
                            <li>PhilHealth Requirements</li>
                            <li>Business Permit/Business Closure</li>
                            <li>Application for Late Submission of Birth Certificate</li>
                        </ul>
                        
                    </div>
                    <div class="col">
                        <ul>
                            <li>LOAN REQUIREMENTS</li>
                            <li>MARRIAGE REQUIREMENTS</li>
                            <li>INTERNET CONNECTION REQUIREMENTS</li>
                            <li>TESDA REQUIREMENTS</li>
                            <li>PROOF OF RESIDENCY</li>
                            <li>APPLICATION FOR EMPLOYMENT</li>
                            <li>E-TRIKE REGISTRATION/LOAN</li>
                        </ul>
                    </div>
                </div>
                <div class="display-5 mt-4 ">
                    Available Indigency
                </div>
                <div class="row mt-4" style="font-size: 20px;">
                    <div class="col">
                        <ul>
                            <li>FINANCIAL ASSISTANCE</li>
                            <li>MEDICAL ASSISTANCE</li>
                            <li>EDUCATIONAL ASSISTANCE</li>
                            <li>SOCIAL PENSION REQUIREMENT</li>
                            <li>BURIAL ASSISTANCE</li>
                            <li>P.W.D ID REQUIREMENT</li>
                            <li>ANTI RABIES VACCINATION REQUIREMENT</li>

                        </ul>
                    </div>
                    <div class="col">
                        <ul>
                            <li>LEGAL ASSISTANCE</li>
                            <li>4P'S REQUIREMENT</li>
                            <li>OSCA REQUIREMENT</li>
                            <li>SOLO PARENT ID REQUIREMENT</li>
                            <li>DRUG TEST REQUIREMENT</li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex mt-5">
                    <button type="button" id="back_button" onclick="window.location.href='service.php'" class="button me-auto mt-2">
                        Back
                    </button>
                    <button type="button" id="next_button" class="button mt-2" >
                        <a href="services/indigency.php">Click to Apply for Indigency</a>
                    </button>
                    <button type="button" id="next_button" class="button mt-2" >
                        <a href="services/certificate.php">Click to Apply for Clearance/Certificate/Permit</a>
                    </button>
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
                              <a href="register.php"> <button type="submit" class="btn text-white learn" style="width: 50%; background: #1C3A5B; margin-top: 30%; ">Register</button>
                              </a>
                       </div>
                   </div>
               </div>
           </div>
           </div>

     </div>


<script src="../script.js"></script>
     

</body>
</html>