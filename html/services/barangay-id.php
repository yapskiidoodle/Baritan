<!DOCTYPE html>
<html lang="en">
<head>
  <?php
  require '../../src/connect.php';
  require '../../src/account.php';
  ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../../pics/logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../design.css"> 
    <title>Barangay ID</title>
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
        .file-error {
          color: #dc3545;
          font-size: 0.875em;
          display: none;
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

    <div class="container  text-center w-75" style=" background-color: white; padding: 3% 0% 5% 0%; margin-bottom:5%;margin-top:5%; "> 
        <div class="display-4 " style="font-weight: 700;">Barangay ID</div>
        <div class="container w-75 mt-5">

            <form id="generateID" action="../../src/generate_id.php" method="POST" enctype="multipart/form-data" >
              <div class="container text-center w-50">
                <div class=" row justify-content-center align-items-center mt-4 " >
                    <div class="col text-center" >
                      <div class="step-circle inactive" id="step1">
                          1
                      </div>
                      <div class="h6">Personal</div>
                    </div>
                    <div class="col"><hr></div>
                    <div class="col">
                      <div class="step-circle inactive" id="step2">
                          2
                      </div>
                      <div class="h6">Payment</div>
                    </div>
                  </div>
              </div>
   
            <div class="container " style="text-align: left;">
                <div class="tab" id="tab1" style="background-color: white;">
                    <!-- Personal Information -->
                    <div class="h4 mt-5 text-center" style="font-weight: 700;">Personal Information</div>
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="ex. Juan" required>
                                <div class="invalid-feedback">Please provide your first name.</div>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="ex. Dela Cruz" required>
                                <div class="invalid-feedback">Please provide your last name.</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="middleInitial">Middle Name</label>
                                <input type="text" class="form-control" id="middleInitial" name="middleInitial" placeholder="ex. Banaga">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="suffix">Suffix</label>
                                <input type="text" class="form-control" id="suffix" name="suffix" placeholder="ex. Sr. Jr.">
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group mt-4" style="font-weight: 800;">
                            <label for="birthday">Date of Birth</label>
                            <input type="date" name="birthday" class="form-control" id="birthday" required>
                            <div class="invalid-feedback">Please provide your date of birth.</div>
                        </div>
                    </div>
                    <div class="h4 mt-5 text-center" style="font-weight: 700;">Emergency Contact Information</div>
                    <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="emergencyPerson">Emergency Contact Person</label>
                        <input type="text" class="form-control" id="emergencyPerson" name="emergencyPerson" required>
                        <div class="invalid-feedback">Please provide an emergency contact person.</div>
                    </div>

                    <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="emergencyContact">Emergency Contact Number</label>
                        <input type="tel" class="form-control" id="emergencyContact" name="emergencyContact" 
                            placeholder="09XXXXXXXXX" 
                            pattern="09[0-9]{9}" maxlength="11" required>
                        <div class="invalid-feedback">Must be exactly 11 digits (09XXXXXXXXX).</div>
                    </div>
                    
                    <div class="h4 mt-5 text-center" style="font-weight: 700;">Address</div>
                    <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="block">Block No.</label>
                        <input type="text" class="form-control" name="block" id="block" aria-describedby="emailHelp" placeholder="Block No" required>
                        <div class="invalid-feedback">Please provide your block number.</div>
                    </div>
                    <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="street">Street Name</label>
                        <input type="text" class="form-control" name="street" id="street" placeholder="Street Name" required>
                        <div class="invalid-feedback">Please provide your street name.</div>
                    </div>
                    <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="subdivision">Subdivision/Village/Sitio (Optional)</label>
                        <input type="text" class="form-control" name="subdivision" id="subdivision" placeholder="(optional)">
                    </div>
                </div>
                      
                <div class="tab d-none" id="tab2">
                    <div class="h4 mt-5 text-center" style="font-weight: 700">Payment</div>
                    <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="idType">Type of Identification Card (ID)</label>
                        <select class="form-control" id="idType" name="idType" required>
                            <option value="" disabled selected>--Choose an Option</option>
                            <option value="Passport">Passport</option>
                            <option value="Driver's License">Driver's License</option>
                            <option value="Philhealth">Philhealth</option>
                            <option value="Postal ID">Postal ID</option>
                            <option value="National ID">National ID</option>
                            <option value="Voters ID">Voters ID</option>
                        </select>
                        <div class="invalid-feedback">Please select an ID type.</div>
                    </div>
                   
                    <div class="row mt-5">
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="idFront">Upload Identification Card</label>  
                                <div class="lead mt-4" style="font-size: 16px;">Front Side</div>
                                <input type="file" class="form-control" id="idFront" name="idFront" required accept="image/*">
                                <div class="file-error" id="idFrontError">Please upload the front side of your ID.</div>
                                <div class="lead mt-4" style="font-size: 16px;">Back Side</div>
                                <input type="file" class="form-control" id="idBack" name="idBack" required accept="image/*">
                                <div class="file-error" id="idBackError">Please upload the back side of your ID.</div>
                            </div>

                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="twoByTwo">Upload 2x2 Picture</label>  
                                <input type="file" name="twoByTwo" id="twoByTwo" accept="image/*" class="form-control" required />
                                <div class="file-error" id="twoByTwoError">Please upload a 2x2 picture.</div>
                                <div class="lead mt-4" style="font-size: 16px;">with white background</div>
                            </div>
    
                            <div class="form-group mt-5" style="font-weight: 800;">
                                <label for="payment">Upload Receipt</label>
                                <div class="lead mt-4" style="font-size: 16px;">(Screenshot of the payment)</div>
                                <input type="file" class="form-control" id="payment" name="payment" required accept="image/*">
                                <div class="file-error" id="paymentError">Please upload a payment receipt.</div>
                            </div>
                        </div>
                        <div class="col">
                            <img src="../../pics/qr.png" class="rounded mx-auto d-block" alt="Qr Code" style="height: 350px; width: 350px; border-radius: 10px; border:1px solid black; ">
                            <div class="text-center">
                                <div class="lead">
                                    Barangay Baritan, Malabon City
                                </div>
                                <div class="h5"> (09)99 999 9999</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex mt-5">
                    <button type="button" id="back_button" class="button mt-2 d-none" onclick="back()">Previous</button>
                    <div class="ms-auto d-flex w-25">
                        <button type="button" id="view_form" class="button mt-2 me-2" onclick="submitForm()">View Form</button>
                        <button type="button" id="next_button" class="button mt-2" onclick="next()">Next</button>
                    </div>
                </div>
            </div>
          
        </div>
    </div>

    <!-- Confirmation Modals -->
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
                <button type="button" class="learn mt-2" style="padding: 5px 15px; background-color: rgb(162, 164, 167);" data-bs-dismiss="modal">Close</button>
             </div>
              <button type="button" class="learn mt-2" style="padding: 5px 15px;" data-bs-target="#exampleModal" data-bs-toggle="modal">Yes</button>
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content" style="width: 150%;">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="text-center">
                <div class="h4">Thank you for the feedback</div>
                <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55" fill="currentColor" class="bi bi-check-circle-fill " viewBox="0 0 16 16"> 
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" style="color: rgb(93, 180, 5);"/>
                </svg>
                <div class="lead">
                    This would be first reviewed by the officials
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <div class="text-center mx-auto">
                <button type="submit" id="generateButton" class="learn" style="padding: 5px 15px;" name="submitBtn">Okay</button>
              </div>
              </form>
            </div>
          </div>
        </div>
    </div>

    <script>
    let currentTab = 0;
    const tabs = document.querySelectorAll(".tab");
    const stepCircles = document.querySelectorAll(".step-circle");
    const nextButton = document.getElementById("next_button");
    const backButton = document.getElementById("back_button");
    const viewFormButton = document.getElementById("view_form");
    const form = document.getElementById("generateID");

    // Initialize the form
    showTab(currentTab);

    function showTab(n) {
        // Hide all tabs
        tabs.forEach(tab => tab.classList.add("d-none"));
        // Show the current tab
        tabs[n].classList.remove("d-none");
        
        // Update step circles
        stepCircles.forEach((circle, index) => {
            if (index <= n) {
                circle.classList.add("active");
                circle.classList.remove("inactive");
            } else {
                circle.classList.add("inactive");
                circle.classList.remove("active");
            }
        });

        // Show/hide back button
        if (n === 0) {
            backButton.classList.add("d-none");
        } else {
            backButton.classList.remove("d-none");
        }

        // Change next button text and behavior on last tab
        if (n === tabs.length - 1) {
            nextButton.textContent = "Submit";
            nextButton.removeAttribute("onclick");
            nextButton.setAttribute("data-bs-toggle", "modal");
            nextButton.setAttribute("data-bs-target", "#confirmation");
        } else {
            nextButton.textContent = "Next";
            nextButton.setAttribute("onclick", "next()");
            nextButton.removeAttribute("data-bs-toggle");
            nextButton.removeAttribute("data-bs-target");
        }
    }

    function next() {
        // Validate the current tab before proceeding
        if (!validateTab(currentTab)) {
            return false;
        }

        // Hide current tab
        tabs[currentTab].classList.add("d-none");
        // Move to next tab
        currentTab++;
        // Show next tab
        showTab(currentTab);
    }

    function back() {
        // Hide current tab
        tabs[currentTab].classList.add("d-none");
        // Move to previous tab
        currentTab--;
        // Show previous tab
        showTab(currentTab);
    }

    function validateTab(n) {
        let valid = true;
        const currentTab = tabs[n];
        const inputs = currentTab.querySelectorAll("input[required], select[required]");
        const fileInputs = currentTab.querySelectorAll("input[type='file'][required]");

        // Validate regular inputs
        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add("is-invalid");
                valid = false;
            } else {
                input.classList.remove("is-invalid");
            }
        });

        // Validate phone number format specifically
        const phoneField = currentTab.querySelector("input[name='emergencyContact']");
        if (phoneField) {
            const phoneRegex = /^09\d{9}$/;
            if (!phoneRegex.test(phoneField.value.trim())) {
                phoneField.classList.add("is-invalid");
                valid = false;
            } else {
                phoneField.classList.remove("is-invalid");
            }
        }

        // Validate file inputs
        fileInputs.forEach(input => {
            const errorElement = document.getElementById(input.id + "Error");
            if (!input.files || input.files.length === 0) {
                errorElement.style.display = "block";
                valid = false;
            } else {
                errorElement.style.display = "none";
            }
        });

        return valid;
    }

    function submitForm() {
        // Validate all tabs before submitting
        let allValid = true;
        for (let i = 0; i < tabs.length; i++) {
            if (!validateTab(i)) {
                allValid = false;
                // Show the first invalid tab
                if (currentTab !== i) {
                    tabs[currentTab].classList.add("d-none");
                    currentTab = i;
                    showTab(currentTab);
                }
                break;
            }
        }

        if (allValid) {
            form.submit();
        }
    }

    // Add event listeners for file inputs to clear errors when files are selected
    document.getElementById("idFront").addEventListener("change", function() {
        document.getElementById("idFrontError").style.display = "none";
    });
    document.getElementById("idBack").addEventListener("change", function() {
        document.getElementById("idBackError").style.display = "none";
    });
    document.getElementById("twoByTwo").addEventListener("change", function() {
        document.getElementById("twoByTwoError").style.display = "none";
    });
    document.getElementById("payment").addEventListener("change", function() {
        document.getElementById("paymentError").style.display = "none";
    });
    </script>
</body>
</html>