<!DOCTYPE html>
<html lang="en">
<head>
<?php
require 'src/connect.php';
require 'src/account.php';

if (isset($_SESSION['deactivated']) && $_SESSION['deactivated'] === true) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('deactivatedModal'));
            myModal.show();
        });
    </script>";
    unset($_SESSION['deactivated']);
}

if (isset($_SESSION['error_message'])) {
  $errorMessage = $_SESSION['error_message'];
  unset($_SESSION['error_message']);
} else {
  $errorMessage = "";
}



?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Baritan Official Website</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="pics/logo.png">
    <link rel="stylesheet" href="design.css">
</head>
<body>

<?php
$profilePic = isset($_SESSION['User_Data']['Pic_Path']) && !empty($_SESSION['User_Data']['Pic_Path']) 
    ? 'resident_folder/profile/' . $_SESSION['User_Data']['Pic_Path'] 
    : 'pics/profile.jpg';
?>

<!-- Header -->
<header class="container-fluid text-white py-2 px-3" style="background-color: #1C3A5B;">
    <div class="row align-items-center">
        <div class="col-auto">
            <img src="pics/logo.png" alt="Barangay Baritan Logo" class="img-fluid" style="max-width: 75px;">
        </div>
        
        <div class="col-auto">
            <h4 class="mb-0">Barangay Baritan</h4>
            <small class="d-block">Malabon City, Metro Manila, Philippines</small>
        </div>
        
        <div class="col ms-auto">
            <nav class="d-flex justify-content-end align-items-center">
                <div class="d-flex align-items-center">
                    <div class="nav-item px-2">
                        <a href="index.php" class="text-white text-decoration-none">Home</a>
                    </div>
                    <div class="vr text-white mx-1 d-none d-md-block"></div>
                    <div class="nav-item px-2">
                        <a href="html/about.php" class="text-white text-decoration-none">About Us</a>
                    </div>
                    <div class="vr text-white mx-1 d-none d-md-block"></div>
                    <div class="nav-item px-2">
                        <a href="html/service.php" class="text-white text-decoration-none">Services</a>
                    </div>
                    <div class="vr text-white mx-1 d-none d-md-block"></div>
                    <div class="nav-item px-2">
                        <a href="index.php?#contact" class="text-white text-decoration-none">Contact Us</a>
                    </div>
                    
                    <!-- Profile Dropdown -->
                    <div class="dropdown ms-3" id="profileSection">
                        <button class="btn dropdown-toggle p-0" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo isset($profilePic) ? $profilePic : 'pics/profile.jpg'; ?>" alt="Profile" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="html/profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li>
                                <form action="src/logout.php" method="POST">
                                    <button type="submit" class="dropdown-item" name="logoutButton">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Login Button -->
                    <div class="ms-3" id="loginSection">
                        <a href="html/login.php" class="btn btn-danger">Log In</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success" style="margin: 10% 5%; position: fixed;" ><?= $_SESSION['success_message']; ?></div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<!-- Floating chat icon -->
<div class="chatbot-icon" id="chatbot-icon">
    <img src="https://cdn-icons-png.flaticon.com/512/2099/2099192.png" alt="Chat"> 
</div>

<!-- Chat container -->
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
<script src="chatbot.js"></script>
<link rel="stylesheet" href="chatbot.css">

<!-- Hero Image (now comes after header) -->
<div class="aspect-ratio-container">
    <img src="pics/BarangayBaritan.png" alt="Barangay Baritan">
</div>

<script>
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

<!-- Rest of the content remains the same -->
<div class="container" style="margin-top: -45%">
    <div class="body-content display-4" style="font-weight: 500; color: white;">
        Barangay Baritan, <br> 
        Malabon City
        <div class="lead">
            "Bringing the barangay closer to its people, <br>
            building a stronger, more connected community every day."   
        </div>
    </div>
    <div>
        <a href="html/announcements.php"><button class="btn learn" style="margin-top:5%">
            Announcements
        </button></a>
    </div>
</div>

<!-- Rest of your existing HTML content... -->

</body>
</html>

<div class="infos container" style="margin-top: 20em; position: relative; background-color: white;"  id="learn">
    <div class="row">
        <span class="col-md-6 text-center display-6 pt-3" style="font-weight: 500;">
            Operating Hours
        </span>
        <span class="col-md-3 text-center pt-3" style="font-weight: 500;">
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

<div class="container text-center" style="width: 40%; margin-bottom: 4%; margin-top: 5%;">
    <div class="row">
        <div class="col" style="text-align: left;">
            <div class="display-5" style="font-size: 20px;">
                Got any Questions? <br>
                <div class="lead" style="color:#1C3A5B; font-weight: 500; font-size: 30px; padding-top: 10px;">
                    (+63) 942 423 5234
                </div>
            </div>
        </div>
        <div class="col" style="text-align: left; border-left: 3px solid black;">
            <div class="display-5" style="font-size: 20px;">
                Reach us out on <br>
                <div class="lead" style="color:#1C3A5B; font-weight: 500; font-size: 30px; padding-top: 9px;">
                    <a href="https://www.facebook.com/barangaybaritankmgs" style="color: #1C3A5B" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="30" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                    </svg>
                    <span style="font-size: 16px; margin-left: -5%;">Facebook</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <form action="mailto:jerichoyap27@gmail.com" method="post" enctype="text/plain">
        <div class="h4 form-group mt-4" style="font-weight: 600; text-align: left;">
            <label for="exampleFormControlTextarea1">Leave Your Concerns here</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Type your message here..."></textarea>
        </div>
        <div style="text-align: right;">
            <button type="submit" class="button learn ms-auto mt-2" id="contact">Submit</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('hidden.bs.modal', function () {
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    document.body.classList.remove('modal-open');
    document.body.style.paddingRight = '';
});
</script>

<!-- Deactivated Account Modal -->
<div class="modal fade" id="deactivatedModal" tabindex="-1" aria-labelledby="deactivatedModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-white">
        <h5 class="modal-title" id="deactivatedModalLabel">Account Deactivated</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
      </div>
      <div class="modal-body text-center">
        <p>Your account is currently deactivated. Please wait for the administrator to activate/reactivate your account.</p>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-secondary w-50" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isLoggedIn = <?php echo isset($_SESSION['User_Data']) ? 'true' : 'false'; ?>;
        
        if (isLoggedIn) {
            document.getElementById('profileSection').style.display = 'block';
            document.getElementById('loginSection').style.display = 'none';
        } else {
            document.getElementById('profileSection').style.display = 'none';
            document.getElementById('loginSection').style.display = 'block';
        }
    });
</script>

</body>
</html>