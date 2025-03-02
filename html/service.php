<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Barangay Baritan Official Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../pics/logo.png">
    <link rel="stylesheet" href="../design.css">
    <!-- Bootstrap JS (Required for Modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            overflow-x: hidden;
        }
    </style>
</head>
<body>
   

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
                       <a href="../index.php">Home</a>
                   </div>
                   <div class="vr"></div>
                   <div style="padding:0% 4%;">
                       <a href="about.php">About Us</a>
                   </div>
                   <div class="vr"></div>
                   <div style="padding:0% 4%;">
                       <a href="">Services</a>
                   </div>
                   <div class="vr"></div>
                   <div style="padding:0% 4%;">
                      <a href="../index.php?#contact">Contact Us</a>
                   </div>
                   <div class="vr"></div>
                   <div hidden>
                       <img src="/pics/logo.png" alt="Barangay Baritan Logo" style="width: 75px; margin-top: -26.6%; margin-left: 5%;">
                   </div>
                   <div>
                        <button id="login" class="btn btn-danger ms-2" style="margin-top: -8.6%; width: 100%;">Log In</button>
                   </div>
               </div>
           </div>
        </div>
        </div>
      <!--end header-->

      <div style="margin: 10%; " class="container">
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
                                    <a href="application.php"><button class="learn mt-3" style="padding: 10px 20px" >Check Forms</button></a>
                                </div>
                            </li>
                            <br>
                            <br>
                            <br>
                            <li style="color: #1C3A5B;" class="h4">Barangay ID 
                                <div class="lead ms-4" style="font-size: 18px;">Barangay ID for the residents
                                    of <br> Barangay Baritan</div>
                                    <div class="text-center">
                                        <button type="button" id="next_button" class="learn  mt-3"  style="padding: 10px 20px" data-bs-target="#autofill"  data-bs-toggle="modal" >
                                            Click to Apply
                                        </button> 
                                    </div>
                            </li>
                        </div>
                        <div class="col">
                            <li style="color: #1C3A5B;" class="h4">Reservation
                                <div class="lead ms-4" style="font-size: 18px;">Reserve Tents, Chairs, etc...</div>
                                <div class="text-center">
                                    <a href="services/reservation.php"><button class="learn mt-3" style="padding: 10px 20px">Click to Apply</button></a>
                                </div>
                            </li>
                        </div>
                    </div>
                    <hr class="hr mt-4" >
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
                                  <a href="services/blotter.php"> <button class="learn mt-3" style="padding: 10px 20px">Click to Apply</button></a>
                                </div>
                            </li>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <img src="../pics/BarangayBaritan.png " alt="Barangay"  style="height: 520px; width: 450px;">
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


     
<script src="../script.js"></script>
     





















</body>
</html>