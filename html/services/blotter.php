<?php
require '../../src/connect.php'; // Use 'include' or 'require' to load the 
require '../../src/account.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="icon" type="image/x-icon" href="../../pics/logo.png">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../design.css"> 

    <title>Register</title>
    <style>
        body {
            background-image: url('../../pics/BarangayBaritan.png'); 
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

<?php 
        $profilePic = isset($_SESSION['User_Data']['Pic_Path']) && !empty($_SESSION['User_Data']['Pic_Path']) 
            ? '../../resident_folder/profile/' . $_SESSION['User_Data']['Pic_Path'] 
            : '../../pics/profile.jpg';
        ?>  
<!-- Header -->
<header class="container-fluid  text-white py-2 px-3" style="background-color: #1C3A5B;">
    <div class="row align-items-center">
        <!-- Logo -->
        <div class="col-auto">
            <img src="../../pics/logo.png" alt="Barangay Baritan Logo" class="img-fluid" style="max-width: 75px;">
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
                        <a href="../../index.php" class="text-white text-decoration-none">Home</a>
                    </div>
                    <div class="vr text-white mx-1 d-none d-md-block"></div>
                    <div class="nav-item px-2">
                        <a href="../about.php" class="text-white text-decoration-none">About Us</a>
                    </div>
                    <div class="vr text-white mx-1 d-none d-md-block"></div>
                    <div class="nav-item px-2">
                        <a href="../service.php" class="text-white text-decoration-none">Services</a>
                    </div>
                    <div class="vr text-white mx-1 d-none d-md-block"></div>
                    <div class="nav-item px-2">
                        <a href="../../index.php?#contact" class="text-white text-decoration-none">Contact Us</a>
                    </div>
                    
                    <!-- Profile Dropdown -->
                    <div class="dropdown ms-3" id="profileSection" hidden>
                        <button class="btn dropdown-toggle p-0" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo isset($profilePic) ? $profilePic : '../../pics/profile.jpg'; ?>" alt="Profile" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="../profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li>
                                <form action="../../src/logout.php" method="POST">
                                    <button type="submit" class="dropdown-item" name="logoutButton">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Login Button -->
                    <div class="ms-3" id="loginSection">
                        <a href="../login.php" class="btn btn-danger">Log In</a>
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

    <div class="container  text-center w-75" style=" background-color: white; padding: 3% 0% 5% 0%; margin-bottom: 5%; margin-top: 5%;"> 
    
        <div class="display-4 " style="font-weight: 700;">Blotter Form</div>
        <div class="lead">All section as marked <s style="color:red">*</s> are to be completed </div>
        <div class="lead" style="font-size: 16px;">All Personal Details remains <b>CONFIDENTIAL</b></div>
        <div class="container w-75 mt-5">

            <form action="../../src/blotterLogic.php" method="POST" id="blotterForm">

      
            <div class="container " style="text-align: left;">


                <div class="tab " style="background-color: white;">
                    <div class="col w-100">
                        <div class="form-group mt-4" style="font-weight: 800;">
                            <label for="exampleInputPassword1">Name of Person making the Complaint</label>
                            <input type="text" name="fullName" class="form-control" id="exampleInputPassword1" placeholder="ex. Juan Dela Cruz" required>
                          </div>
                    </div>
                    <div class="col w-100">
                        <div class="form-group mt-4" style="font-weight: 800;">
                            <label for="exampleInputPassword1">Residential Address</label>
                            <input type="text" name="fullAddress"class="form-control" id="exampleInputPassword1" placeholder="Block No. Street Name, Subd/Village/Sitio" required>
                          </div>
                    </div>
                    <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="contact">Contact Number</label>
                        <input type="tel" class="form-control" name="contact" id="contact"  
                            placeholder="09XXXXXXXXX" 
                            pattern="09[0-9]{9}" maxlength="11" required>
                        <div class="invalid-feedback">Must be exactly 11 digits (09XXXXXXXXX).</div>
                      </div>
                    <div class="col w-100">
                        <div class="form-group mt-4" style="font-weight: 800;">
                            <label for="exampleInputPassword1">Email Address</label>
                            <input type="email" name="email" class="form-control" id="exampleInputPassword1" placeholder="example@gmail.com" required>
                          </div>
                    </div>
                    
                    <div class="h4 mt-5 text-center" style="font-weight: 700;">Blotter Details</div>

                   <div class="row" style="text-align: left;">
                    <div class="col-md-4 ">
                        <div class="form-group mt-4" style="font-weight: 800;">
                            <label for="exampleInputPassword1">Date  of Incident</label>
                            <input type="date" name="dateIncident"class="form-control" id="exampleInputPassword1" required >
                          </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="form-group mt-4" style="font-weight: 800;">
                            <label for="exampleInputPassword1">Time of the Incident</label>
                            <input type="time" name="timeIncident" class="form-control" id="exampleInputPassword1" required>
                          </div>
                    </div>
                    <div class="col-md-4  ">
                        <div class="ms-4" style="text-align: left;font-weight: 800;">
                            <label class="mt-3 "> Case Nature </label>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="caseType" value="Civil Case" id="flexRadioDefault1" required>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Civil Case
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="caseType" value="Criminal Case" id="flexRadioDefault2" required>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Criminal Case
                                </label>
                            </div>

                           </div>
                    </div>


                    <div class="col-md-12 w-100">
                        <div class="form-group mt-4" style="font-weight: 800;">
                            <label for="exampleInputPassword1">Location of the Incident</label>
                            <input type="text" name="locationIncident" class="form-control" id="exampleInputPassword1" required>
                          </div>
                    </div>
                    <div class="col-md-12 w-100">
                        <div class="form-group mt-4" style="font-weight: 800;">
                            <label for="exampleInputPassword1">Who/What is the subject of your Complaint</label>
                            <input type="text" name="subjectIncident"class="form-control" id="exampleInputPassword1" >
                          </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mt-4" style="font-weight: 800; text-align: left;">
                            <label for="exampleFormControlTextarea1">Summary of the Complaint</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="blotterSummary" rows="3" required></textarea>
                        </div>
                    </div>


                </div>
                <div class="d-flex mt-5">
                    <button type="button" id="back_button" onclick="window.location.href='../service.php'" class="button me-auto mt-2">
                        Back
                    </button>
                    <button type="button" id="next_button" class="button mt-2" >
                        Submit
                    </button>
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
              <button type="button" class="learn mt-2"  style="padding: 5px 15px;" data-bs-target="#exampleModal" data-bs-toggle="modal">Yes</button>
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
$(document).ready(function () {
    // ✅ Live validation on input change
    $(document).on("input change", "input[required], select[required], textarea[required]", function () {
        validateField(this);
        toggleSubmitButton();
    });

    $("input[name='caseType']").on("change", function () {
        validateField(this);
        toggleSubmitButton();
    });

    // ✅ Validate all fields when clicking Submit
    $("#next_button").on("click", function (event) {
        let firstInvalid = validateAllFields();
        
        if (firstInvalid) {
            event.preventDefault(); // Stop modal from opening
            $(firstInvalid).focus(); // Focus on first invalid field
        } else {
            enableSubmitButton(); // ✅ Enable modal attributes
        }
    });
});

// ✅ Validate all fields & highlight missing inputs
function validateAllFields() {
    let firstInvalid = null;

    $("#blotterForm").find("input[required], select[required], textarea[required]").each(function () {
        if (!validateField(this) && !firstInvalid) {
            firstInvalid = this;
        }
    });

    // ✅ Ensure a case type is selected (Highlight in red, No error message)
    if (!$("input[name='caseType']:checked").val()) {
        $("input[name='caseType']").addClass("is-invalid");
        if (!firstInvalid) firstInvalid = $("input[name='caseType']").first();
    } else {
        $("input[name='caseType']").removeClass("is-invalid");
    }

    return firstInvalid;
}

// ✅ Validate a single field
// ✅ Validate a single field
function validateField(element) {
    var value = $(element).val() ? $(element).val().trim() : '';
    var inputType = $(element).attr("type");
    var inputName = $(element).attr("name");

    var generalRegex = /[^a-zA-Z0-9ñ ]/; // Blocks special characters except space
    var addressRegex = /[^a-zA-Z0-9ñ ,.]/; // Allows ",", "." and space for fullAddress
    var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    var phoneRegex = /^09[0-9]{9}$/;

    if (!value) {
        showError(element, "This field is required.");
        return false;
    } 
    if (inputType === "email" && !emailRegex.test(value)) {
        showError(element, "Invalid email format (example@gmail.com).");
        return false;
    } 
    if (inputName === "contact" && !phoneRegex.test(value)) {
        showError(element, "Must be exactly 11 digits (09XXXXXXXXX).");
        return false;
    } 

    // If not email, date, or time, validate special characters
    if (!["email", "date", "time"].includes(inputType)) {
        if (inputName === "fullAddress") {
            if (addressRegex.test(value)) {
                showError(element, "Only letters, numbers, spaces, commas, and periods are allowed.");
                return false;
            }
        } else {
            if (generalRegex.test(value)) {
                showError(element, "Special characters are not allowed.");
                return false;
            }
        }
    }
    removeError(element);
    return true; // Passes validation
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

// ✅ Enable modal attributes on the Submit button
function enableSubmitButton() {
    $("#next_button").attr("data-bs-toggle", "modal").attr("data-bs-target", "#confirmation");
}

// ✅ Disable modal attributes if fields are missing
function disableSubmitButton() {
    $("#next_button").removeAttr("data-bs-toggle data-bs-target");
}

// ✅ Check if all fields are valid and toggle the Submit button
function toggleSubmitButton() {
    if (validateAllFields()) {
        disableSubmitButton();
    } else {
        enableSubmitButton();
    }
}

function submitForm() {
    $("#blotterForm").submit();
}
</script>




</body>
</html>