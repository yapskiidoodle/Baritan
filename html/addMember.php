<!DOCTYPE html>
<html lang="en">
<head>
<?php

require '../src/connect.php'; // Use 'include' or 'require' to load the file
require '../src/account.php'; // has the session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ensure accountType exists before using it
    $accountType = $_POST['accountType'] ?? '';

    // Set visibility flag
    $showPasswordSection = ($accountType === 'with');
} else {
    echo "Form not submitted!";
}


// Check if the account type was passed from the form
$accountType = isset($_POST['accountType']) ? $_POST['accountType'] : '';

// Initialize a flag to control password section visibility
$showPasswordSection = ($accountType === 'with');
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../pics/logo.png">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../design.css"> 

    <title>Registers</title>
    <style>
        body {
            background-image: url('../pics/BarangayBaritan.png'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed; 

        }
        .modal {
            z-index: 1055 !important;
        }
        .modal-backdrop {
            z-index: 1045 !important;
        }
        /* Custom Styles for the Steps Graphic */
    .step-circle {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-left: 37%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .step-text {
      text-align: left;
    }

    hr {
      height: 3px;
      background-color: #1C3A5B /* Bootstrap primary color */
    }

    .active {
      background-color: #1C3A5B; /* Bootstrap primary color */
    }

    .inactive {
      background-color: gray;
    }

    .button {
    margin: -5% 0% 0% 1%;
    padding: 1.2% 3%;
    font-size: 20px;
    color: white;
    border-radius: 0%;
    background-color: #1C3A5B;
    
    }   
    </style>

</head>
<body>



    <!--header-->
    <div class="container-fluid" style="background-color:#1C3A5B;color: white;padding: 1%; width: 100%;  ">  
        <div class="row" >    
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
                       <a href="">About Us</a>
                   </div>
                   <div class="vr"></div>
                   <div style="padding:0% 4%;">
                       <a href="service.php">Services</a>
                   </div>
                   <div class="vr"></div>
                   <div style="padding:0% 4%;">
                       <a href="../index.php?#contact"  >Contact Us</a>
                   </div>
                   <div class="vr"></div>
                   <div class="dropdown" id="profile" name="profile" hidden>
                        <button class="btn dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../pics/profile.jpg" alt="" style="border-radius: 50%; width: 30px;">
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                            <!--<li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li> -->
                            <li><a class="dropdown-item" href="profile.php" name="logoutButton"><i class="fas fa-sign-out-alt"></i> Profile</a></li>
                            <li><form action="../src/logout.php" method="POST"><button class="dropdown-item" href="index.php" name="logoutButton"><i class="fas fa-sign-out-alt"></i> Logout</button></li></form>

                        </ul>
                    </div>
                   <div id="start" name="start">
                        <button id="login" class="btn btn-danger ms-2" style="margin-top: -8.6%; width: 100%;">Log In</button>
                   </div>
               </div>
           </div>
        </div>
    </div>
    <!--END HEADER-->


    <div class="container mt-5 text-center w-75" style=" background-color: white; padding: 3% 0% 5% 0%; margin-bottom:5%;"> 
        <div class="display-4 " style="font-weight: 700;">Profile Registration</div>
        <div class="container w-75 mt-5">

       
            <div class=" row justify-content-center align-items-center mt-4" >
              <div class="col text-center" >
                <div class="step-circle inactive" >
                    1
                </div>
                <div class="h6">Personal</div>
              </div>
              <div class="col"><hr></div>
              
              <div class="col"><hr></div>
              <div class="col">
                <div class="step-circle inactive" >
                    3
                </div>
                <div class="h6">Proof of Identity</div>
              </div>
             
            </div>
   
            <form id="registrationForm" action="../src/addMemberLogic.php" method="POST" enctype="multipart/form-data">
          <!-- Login Details -->
            <div class="container " style="text-align: left;">


                <div class="tab d-none" style="background-color: white;">
                   


                    <!-- Password Section (only shows if 'with' account type is selected) -->
                                        
                    <div class="pass <?php echo $showPasswordSection ? '' : 'd-none'; ?>">
                        <div class="h4 mt-5 text-center" style="font-weight: 700;">Login Details</div>

                        <div class="form-group mt-4" style="font-weight: 800;">
                            <label for="exampleInputPassword1">Enter Password </label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" 
                            <?php echo ($accountType === 'with') ? 'required' : ''; ?>>
                            <small id="emailHelp" class="form-text text-muted">(must be 8 characters long and contain Capital letters and special character).</small>
                        </div>
                        
                        <div class="form-group mt-4" style="font-weight: 800;">
                            <label for="exampleInputPassword1">Re-Enter Password</label>
                            <input type="password" class="form-control" id="rePassword" placeholder="Password" 
                            <?php echo ($accountType === 'with') ? 'required' : ''; ?>>

                        </div>
                    </div>


                    <!--  Personal Information -->
                      <div class="h4 mt-5 text-center" style="font-weight: 700;">Personal Information</div>
                      <div class="row">
                        <div class="col-md-12 ">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1" >First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="ex. Juan" required>
                              </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName"placeholder="ex. Dela Cruz" required>
                              </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Middle Initial</label>
                                <input type="text" class="form-control" id="middleInitial" name="middleInitial" placeholder="ex. Banaga">
                              </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Suffix</label>
                                <input type="text" class="form-control" id="suffix" name="suffix" placeholder="ex. Sr. Jr."  >
                              </div>
                        </div>
                      </div>


                      <div class="row">
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Sex</label>
                                <select class="form-control" id="sex" name="sex" required>
                                    <option value="" selected disabled>Choose an option</option>
                                    <option value="Male">Male</option>
                                    <option  value="Female">Female</option>
        
                                  </select>
                              </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Date of Birth</label>
                                <input type="date" class="form-control" id="birthday" name="birthday" placeholder="ex. Dela Cruz" required>
                              </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Role</label>
                                <select class="form-control" id="role" name="role" required onchange="toggleOtherRoleInput()">
                                    <option value="" selected disabled>Choose an option</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Father">Father</option>
                                    <option value="Son">Son</option>
                                    <option value="Daughter">Daughter</option>
                                    <option value="Others">Others</option>
                                </select>
                              </div>

                              <div class="form-group mt-4 d-none" id="otherRoleGroup">
                                <label for="otherRole">Specify Role</label>
                                <input type="text" class="form-control" id="otherRole" name="otherRole" placeholder="Enter role">
                            </div>
                            
                            <script>
                                function toggleOtherRoleInput() {
                                    let roleSelect = document.getElementById("role");
                                    let otherRoleGroup = document.getElementById("otherRoleGroup");
                                    let otherRoleInput = document.getElementById("otherRole");

                                    if (roleSelect.value === "Others") {
                                        otherRoleGroup.classList.remove("d-none");
                                        otherRoleInput.required = true;
                                    } else {
                                        otherRoleGroup.classList.add("d-none");
                                        otherRoleInput.required = false;
                                        otherRoleInput.value = ""; // Clear input when hidden
                                    }
                                }
                            </script>
                        </div>
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="email" name="email"aria-describedby="emailHelp" placeholder="example@gmail.com" required>
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputEmail1">Contact Number</label>
                        <input type="tel" class="form-control" id="contact" name="contact" 
                            placeholder="09XXXXXXXXX" 
                            pattern="09[0-9]{9}" maxlength="11">
                            <div class="invalid-feedback">Must be exactly 11 digits (09XXXXXXXXX).</div>
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputEmail1">Occupation</label>
                        <input type="text" class="form-control" id="occupation" name="occupation" aria-describedby="emailHelp" placeholder="" required>
                      </div>
                      <div class="row">
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Religion</label>
                                <select class="form-control" id="religion" name="religion" required>
                                    <option value="" selected disabled>Choose an option</option>
                                    <option value="Roman Catholic" >Roman Catholic</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Jehovahs Witnesses">Jehovah’s Witnesses</option>
                                    <option value="Christian">Christian</option>
                                    <option value="Iglesia ni Cristo">Iglesia ni Cristo (INC)</option>
                                    
                                  </select>
                              </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Civil Status</label>
                                <select class="form-control" id="civilStatus" name="civilStatus" required>
                                  <option value="" selected disabled>Choose an option</option>
                                  <option value="Single">Single</option>
                                  <option value="Married">Married</option>
                                  <option value="Widowed">Widowed</option>
                                  <option value="Divorced">Divorced</option>
                                  <option value="Annulled">Annulled</option>
                                  <option value="Separated">Separated</option>
                                </select>
                              </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800; ">
                                <label for="exampleInputPassword1" required>Eligibility Status</label>
                                <select class="form-control" id="eligibilityStatus" name="eligibilityStatus" required>
                                  <option value="" selected disabled>Choose an option</option>
                              
                                  <option value="pwd">PWD (Person with Disability)</option>
                                  <option value="single parent">Single Parent</option>
                                  <option value="employed">Employed</option>
                                  <option value="unemployed">Unemployed</option>
                                  <option value="student">Student</option>
                                  <option value="senior citizen">Senior Citizen</option>
                                </select>
                              </div>
                        </div>
                      </div>
                      <br>


            <!-- Emergency Contact -->
                      <div class="h4 mt-5 text-center" style="font-weight: 700;">Emergency Contact Information</div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Emergency Contact Person</label>
                        <input type="text" class="form-control" id="emergencyPerson" name="emergencyPerson"placeholder="" required>
                      </div>

                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="emergencyContact">Emergency Contact Number</label>
                        <input type="tel" class="form-control" id="emergencyContact" name="emergencyContact" 
                            placeholder="09XXXXXXXXX" required 
                            pattern="09[0-9]{9}" maxlength="11">
                        <div class="invalid-feedback">Must be exactly 11 digits (09XXXXXXXXX).</div>
                    </div>
                    <script>
                      function enforcePhoneValidation(id) {
                          var inputField = document.getElementById(id);
                          
                          inputField.addEventListener("input", function() {
                              var input = this.value;

                              // Remove any non-digit characters
                              this.value = input.replace(/\D/g, "");

                              // Enforce exactly 11-digit rule
                              if (this.value.length === 11) {
                                  this.setCustomValidity(""); // ✅ Valid input
                              } else {
                                  this.setCustomValidity("Emergency contact must be exactly 11 digits."); // ❌ Error message
                              }
                          });
                      }

                      // Apply validation to both fields
                      enforcePhoneValidation("contact");
                      enforcePhoneValidation("emergencyContact");
                    </script>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Relationship</label>
                        <input type="text" class="form-control" id="emergencyRelation" name="emergencyRelation" placeholder="" required>
                      </div>

                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleFormControlTextarea1">Address</label>
                        <textarea class="form-control" id="emergencyAddress" name="emergencyAddress"rows="3" required></textarea>
                      </div>

                    <!-- proof of identity -->
                </div>
                <div class="tab d-none">
                    <div class="h4 mt-5 text-center" style="font-weight: 700">Proof of Identity</div>

                    <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Type of Identification Card (ID)</label>
                        <select class="form-control" id="idType" name="idType" required>
                            <option value="" selected disabled>Choose an option</option>
                            <option value="passport">Passport</option>
                            <option value="drivers_license">Driver's License</option>
                            <option value="philhealth">PhilHealth ID</option>
                            <option value="postal_id">Postal ID</option>
                            <option value="national_id">National ID</option>
                            <option value="voters_id">Voter's ID</option>
                        </select>
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputEmail1">Upload Identification Card</label>
                        <div class="lead mt-4" style="font-size: 16px;">Front Side</div>
                        <input type="file" class="form-control" id="idFront"name="idFront" required accept="image/*">
                        <div class="lead mt-4" style="font-size: 16px;">Back Side</div>
                        <input type="file" class="form-control" id="idBack" name="idBack" required accept="image/*">
                      </div>

                      <div class="form-group mt-5" style="font-weight: 800;">
                        <label for="exampleInputEmail1">Upload 2x2 Picture</label>
                        <div class="lead mt-4" style="font-size: 16px;">(With White Background)</div>
                        <input type="file" class="form-control" id="2x2pic" name="2x2pic" required accept="image/*">
                        
                      </div>
                </div>

                <div class="d-flex mt-5">
                    <button type="button" id="back_button"  onclick="back()" class="button  mt-2 ">Previous</button>
                    <button type="button" id="next_button" class="button ms-auto mt-2" onclick="next()" >Next</button>
                </div>


                
            </div>

          </div>

        </form>
    </div>
    


      </div>

      <div class="modal fade" id="confirmation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Are you sure?
            </div>
            <div class="modal-footer">
             <div class="me-auto">
                <button type="button" class="learn mt-2"  style="padding: 5px 15px; background-color: rgb(162, 164, 167);" data-bs-dismiss="modal">Close</button>
             </div>
              <button type="button" class="learn mt-2"  style="padding: 5px 15px;" data-bs-target="#exampleModal" data-bs-toggle="modal" >Yes</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" >
            
          <div class="modal-content" style="width: 150%;">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="text-center">
            <div class="h4">Thank you for the feedback</div>
                <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55" fill="currentColor" class="bi bi-check-circle-fill " viewBox="0 0 16 16" > 
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" style="color: rgb(93, 180, 5);"/>
                  </svg>
                  <div class="lead">
                    This would be first reviewed by the officials
                  </div>
              </div>
            </div>
            <div class="modal-footer">
               <div class="text-center mx-auto">
                    <button type="button" class="learn" data-bs-toggle="modal"  style="padding: 5px 15px;" onclick="submitForm()">Okay</button>
               </div>
             
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

    var current = 0;
var tabs = $(".tab");
var tabs_pill = $(".step-circle");

// Initial load
loadFormData(current);

function loadFormData(n) {
    $(tabs_pill[n]).addClass("active").removeClass("inactive"); 
    $(tabs[n]).removeClass("d-none");

    // Handle Back button visibility
    if (n === 0) {
        $("#back_button").addClass("d-none"); // Hide Back button on first tab
    } else {
        $("#back_button").removeClass("d-none"); // Show Back button
    }

    // Handle Next button text and attributes
    if (n === tabs.length - 1) {
        $("#next_button")
            .text("Submit")
            .removeAttr("onclick")
            .attr("data-bs-toggle", "modal")
            .attr("data-bs-target", "#confirmation");
    } else {
        $("#next_button")
            .attr("type", "button")
            .text("Next")
            .attr("onclick", "next()");
    }
}

function next() {
    var firstEmptyInput = validateInputs(); // Get the first unfilled input
    
    if (firstEmptyInput) {
        firstEmptyInput.focus(); // Move to first unfilled required input
        return; // Stop from moving to the next tab
    }

    $(tabs[current]).addClass("d-none");
    $(tabs_pill[current]).addClass("inactive");

    current++;
    loadFormData(current);
}

function back() {
    $(tabs[current]).addClass("d-none");
    $(tabs_pill[current]).addClass("inactive");

    $("#next_button").removeAttr("data-bs-toggle data-bs-target");

    current--;
    loadFormData(current);
}

function submitForm() {
    document.getElementById("registrationForm").submit();
}

// ✅ Validate required inputs and return the first empty one
function validateInputs() {
    var firstInvalid = null;
    var generalRegex = /[^a-zA-Z0-9ñ ]/; // Blocks special characters except space (for general fields)
    var lastNameRegex = /^[a-zA-Zñ -]+$/; // ✅ Allows letters, spaces, and hyphens for last name
    var emailRegex = /[^a-zA-Z0-9@.]/; // Allows only letters, numbers, @, and .
    var passwordRegex = /^(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/; // Password: 8+ chars, 1 uppercase, 1 special char

    $(tabs[current]).find("input[required], select[required]").each(function () {
        var value = $(this).val() ? $(this).val().trim() : ''; // ✅ Fix: Avoid `.trim()` on null
        var inputType = $(this).attr("type");
        var inputId = $(this).attr("id");
        var isEmail = inputType === "email";
        var isDate = inputType === "date";
        var isPassword = inputId === "password" || inputId === "rePassword";

        // Empty input field
        if (!value) {
            showError(this, "This field is required.");
            if (!firstInvalid) firstInvalid = this;
        } 
        // Email validation
        else if (isEmail && emailRegex.test(value)) {
            showError(this, "Only letters, numbers, @, and . are allowed.");
            if (!firstInvalid) firstInvalid = this;
        } 
        // Password validation
        else if (inputId === "password" && !passwordRegex.test(value)) {
            showError(this, "Password must be at least 8 characters, contain an uppercase letter, and a special character.");
            if (!firstInvalid) firstInvalid = this;
        }
        // Last name validation (✅ Allows hyphens)
        else if (inputId === "lastName" && !lastNameRegex.test(value)) {
            showError(this, "Only letters, spaces, and hyphens are allowed.");
            if (!firstInvalid) firstInvalid = this;
        }
        // General fields validation (Prevents special characters)
        else if (!isEmail && !isDate && !isPassword && inputId !== "lastName" && inputId !== "famName" && generalRegex.test(value)) {
            showError(this, "Special characters are not allowed.");
            if (!firstInvalid) firstInvalid = this;
        } 
        // Password confirmation validation
        else if (inputId === "rePassword") {
            validatePasswords();
        }
        // Valid input
        else {
            removeError(this);
        }
    });

    return firstInvalid;
}

function validatePasswords() {
    var password = $("#password").val();
    var rePassword = $("#rePassword").val();
    var rePasswordField = $("#rePassword");

    if (!password || !rePassword) return true; // If empty, don't block

    if (password === rePassword) {
        removeError(rePasswordField);
        return true;
    } else {
        showError(rePasswordField, "Passwords do not match.");
        return false;
    }
}


// ✅ Show error message
function showError(element, message) {
    $(element).addClass("is-invalid").removeClass("is-valid");
    $(element).next(".invalid-feedback").remove();
    $(element).after('<div class="invalid-feedback">' + message + '</div>');
}

// ✅ Remove error message
function removeError(element) {
    $(element).removeClass("is-invalid").addClass("is-valid");
    $(element).next(".invalid-feedback").remove();
}

// ✅ Live validation
$(document).on("input change", "input[required], select[required]", function () {
    var inputId = $(this).attr("id");

    removeError(this);

    if (inputId === "password" || inputId === "rePassword") {
        validatePasswords();
    }
    if (inputId === "emergencyContact") {
        var phoneNumber = $(this).val();
        var phonePattern = /^09[0-9]{9}$/;  // Matches exactly 11 digits starting with 09

        if (!phonePattern.test(phoneNumber)) {
            showError(this, "Must be exactly 11 digits (09XXXXXXXXX).");
        }
    }

    if (inputId === "contact") {
        var phoneNumber = $(this).val();
        var phonePattern = /^09[0-9]{9}$/;  // Matches exactly 11 digits starting with 09

        if (!phonePattern.test(phoneNumber)) {
            showError(this, "Must be exactly 11 digits (09XXXXXXXXX).");
        }
    }
});

</script>



</body>
</html>