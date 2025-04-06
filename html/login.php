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

$errorMessage = ""; // Default empty message

if (isset($_SESSION['error_message'])) {
    $errorMessage = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Clear session message after reading
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
    </style>



</head>
<body>
  

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
                   <div style="padding:0% 4%;"> <a href="service.php">Services</a> </div>
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




    <div class="container content" style="background-color: rgba(255, 255, 255, 0.8); margin-top:15%; width:30%; border-radius:10px; padding-top:1%;padding-bottom:2%;">
    <form  action="../src/account.php" method="POST">
    <div class="container text-center mb-3" style=" font-weight: 600; color: #00264d; font-size: 28px;">
          Login
        </div>
        <!-- Email input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input name="userEmail" type="text" class="form-control" class="form-control" required placeholder="Enter Username"/>
            <label class="form-label" for="form2Example1">Username</label> <br>
          
           
        </div>

        <!-- Password input -->
        <div data-mdb-input-init class="form-outline ">
            <input type="password" name="password" type="password" class="form-control" required placeholder="Enter Password"/>
            <label class="form-label" for="form2Example2">Password</label>
        </div>
            <?php if (!empty($errorMessage)) : ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>

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
        <button name="loginButton" type="submit" class="btn text-white w-100" 
                style="background-color: #00264d; border-radius: 7px; padding: 10px; font-size: 16px;">
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
            <form action="../src/register.php"method="POST">
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
    </div>
  </div>



 
 
<!-- Account Selection Modal -->
<div class="modal fade" id="account" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Select Account</h5>
        
      </div>
      <div class="modal-body">
        <div class="row justify-content-center">
          <?php foreach ($familyMembers as $member): ?>
            <div class="col-6 d-flex flex-column align-items-center text-center">
              <a href="#" class="text-decoration-none text-dark" data-bs-dismiss="modal" 
                onclick="switchAccount('<?= $member['Resident_ID'] ?>', '<?= $member['Role'] ?>')">
                <img src="../pics/profile.jpg" alt="Profile" class="img-fluid rounded-circle"
                  style="width: 85px; transition: transform 0.3s ease-in-out;">
                <div class="lead mt-2" style="font-size: 16px;"><?= $member['Role'] ?></div>
                <div class="lead fw-bold"><?= $member['FirstName'] ?></div>
              </a>
            </div>
          <?php endforeach; ?>
          <!-- Add Account -->
          <!-- <div class="col-6 d-flex flex-column align-items-center text-center">
            <a href="#" class="text-decoration-none text-dark">
              <img src="../pics/profile.jpg" alt="Add Account" class="img-fluid rounded-circle"
                style="width: 85px; transition: transform 0.3s ease-in-out;">
              <div class="lead fw-bold mt-2">Add Account</div>
            </a>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</div>


<script>
 function switchAccount(residentID, role) {
    if (role.toLowerCase().trim() !== "head") {
        document.getElementById('residentID').value = residentID;
        console.log('Resident ID:', residentID);
        console.log('Role:', role);
        $('#accountPassword').modal('show');
    } else {
        console.log("Redirecting to switch_account.php for Head...");

        // Send an AJAX request to `switch_account.php` for validation
        fetch('switch_account.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ Resident_ID: residentID })
        })
        .then(response => response.text()) 
        .then(data => {
            console.log("Server Response:", data);  // Debugging response
            if (data.includes("Error")) {
                alert("An error occurred: " + data);
            } else {
                window.location.href = '../index.php';  // Redirect if successful
            }
        })
        .catch(error => console.error("AJAX Error:", error));
    }
}

</script>




<!-- Password Modal -->
<div class="modal fade" id="accountPassword" tabindex="-1" aria-labelledby="accountPasswordLabel" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-white">
        <h5 class="modal-title" id="accountPasswordLabel">Enter Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
      </div>
      <div class="modal-body text-center">
        <form id="passwordForm" action="../src/switch_account.php" method="POST">
          <input type="hidden" id="residentID" name="Resident_ID"> <!-- Hidden input to store ID -->
          <div class="mt-3" style="text-align:left;">
            <label class="form-label" for="passwordMember">Password</label>
          </div>
          <input type="password" name="passwordMember" id="passwordMember" class="form-control" required placeholder="Enter Password"/>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-secondary w-25" data-bs-toggle="modal" 
        data-bs-target="#account">Close</button>
        <button type="submit" form="passwordForm" class="btn btn-success w-25 mt-2">Login</button>
      </div>
    </div>
  </div>
</div>








</body>
</html>
