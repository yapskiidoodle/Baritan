<!DOCTYPE html>
<html lang="en">
<head>
<?php
require '../src/connect.php'; // Use 'include' or 'require' to load the file
require '../src/account.php';
// ["Family_Name_ID"]=> string(13) "FAMBAR2025003"



if (isset($_SESSION['deactivated']) && $_SESSION['deactivated'] === true) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('deactivatedModal'));
            myModal.show();
        });
    </script>";
    unset($_SESSION['deactivated']); // Clear the session variable
}

if (!empty($_SESSION['show_modal'])) {
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                var myModal = new bootstrap.Modal(document.getElementById("account"));
                myModal.show();
            });
          </script>';
    unset($_SESSION['show_modal']);
}

$FirstName = $_SESSION['User_Data']['FirstName'] ?? '';
$familyMembers = []; // Initialize an empty array
$familyID = $_SESSION['User_Data']['Family_Name_ID'] ?? '';

if ($familyID) {
    $query = "SELECT r.Resident_ID, r.FirstName, r.Role 
              FROM residents_information_tbl r
              LEFT JOIN family_name_tbl f ON r.Family_Name_ID = f.Family_Name_ID
              LEFT JOIN account_tbl acc ON f.Account_ID = acc.Account_ID
              LEFT JOIN account_setting_tbl a ON r.Resident_ID = a.Resident_ID
              WHERE r.Family_Name_ID = ? 
              AND (r.Role = 'Head' OR a.Profile_ID IS NOT NULL)";
    
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("🔥 SQL Error: " . $conn->error); // Debugging output
    }
    
    $stmt->bind_param("s", $familyID);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $familyMembers[] = $row;
    }
}

if (isset($_GET['error'])) {
  $errorType = $_GET['error'];
  switch ($errorType) {
      case 'application':
          $_SESSION['error_message'] = "Please log in first to access Application module";
          break;
      case 'reservation':
          $_SESSION['error_message'] = "Please log in first to access the Reservation module";
          break;
      case 'barangayid':
          $_SESSION['error_message'] = "Please log in first to access Barangay ID module";
          break;
  }
}


// Initialize variables
$errorMessage = "";
$disableButton = false;
$remainingTime = isset($_SESSION['remaining_time']) ? $_SESSION['remaining_time'] : 0;  // Get remaining time

// Check for too many failed attempts and disable the button if needed
if (isset($_SESSION['try']) && $_SESSION['try'] >= 5) {
    // If attempts are >= 5, disable the button
    $disableButton = true;
    $errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : "";
} elseif (isset($_SESSION['error_message'])) {
    // If there's an error message in session, display it
    $errorMessage = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Clear the error message after displaying
}

if (!isset($_SESSION['first_failed_time'])) {
  $_SESSION['first_failed_time'] = time(); // Set it for the first failed attempt
}


?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="pics/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" href="../design.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


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
    a:hover img {
    transform: scale(1.1);
    transition: transform 0.2s ease-in-out;
    }
    
    li a {
  color: #017fb1;
}


.password-wrapper {
  position: relative;
}

.password-wrapper input {
  padding-right: 40px; /* space for the eye icon */
}

.password-wrapper .toggle-password {
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  border: none;
  background: none;
  cursor: pointer;
  padding: 0;
}

.password-wrapper .toggle-password i {
  font-size: 1.1rem;
  color: #6c757d;
}
    </style>
  


</head>
<body>
  

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



    <div class="container content" style="background-color: rgba(255, 255, 255, 0.8); margin-top:5%; width:30%; border-radius:10px; padding-top:1%;padding-bottom:2%;">
    <form  action="../src/account.php" method="POST">
    <div class="container text-center mb-3" style=" font-weight: 600; color: #00264d; font-size: 28px;">
          Login
        </div>
        <!-- Email input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input name="userEmail" type="text" class="form-control" class="form-control" required placeholder="Enter Username" maxlength="25"/>
            <label class="form-label" for="form2Example1">Username</label> <br>
          
           
        </div>

        <!-- Password input -->
        <div data-mdb-input-init class="form-outline ">
          <div class="password-wrapper">
            <input type="password" name="password" id="password" class="form-control" required placeholder="Enter Password" maxlength="16" />
            <button type="button" class="toggle-password" id="togglePassword">
              <i class="bi bi-eye" id="eyeIcon"></i>
            </button>
          </div>
            <label class="form-label" for="form2Example2">Password</label>
        </div>

        <script>
          document.getElementById("togglePassword").addEventListener("click", function () {
            const input = document.getElementById("password");
            const icon = document.getElementById("eyeIcon");

            const isHidden = input.type === "password";
            input.type = isHidden ? "text" : "password";
            icon.className = isHidden ? "bi bi-eye-slash" : "bi bi-eye";
          });
        </script>

     

            
        <?php if (!empty($errorMessage)) : ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

            
        <!-- Countdown message if login button is disabled -->
        <div id="countdown" class="alert alert-info mt-3" style="display: none;"></div>
        <script>
    // Function to update the remaining time on the frontend
    function updateTime() {
        var firstFailedTime = <?php echo isset($_SESSION['first_failed_time']) ? $_SESSION['first_failed_time'] : '0'; ?>; // Get the PHP session time
        var currentTime = Math.floor(Date.now() / 1000); // Get the current time in seconds (JavaScript time)
        var remainingTime = 60 - (currentTime - firstFailedTime); // Calculate remaining time

        var countdownElement = document.getElementById("countdown");

        if (remainingTime > 0) {
            countdownElement.innerHTML = "You can try again in " + remainingTime + " seconds.";
            setTimeout(updateTime, 1000);  // Update every second
        } else {
            countdownElement.innerHTML = "";
            document.getElementById("loginButton").disabled = false; // Re-enable the button when time is up
            <?php unset($_SESSION['error_message']); ?>
        }
    }

    // Call the function to start the countdown
    window.onload = function() {
        // Only start the countdown if the button is disabled
        if (<?php echo $disableButton ? 'true' : 'false'; ?>) {
            document.getElementById("countdown").style.display = "block"; // Show countdown element
            updateTime(); // Start the countdown
        }
    }
</script>



            
        <!-- 2 column grid layout for inline styling -->
        <div class="row  mb-2">
            <div class="col d-flex ps-3 mt-3">
                <!-- Checkbox -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                    <label class="form-check-label" for="form2Example31"> Remember me </label>
                </div>
            </div>

            
        </div>
            
        <!-- Submit button -->
        <div class="text-center ">
        <button id="loginButton" name="loginButton" type="submit" class="btn text-white w-100" 
            style="background-color: #00264d; border-radius: 7px; padding: 10px; font-size: 16px;"
            <?php echo $disableButton ? 'disabled' : ''; ?>>
            Login
        </button>
       
              
        </div>
        <!-- Register buttons -->
        <div class="text-center" style="margin-top: 10%;">
            <p class="my-3" style="margin-bottom:0px;">Not a member? 

            <a href="#" 
            style="color:rgb(85, 127, 168);"
            data-bs-toggle="modal" 
            data-bs-target="#registerModal" 
            data-bs-dismiss="modal">
            Signup Now!
            </a>

            </p>
         

          </form>   
        </div>
    
    </div>
    

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
            <ol >
  <li>
    <h3>Terms of Use</h3>
    <ul>
      <li>The terms and conditions set forth in this document govern the use of all services offered by Barangay Baritan, Malabon.</li>
      <li>By accessing or using any of our services, you agree to comply with these terms.</li>
      <li>Failure to comply with the terms may result in restricted access or termination of services.</li>
      <li>For more information, refer to the <a href="https://www.officialgazette.gov.ph/2012/07/23/republic-act-no-10173/" target="_blank">Data Privacy Act of 2012</a> for privacy guidelines.</li>
    </ul>
  </li>
  <li>
    <h3>Intellectual Property Rights</h3>
    <ul>
      <li>All content, logos, trademarks, and materials provided through the Barangay Baritan Information Management System are protected by intellectual property laws.</li>
      <li>Unauthorized use or reproduction of materials without prior written consent from Barangay Baritan is prohibited.</li>
      <li>Barangay Baritan retains ownership over the system’s software and data provided to users.</li>
      <li>For more information, refer to the <a href="https://www.wipo.int/treaties/en/ip/ptoc/index.html" target="_blank">Intellectual Property Code of the Philippines</a> (Republic Act No. 8293).</li>
    </ul>
  </li>
  <li>
    <h3>Prohibited Activities</h3>
    <ul>
      <li>Engaging in any activity that disrupts or harms the operation of the Barangay Baritan Information Management System is prohibited.</li>
      <li>Users must not upload, share, or distribute any malicious content or engage in hacking activities.</li>
      <li>Any use of the system for fraudulent activities or to violate local laws is strictly prohibited.</li>
      <li>For more information on online security, refer to the <a href="https://www.officialgazette.gov.ph/2012/04/16/republic-act-no-10175/" target="_blank">Cybercrime Prevention Act of 2012</a>.</li>
    </ul>
  </li>
  <li>
    <h3>Termination Clause</h3>
    <ul>
      <li>Barangay Baritan reserves the right to suspend or terminate access to the system if users violate the terms outlined in this agreement.</li>
      <li>Users may request termination of their accounts in accordance with the Barangay Baritan policies.</li>
      <li>Upon termination, all personal data and access rights may be revoked, subject to applicable laws.</li>
      <li>For more information on termination and rights of the parties, refer to the <a href="https://www.officialgazette.gov.ph/1991/06/11/republic-act-no-7641/" target="_blank">Labor Code of the Philippines</a> (Book VI: Termination of Employment).</li>
    </ul>
  </li>
  <li>
    <h3>Governing Law</h3>
    <ul>
      <li>These terms are governed by and construed in accordance with the laws of the Philippines.</li>
      <li>Any disputes arising from the use of the Barangay Baritan Information Management System will be resolved under the jurisdiction of the courts in Malabon City.</li>
      <li>Users agree to resolve any disputes amicably before resorting to legal actions.</li>
      <li>For a comprehensive guide to Philippine law, refer to the <a href="https://www.officialgazette.gov.ph/constitution/" target="_blank">1987 Philippine Constitution</a>.</li>
    </ul>
  </li>
</ol>

              </div>
        </div>
        <div class="modal-footer d-flex justify-content-between align-items-center">
            <form action="../src/register.php"method="POST">
               
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="termsCheckbox">
                            <label class="form-check-label" for="termsCheckbox">
                              I have read and agree to the <br>  <a href="#" style="text-decoration: none;color: #94c8ff; ">Terms and Conditions</a>
                            </label>
                          </div>
                          
                    </div>
                    <div class="col text-center" >
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.reload();">Close</button>
                        <button type="submit" class="btn btn-primary" id="submitBtn" disabled style="background-color: #1C3A5B;" >I Accept</button>
                    
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
                        window.location.href = "register.php";
                    });
                </script>
            </form>
                
 
     
    </div>
  </div>


<!-- Account Selection Modal -->
<div class="modal fade" id="account" tabindex="-1" aria-labelledby="accountModalLabel" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="accountModalLabel">Select Account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center">
          <?php 
          // Sort family members - Head first
          usort($familyMembers, function($a, $b) {
              if ($a['Role'] === 'Head') return -1;
              if ($b['Role'] === 'Head') return 1;
              return 0;
          });
          
          foreach ($familyMembers as $member): 
            // Get profile picture path safely
            $profilePic = isset($member['Pic_Path']) && !empty($member['Pic_Path']) 
              ? '../resident_folder/profile/' . $member['Pic_Path']
              : '../pics/profile.jpg';
              
            // Verify the image file exists
            $imagePath = (isset($member['Pic_Path']) && file_exists('../resident_folder/profile/' . $member['Pic_Path']))
              ? '../resident_folder/profile/' . $member['Pic_Path']
              : '../pics/profile.jpg';
          ?>
            <div class="col-6 d-flex flex-column align-items-center text-center mb-4">
              <a href="#" class="text-decoration-none text-dark account-select" 
                 data-resident-id="<?= htmlspecialchars($member['Resident_ID']) ?>"
                 data-role="<?= htmlspecialchars($member['Role']) ?>"
                 data-is-head="<?= $member['Role'] === 'Head' ? 'true' : 'false' ?>"
                 data-bs-dismiss="modal">
                <img src="<?= $imagePath ?>" 
                     alt="<?= htmlspecialchars($member['FirstName']) ?>" 
                     class="img-fluid rounded-circle profile-img border border-2"
                     style="width: 85px; height: 85px; object-fit: cover; transition: transform 0.3s ease;"
                     onerror="this.onerror=null;this.src='../pics/profile.jpg';">
                <div class="mt-2">
                  <div class="fw-bold">
                    <?= htmlspecialchars($member['FirstName']) ?>
                    <?= isset($member['LastName']) ? ' ' . htmlspecialchars($member['LastName']) : '' ?>
                  </div>
                  <div class="text-muted small"><?= htmlspecialchars($member['Role']) ?></div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
// Account selection handler
document.querySelectorAll('.account-select').forEach(item => {
  item.addEventListener('click', function(e) {
    e.preventDefault();
    const residentId = this.getAttribute('data-resident-id');
    const role = this.getAttribute('data-role');
    const isHead = this.getAttribute('data-is-head') === 'true';
    
    if (isHead) {
      // Directly switch for Head without password
      switchAccount(residentId, role);
    } else {
      // Show password modal for non-Head members
      document.getElementById('residentID').value = residentId;
      const passwordModal = new bootstrap.Modal(document.getElementById('accountPassword'));
      passwordModal.show();
    }
  });
});

// Hover effect for profile images
document.querySelectorAll('.profile-img').forEach(img => {
  img.addEventListener('mouseenter', function() {
    this.style.transform = 'scale(1.1)';
  });
  img.addEventListener('mouseleave', function() {
    this.style.transform = 'scale(1)';
  });
});

function switchAccount(residentId, role) {
  // Submit form via AJAX or redirect
  fetch('../src/switch_account.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `Resident_ID=${encodeURIComponent(residentId)}`
  })
  .then(response => {
    if (response.redirected) {
      window.location.href = response.url;
    } else {
      return response.text().then(text => {
        if (text.includes('Error')) {
          alert(text);
        } else {
          window.location.reload();
        }
      });
    }
  })
  .catch(error => console.error('Error:', error));
}
</script>

<!-- Password Modal -->
<div class="modal fade" id="accountPassword" tabindex="-1" aria-labelledby="accountPasswordLabel" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-white bg-primary">
        <h5 class="modal-title" id="accountPasswordLabel">Enter Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
      </div>
      <div class="modal-body text-center">
        <form id="passwordForm" action="../src/switch_account.php" method="POST">
          <input type="hidden" id="residentID" name="Resident_ID">
          <div class="mb-3 text-start">
            <label for="passwordMember" class="form-label">Password</label>
            <input type="password" name="passwordMember" id="passwordMember" 
                   class="form-control" required placeholder="Enter Password"
                   autocomplete="current-password">
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success">Login</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>






</body>
</html>
