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


    <div class="container text-center w-75" style=" background-color: white; padding: 3% 0% 5% 0%; margin-bottom:5%; margin-top:5%;"> 
     
        <div class="display-4 " style="font-weight: 700;">Reservation</div>
        <div class="container w-75 mt-5">

            <form action="../../src/reservationLogic.php" method="POST" id="reservationForm">
        
      
            <div class="container " style="text-align: left;">


                <div class="tab " style="background-color: white;">
                    <div class="h4 mt-5 text-center" style="font-weight: 700;">Please Input the reservation details</div>
                    <div class="row">
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
                                <input type="text" class="form-control" id="middleInitial" name="middleName" placeholder="ex. Banaga">
                              </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Suffix</label>
                                <input type="text" class="form-control" id="suffix" name="suffix" placeholder="ex. Sr. Jr."  >
                              </div>
                        </div>
                      </div>
                        <div class="col-9">
                            <div class="col w-100">
                                <div class="form-group mt-4" style="font-weight: 800;">
                                    <label for="exampleInputPassword1">What to reserve? 
                                        <div class="lead d-inline" style="font-size: 15px;">(Equipment/Facility)</div>

                                    </label>
                                    <select class="form-control" name="equipment" >
                                        <option >--Choose--</option>
                                        <option value="Table">Table</option>
                                        <option value="Chair">Chair</option>
                                        <option value="Tent">Tent</option>
                                        <option value="Sound System">Sound System</option>
                                        <option value="Covered Court">Covered Court</option>
                                        <option value="Multipurpose Hall">Multipurpose Hall</option>
    
                                      </select>
                                  </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="col w-100">
                                <div class="form-group mt-4" style="font-weight: 800;">
                                    <label for="exampleInputPassword1">Quantity</label> 
                                    <input type="number" class="form-control" id="exampleInputPassword1" oninput="this.value=this.value.slice(0,3)" name="quantity">
                                  </div>
                            </div>
                        </div>
                    </div>
                      
                    
                    <div class="form-group mt-4" style="font-weight: 800;">
                                        
                        <label for="exampleInputEmail1">Venue
                            <div class="lead d-inline" style="font-size: 15px;">(For Equipment Reservation Only)</div>
                        </label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="eg. Multipurpose hall, Jose Str., Court" name="venue">
                      </div>
                      <div class="row">
                        <div class="col-auto">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Date to Reserve</label>
                                <input type="date" class="form-control" id="exampleInputPassword1" name="dateToReserve" required>
                              </div>  
                        </div>
                        <div class="col-auto">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Date to Return</label>
                                <input type="date" class="form-control" id="exampleInputPassword1" name="dateToReturn" required >
                              </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="purpose">Purpose of Reservation</label>
                                <select class="form-control" id="purpose" name="purpose" required>
                                    <option value="">--Choose--</option>
                                    <option value="Birthday Celebration">Birthday Celebration</option>
                                    <option value="Community_meeting">Community Meeting</option>
                                    <option value="Wedding_ceremony">Wedding Ceremony</option>
                                    <option value="Sports_event_tournament">Sports Event/Tournament</option>
                                    <option value="Funeral">Funeral</option>
                                    <option value="Other">Other (please specify)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-12" id="other" hidden>
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="otherInput">Please Specify</label>
                                <input type="text" class="form-control" id="otherInput" name="otherInput">
                            </div>
                        </div>
                        
                        
                        <script>
                            document.getElementById("purpose").addEventListener("change", function() {
                                var selectedValue = this.value;
                                var otherInputDiv = document.getElementById("other");
                                
                                if (selectedValue === "Other") {
                                    otherInputDiv.hidden = false;
                                } else {
                                    otherInputDiv.hidden = true;
                                }
                            });

                            function getSelectedPurpose() {
                                var selectedValue = document.getElementById("purpose").value;
                                if (selectedValue === "Other") {
                                    return document.getElementById("otherInput").value; // Get custom input
                                } else {
                                    return selectedValue; // Return selected option
                                }
                            }

                            // Example: Using the function when submitting a form
                            document.getElementById("otherInput").addEventListener("input", function() {
                                console.log("Selected Purpose:", getSelectedPurpose());
                            });
                        </script>

                </div>
                
                

                
                <div class="d-flex mt-5">
                    <button type="button" id="back_button" onclick="window.location.href='../service.php'" class="button mt-2">
                        Back
                    </button>
                    <button type="button" id="next_button" class="button mt-2 ms-auto" onclick="validateAndShowConfirmation()">Finish</button>
                    
                </div>
                    
               


                
            </div>

          </div>

        </form>
    </div>
    


    <div class="modal fade" id="confirmation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header" >
              <h5 class="modal-title" id="exampleModalLabel" >Confirmation</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-2">
              <div class="h5">
              Are you sure?
              </div>
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
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
    function submitForm() {
        document.getElementById("reservationForm").submit();
 
        document.getElementById("reservationForm").disabled = true;

    }

    function validateAndShowConfirmation() {
    // First, validate the form inputs
    if (validateInput()) {
        // If validation is successful, show the confirmation modal
        $('#confirmation').modal('show');
    }
}

function validateInput() {
    let valid = true;
    let firstInvalidField = null;

    // Validate all required inputs
    $("input[required], select[required]").each(function () {
        if (!$(this).val().trim()) {
            // If the field is empty, mark it as invalid (red) and set the first invalid field
            $(this).addClass("is-invalid").removeClass("is-valid");

            // If it's the first invalid field, focus on it
            if (!firstInvalidField) {
                firstInvalidField = this;
            }

            valid = false;
        } else {
            // If the field is filled, mark it as valid (green)
            $(this).addClass("is-valid").removeClass("is-invalid");
        }
    });

    // Focus on the first invalid field if any
    if (firstInvalidField) {
        firstInvalidField.focus();
    }

    return valid;
}
</script>






</body>
</html>