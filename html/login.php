<!DOCTYPE html>
<html lang="en">
<head>
<?php
require '../src/connect.php'; // Use 'include' or 'require' to load the file
require '../src/account.php';

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
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="pics/logo.png">
    <link rel="stylesheet" href="../design.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
    body {
        background-image: url('../pics/BarangayBaritan.png');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        overflow-y: auto; /* Allows scrolling */
    }

    .content {
        
        z-index: 1;
        padding-top: 50px; /* Adjust this value based on your header's height */
     
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
<body style="overflow-y:hidden;">
        

    <!-- Header -->
    <div style="background-color:#1C3A5B; top: 0; color: white; padding: 1%; position: fixed; width: 100%;">
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
                   <div style="padding:0% 4%;"> <a href="../index.php">Home</a> </div>
                   <div class="vr"></div>
                   <div style="padding:0% 4%;"> <a href="about.php">About Us</a> </div>
                   <div class="vr"></div>
                   <div style="padding:0% 4%;"> <a href="">Services</a> </div>
                   <div class="vr"></div>
                   <div style="padding:0% 4%;"> <a href="../index.php?#contact">Contact Us</a> </div>
                   <div class="vr"></div>
                   <div hidden> <img src="pics/logo.png" alt="Barangay Baritan Logo" style="width: 75px; margin-top: -26.6%; margin-left: 5%;"> </div>
                   <div>
                        <button id="login" class="btn btn-danger ms-2" style="margin-top: -8.6%; width: 100%;">Log In</button>
                   </div>
               </div>
           </div>
        </div>
    </div>
    <!-- End Header -->
    <div style="margin-bottom: -6%;"></div>
    <div class="container content" style="background-color: rgba(255, 255, 255, 0.8); margin-top:15%; width:30%; border-radius:10px;">
    <form  action="../src/account.php" method="POST">
    <div class="container text-center" style=" font-weight: 600; color: #00264d; font-size: 28px;">
          Login
          <div class="lead pt-2">Login to continue</div>
        </div>
        <!-- Email input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input name="userEmail" type="text" class="form-control" class="form-control" required placeholder="Enter Username"/>
            <label class="form-label" for="form2Example1">Username</label>
        </div>

        <!-- Password input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" name="password" type="password" class="form-control" required placeholder="Enter Password"/>
            <label class="form-label" for="form2Example2">Password</label>
        </div>

        <!-- 2 column grid layout for inline styling -->
        <div class="row mb-4">
            <div class="col d-flex justify-content-center">
                <!-- Checkbox -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                    <label class="form-check-label" for="form2Example31"> Remember me </label>
                </div>
            </div>

            <div class="col" >
                <!-- Simple link -->
                <a href="#!" style="color: #1C3A5B;">Forgot password?</a>
            </div>
        </div>

        <!-- Submit button -->
        <div class="container text-center ">
        <button name="loginButton" type="submit" class="btn text-white w-100" 
                style="background-color: #00264d; border-radius: 7px; padding: 10px; font-size: 16px;">
                Login
               
              </button>
            
        </div>
        <!-- Register buttons -->
        <div class="text-center pb-5">
            <p>Not a member? <a href="../html/register.php" style="color: #1C3A5B;">Register</a></p>
            
        </div>
    </form>
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
      <div class="modal-footer text-left">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
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

    <script src="script.js"></script>

</body>
</html>
