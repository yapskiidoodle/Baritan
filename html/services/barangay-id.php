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
    </style>

</head>
<body>


    
    
    <!-- header-->
    <div style="background-color:#1C3A5B;top:0;color: white;padding: 1%; position:fixed; width: 100%;">
        <div class="row">
           <div class="col-1" style="width: 5.3%; ">
               <img src="../../pics/logo.png" alt="Barangay Baritan Logo" style="width: 75px; display: inline;">
               
           </div>
           <div class="col-7" >
               <h4 style="padding-top:0.4%;">Barangay Baritan</h4>
               <h6 style="font-size: 10.5px;">Malabon City, Metro Manila, Philippines</h6>
           </div>
           <div class="col" style=" text-align: center; padding-top: 1.5%;">
               <div style="display: flex; ">
                   <div style="padding:0% 4%;">
                       <a href="../../">Home</a>
                   </div>
                   <div class="vr"></div>
                   <div style="padding:0% 4%;">
                       <a href="../about.php">About Us</a>
                   </div>
                   <div class="vr"></div>
                   <div style="padding:0% 4%;">
                       <a href="../service.php">Services</a>
                   </div>
                   <div class="vr"></div>
                   <div style="padding:0% 4%;">
                      <a href="../../index.php#contact">Contact Us</a>
                   </div>
                   <div class="vr"></div>
                   
                    <?php if (isset($_SESSION['userEmail'])) { ?>
                        <div class="dropdown" id="profile" name="profile">
                            <button class="btn dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="../../pics/profile.jpg" alt="" style="border-radius: 50%; width: 30px;">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="../../html/profile.php"><i class="fas fa-user"></i> Profile</a></li>
                                <li>
                                    <form action="../../src/logout.php" method="POST">
                                        <button class="dropdown-item" name="logoutButton"><i class="fas fa-sign-out-alt"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    <?php } else { ?>
                        <div id="start" name="start">
                            <a href="../login.php" class="btn btn-danger ms-2">Log In</a>
                        </div>
                    <?php } ?>
               </div>
           </div>
        </div>
        </div>
    <!-- End Header -->




    <div class="container  text-center w-75" style=" background-color: white; padding: 3% 0% 5% 0%; margin-bottom:5%;margin-top:10%; "> 
        <div class="display-4 " style="font-weight: 700;">Barangay ID</div>
        <div class="container w-75 mt-5">

            <form  id="generateID" action="../../src/generate_id.php" method="POST" enctype="multipart/form-data" target="_blank" >
              <div class="container text-center w-50">
                <div class=" row justify-content-center align-items-center mt-4 " >
                    <div class="col text-center" >
                      <div class="step-circle inactive" >
                          1
                      </div>
                      <div class="h6">Personal</div>
                    </div>
                    <div class="col"><hr></div>
                    <div class="col">
                      <div class="step-circle inactive" >
                          2
                      </div>
                      <div class="h6">Payment</div>
                    </div>
                    
                   
                  </div>
              </div>
   

      
            <div class="container " style="text-align: left;">


                <div class="tab d-none" style="background-color: white;">
                    


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
                                <label for="exampleInputPassword1">Middle Name</label>
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

                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Date of Birth</label>
                                <input type="date" name="birthday" class="form-control" id="exampleInputPassword1" required>
                              </div>
                        </div>
                        <div class="h4 mt-5 text-center" style="font-weight: 700;">Emergency Contact Information</div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Emergency Contact Person</label>
                        <input type="text" class="form-control" id="emergencyPerson" name="emergencyPerson" required>
                      </div>

                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="emergencyContact">Emergency Contact Number</label>
                        <input type="tel" class="form-control" id="emergencyContact" name="emergencyContact" 
                            placeholder="09XXXXXXXXX" 
                            pattern="09[0-9]{9}" maxlength="11" required>
                        <div class="invalid-feedback">Must be exactly 11 digits (09XXXXXXXXX).</div>
                      </div>
                    </div>
                    <div class="h4 mt-5 text-center" style="font-weight: 700;">Address</div>
                    
                    <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputEmail1">Block No.</label>
                        <input type="text" class="form-control" name="block" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Block No" required>
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Street Name</label>
                        <input type="text" class="form-control" name="street" id="exampleInputPassword1" placeholder="Street Name" required>
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Subdivision/Village/Sitio (Optional)</label>
                        <input type="text" class="form-control" name="subdivision" id="exampleInputPassword1" placeholder="(optional)">
                      </div>
                  
                   
                     
                 
  </div>
                      <div class="tab d-none">
                      


                
       
                    <div class="h4 mt-5 text-center" style="font-weight: 700">Payment</div>
                    <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Type of Identification Card (ID)</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>Passport</option>
                            <option>Drivers License</option>
                            <option>Philhealth</option>
                            <option>Postal ID</option>
                            <option>National ID</option>
                            <option>Voters ID</option>
                          </select>
                      </div>
                   <div class="row mt-5">
                    <div class="col">
                        
                          <div class="form-group mt-4" style="font-weight: 800;">
                            <label for="exampleInputEmail1">Upload Identification Card</label>  
                            <div class="lead mt-4" style="font-size: 16px;">Front Side</div>
                            <input type="file" class="form-control" id="exampleInputEmail1">
                            <div class="lead mt-4" style="font-size: 16px;">Back Side</div>
                            <input type="file" class="form-control" id="exampleInputEmail1">
                          </div>

                          <div class="form-group mt-4" style="font-weight: 800;">
                              <label for="exampleInputEmail1">Upload 2x2 Picture</label>  
                              <input type="file" name="twoByTwo" id="2x2" accept="image/*" class="form-control"  />
                              <div class="lead mt-4" style="font-size: 16px;">with white background</div>
                          </div>
    
                          <div class="form-group mt-5" style="font-weight: 800;">
                            <label for="exampleInputEmail1">Upload Reciept</label>
                            <div class="lead mt-4" style="font-size: 16px;">(Screenshot of the payment)</div>
                            <input type="file" class="form-control" id="exampleInputEmail1">
                            
                          </div>
                    </div>
                    <div class="col ">
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
                        <button type="button" id="back_button"  onclick="back()" class="button  mt-2 ">Previous</button>
                        <button type="button" id="next_button" class="button ms-auto mt-2" onclick="next()" >Next</button>
                    </div>
            </form>
   
                
                
            </div>

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
              <button type="button" id="generateButton" class="learn" style="padding: 5px 15px;" onclick="submitForm()">Okay</button>
          </div>
             
            </div>
          </div>
        </div>
    </div>

    <script>
    var current = 0;
var tabs = $(".tab");
var tabs_pill = $(".step-circle");

loadFormData(current);

function loadFormData(n) {
    $(tabs_pill[n]).addClass("active").removeClass("inactive");
    $(tabs[n]).removeClass("d-none");

    $("#back_button").toggleClass("d-none", n === 0);

    if (n === tabs.length - 1) {
        $("#next_button")
            .text("Submit")
            .removeAttr("onclick")
            .attr({ "data-bs-toggle": "modal", "data-bs-target": "#exampleModal" });
    } else {
        $("#next_button")
            .text("Next")
            .attr({ "type": "button", "onclick": "next()" })
            .removeAttr("data-bs-toggle data-bs-target");
    }
}

function next() {
    if (!validateInput()) return; // Check validation before proceeding

    $(tabs[current]).addClass("d-none");
    $(tabs_pill[current]).addClass("inactive");

    current++;
    loadFormData(current);
}

function back() {
    $(tabs[current]).addClass("d-none");
    $(tabs_pill[current]).addClass("inactive");

    current--;
    loadFormData(current);
}

/**
 * validateInput - Checks all required fields in the current tab.
 * @returns {boolean} - Returns true if all fields are valid, false otherwise.
 */
function validateInput() {
    let valid = true;
    let currentTab = $(tabs[current]); // Get current tab

    // Validate all required inputs
    currentTab.find("input[required], select[required]").each(function () {
        if (!$(this).val().trim()) {
            $(this).addClass("is-invalid");
            valid = false;
        } else {
            $(this).removeClass("is-invalid");
        }
    });

    // Validate phone number format (if applicable in the current tab)
    let phoneField = currentTab.find("input[name='emergencyContact']");
    let phoneRegex = /^09\d{9}$/; // Format: 09XXXXXXXXX (11 digits)
    if (phoneField.length && !phoneRegex.test(phoneField.val().trim())) {
        phoneField.addClass("is-invalid");
        valid = false;
    } else {
        phoneField.removeClass("is-invalid");
    }

    return valid;
}

function submitForm() {
    document.getElementById("generateID").submit();
}

function redirectToIndex() {
    setTimeout(function () {
        window.location.href = "../../index.php"; 
    }, 1000);
}

</script>




</body>
</html>