<!DOCTYPE html>
<html lang="en">
<head>
<?php
require 'src/connect.php'; // Use 'include' or 'require' to load the file
require 'src/account.php';



if (isset($_SESSION['deactivated']) && $_SESSION['deactivated'] === true) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('deactivatedModal'));
            myModal.show();
        });
    </script>";
    unset($_SESSION['deactivated']); // Clear the session variable
}

if (isset($_SESSION['error_message'])) {
  $errorMessage = $_SESSION['error_message'];
  unset($_SESSION['error_message']); // Clear the error message after displaying it
} else {
  $errorMessage = ""; // No error message
}

?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Barangay Baritan Official Website</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="pics/logo.png">
    <link rel="stylesheet" href="design.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    

    <style>
        body {
            overflow-x: hidden;
        }
        
        
  

    </style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var profile = document.getElementById("profile");
        var start = document.getElementById("start");

        <?php if (isset($_SESSION['userEmail'])) { ?>
            profile.hidden = false;
            start.hidden = true;
        <?php } else { ?>
            profile.hidden = true;
            start.hidden = false;
        <?php } ?>
    });
</script>

    
</head>
<body>
        

        <div class="aspect-ratio-container">
            <img src="pics/BarangayBaritan.png" alt="Barangay Baritan">
        </div>


    <!--header-->
    <div style="background-color:#1C3A5B;top:0;color: white;padding: 1%; position:fixed; width: 100%;">
        <div class="row">
           <div class="col-1" style="width: 5.3%; ">
               <img src="pics/logo.png" alt="Barangay Baritan Logo" style="width: 75px; display: inline;">
               
           </div>
           <div class="col-7" >
               <h4 style="padding-top:0.4%;">Barangay Baritan</h4>
               <h6 style="font-size: 10.5px;">Malabon City, Metro Manila, Philippines</h6>
           </div>
           <div class="col" style=" text-align: center; padding-top: 1.5%;">
               <div style="display: flex; ">
                   <div style="padding:0% 4%;">
                       <a href="">Home</a>
                   </div>
                   <div class="vr"></div>
                   <div style="padding:0% 4%;">
                       <a href="html/about.php">About Us</a>
                   </div>
                   <div class="vr"></div>
                   <div style="padding:0% 4%;">
                       <a href="html/service.php">Services</a>
                   </div>
                   <div class="vr"></div>
                   <div style="padding:0% 4%;">
                      <a href="#contact">Contact Us</a>
                   </div>
                   <div class="vr"></div>
                   <div class="dropdown" id="profile" name="profile" hidden>
                        <button class="btn dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="pics/profile.jpg" alt="" style="border-radius: 50%; width: 30px;">
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                            <!--<li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li> -->
                            <li><a class="dropdown-item" href="html/profile.php" name="logoutButton"><i class="fas fa-sign-out-alt"></i> Profile</a></li>
                            <li><form action="src/logout.php" method="POST"><button class="dropdown-item" href="index.php" name="logoutButton"><i class="fas fa-sign-out-alt"></i> Logout</button></li></form>

                        </ul>
                    </div>
                   <div id="start" name="start">
                        <button  class="btn btn-danger ms-2" style="margin-top: -8.6%; width: 100%;"role="button" onclick="window.location.href='html/login.php'">Log In</button>
                   </div>
               </div>
           </div>
        </div>
        </div>


        
     <div class="container" style="margin-top:-40%">
        
        <div class="body-content  display-4" style="font-weight: 500; color: white;">
            Barangay Baritan, <br> 
            Malabon City
            <div class="lead">
                “Bringing the barangay closer to its people, <br>
                building a stronger, more connected community every day."   
            </div>
        </div>
        <div>
            <a href="html/announcements.php"><button class="btn learn" style="margin-top:5%">
                Announcements
            </button></a>
        </div>

        
     </div>
     <div class="infos container" style="margin-top: 20%;" id="learn">
        <div class="row">
            <span class="col-md-6 text-center display-6 pt-3" style="font-weight: 500;">
                Operating  Hours
            </span>
            <span class="col-md-3 text-center pt-3" style="font-weight: 500;" >
                Mondays-Fridays <br>
                <div class="lead">
                    8:00 AM - 5:00 PM
                </div>
            </span>
            <span class="col-md-3 text-center" style="font-weight: 500;">
                Barangay Soldiers For Peace & Order
                <div class="lead">
                    24 Hours
                </div>
            </span>
        </div>
        
     </div>
    
     <div class="faq container mt-5 display-6 ">
        <span style="color: #70A0D7;">-</span>Frequenly Ask Questions (FAQs)
        
     </div>
     <div class="faq-container">
        <div class="faq-item">
          <button class="faq-question">Who should apply for the account?</button>
          <div class="faq-answer">
            <p>The account should be applied for by the head of the family, as designated within the family.</p>
          </div>
        </div>
        <div class="faq-item">
          <button class="faq-question">What online payment methods are accepted?</button>
          <div class="faq-answer">
            <p>We currently accept payments via PayMaya and GCash.</p>
          </div>
        </div>
        <div class="faq-item">
          <button class="faq-question">Do I need to register to access services?</button>
          <div class="faq-answer">
            <p>Yes, registration is required to access all services.</p>
          </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">When should I apply for a Certificate of Indigency?</button>
            <div class="faq-answer">
              <p>You may apply for a Certificate of Indigency if you need it for the following purposes: financial assistance, medical assistance, educational assistance, social pension requirements, burial assistance, P.W.D ID requirements, anti-rabies vaccination, legal assistance, 4Ps requirements, OSCA requirements, solo parent ID requirements, drug test requirements.</p>
            </div>
          </div>
          <div class="faq-item">
            <button class="faq-question"> When should I apply for a Clearance, Certification, or Permit?</button>
            <div class="faq-answer">
              <p>Apply for these documents if required for: SSS requirements, PLDT requirements, demolition permit, renovation permit, postal ID requirements, PhilHealth requirements, business permit or business closure, bank requirements, loan requirements, marriage requirements, internet connection requirements.</p>
            </div>
          </div>
      </div>
      <div class="container text-center " style="width: 40%; margin-bottom: 4%;">
        <div class="row">
            <div class="col" style="text-align: left;">
                <div class="display-5" style="font-size: 20px;">
                    Got any Questions? <br>
                    <div class="lead" style="color:#1C3A5B; font-weight: 500; font-size: 30px; padding-top: 10px;">
                        (+63) 942 423 5234
                    </div>
                </div>
            </div>
            <div class="col" style="text-align: left; border-left: 3px solid black; ">
                <div class="display-5" style="font-size: 20px;">
                    Reach us out on <br>
                    <div class="lead" style="color:#1C3A5B; font-weight: 500; font-size: 30px; padding-top: 9px;">
                        <a href="https://www.facebook.com/barangaybaritankmgs" style="color: #1C3A5B" target="_blank">
                       
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="30" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                          </svg>
                          <span style="font-size: 16px; margin-left: -5%;">Facebook</span>
                        
                    </div></a>
                </div>
            </div>
        </div>
        <br>
        <!--contact us-->
        <form action="mailto:jerichoyap27@gmail.com" method="post" enctype="text/plain">

    
        <div class="h4 form-group mt-4" style="font-weight: 600; text-align: left;">
            <label for="exampleFormControlTextarea1" >Leave Your Concerns here</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Type your message here..."></textarea>
          </div>
            <div style="text-align: right;">
                <button type="submit"  class="button learn ms-auto mt-2" id="contact">Submit</button>
            </div>
        </form>
        <!--end code-->

      </div>

    



<script>
//         document.addEventListener('hidden.bs.modal', function () {
//     document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
// });


document.addEventListener('hidden.bs.modal', function () {
    // Remove all modal backdrops
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    // Ensure the body class is removed
    document.body.classList.remove('modal-open');
    // Reset inline styles added by Bootstrap
    document.body.style.paddingRight = '';
});

</script>

      <!-- -->

<!-- data privacy -->

<!-- Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" >
      <div class="modal-content"  style="width:  280%;  ">
        <div class="modal-header">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="40" fill="currentColor" class="bi bi-info" viewBox="0 0 16 16">
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
              </svg>
          <h5 class="modal-title" id="exampleModalLongTitle">Privacy Notice
            
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class=" tc_body">
                <ol>
                  <li>
                    <h3>Terms of use</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, quidem doloribus cumque vero, culpa voluptates dolorum reprehenderit nihil nisi odit necessitatibus voluptate voluptatibus magni ducimus sed accusamus illo nobis veniam.</p>
                  </li>
                  <li>
                    <h3>Intellectual property rights</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, quidem doloribus cumque vero, culpa voluptates dolorum reprehenderit nihil nisi odit necessitatibus voluptate voluptatibus magni ducimus sed accusamus illo nobis veniam.</p>
                  </li>
                  <li>
                    <h3>Prohibited activities</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, quidem doloribus cumque vero, culpa voluptates dolorum reprehenderit nihil nisi odit necessitatibus voluptate voluptatibus magni ducimus sed accusamus illo nobis veniam.</p>
                  </li>
                  <li>
                    <h3>Termination clause</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, quidem doloribus cumque vero, culpa voluptates dolorum reprehenderit nihil nisi odit necessitatibus voluptate voluptatibus magni ducimus sed accusamus illo nobis veniam.</p>
                  </li>
                  <li>
                    <h3>Governing law</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, quidem doloribus cumque vero, culpa voluptates dolorum reprehenderit nihil nisi odit necessitatibus voluptate voluptatibus magni ducimus sed accusamus illo nobis veniam.</p>
                  </li>
                </ol>
              </div>
        </div>
        <div class="modal-footer">
            <form>
                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="termsCheckbox">
                            <label class="form-check-label" for="termsCheckbox">
                              I have read and agree to the <br>  <a href="#" style="text-decoration: none;color: #94c8ff; ">Terms and Conditions</a>
                            </label>
                          </div>
                          
                    </div>
                    <div class="col text-center" >
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.reload();">Close</button>
                        <button type="button" class="btn btn-primary" id="submitBtn" disabled style="background-color: #1C3A5B;" >I Accept</button>
                    
                    </div>
                </div>

                <script>
                    document.getElementById("termsCheckbox").addEventListener("change", function() {
                        let submitBtn = document.getElementById("submitBtn");
                        submitBtn.disabled = !this.checked;
                    });
                
                    document.getElementById("submitBtn").addEventListener("click", function(event) {
                        event.preventDefault(); // Prevent default behavior (useful in forms)
                        console.log("Button clicked! Redirecting...");
                        window.location.href = "html/register.php";
                    });
                </script>
            </form>
                
 
        </div>
      </div>
    </div>
  </div>

<!-- Bootstrap 5 Deactivated Account Modal -->
<div class="modal fade" id="deactivatedModal" tabindex="-1" aria-labelledby="deactivatedModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-white">
        <h5 class="modal-title" id="deactivatedModalLabel" >Account Deactivated</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
      </div>
      <div class="modal-body text-center">
        <p>Your account is currently deactivated. Please wait for the administrator to activate/reactivate your account.</p>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-secondary w-50" data-bs-dismiss="modal">Close</button>
      </div>>
    </div>
  </div>
</div>

<!-- Bootstrap 5 JS (Ensure this is included) -->














<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Bundle (includes Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script src="script.js"></script>

</body>
</html>