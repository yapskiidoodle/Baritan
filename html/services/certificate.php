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



    <div class="container text-center w-75" style=" background-color: white; padding: 3% 0% 5% 0%; margin-bottom:5%; margin-top:10%;"> 
        <div class="display-4 " style="font-weight: 700;">Document Issuance</div>
        <div class="container w-75 mt-5">

            <form action="../../src/certificate_form.php" method="POST" id="certificateForm">
        
   

      
            <div class="container " style="text-align: left;">


                <div class="tab " style="background-color: white;">
                    <div class="h4 mt-5 text-center" style="font-weight: 700;">Clearance/Certificate/Permit</div>
                    
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;" id="type">

                            <label for="exampleInputEmail1">Document Type</label>

                            <select class="form-control" id="categorySelect" name="documentType">
                                <option value="">-- Select Category --</option>
                                <option value="clearance">Clearance</option>
                                <option value="permit">Permit</option>
                                <option value="certificate">Certificate</option>
                            </select>
                              </div>
                        </div>
                        <div class="col" > 
                        <div class="form-group mt-4" style="font-weight: 800;" id="options" hidden>
                            <label for="purposeSelect">Purpose</label>
                            <select class="form-control" id="purposeSelect" name="purpose" required>
                                <option value="" disabled selected>-- Select Purpose --</option>
                            </select>
                        </div>

                        <script>
                            const optionsData = {
                                clearance: [
                                    "SSS Requirements",
                                    "PLDT Requirements",
                                    "PhilHealth Requirements",
                                    "Loan Requirements",
                                    "Marriage Requirements",
                                    "Internet Connection Requirements",
                                    "TESDA Requirements",
                                    "Proof Of Residency",
                                    "Application For Employment"
                                ],
                                permit: [
                                    "Demolition Permit",
                                    "Renovation Permit",
                                    "Business Permit/Business Closure",
                                    "E-Trike Registration/Loan"
                                ],
                                certificate: [
                                    "Postal ID Requirements",
                                    "Application For Late Submission Of Birth Certificate"
                                ]
                            };

                            document.getElementById("categorySelect").addEventListener("change", function () {
                                const selectedCategory = this.value;
                                const purposeSelect = document.getElementById("purposeSelect");
                                const optionsDiv = document.getElementById("options");

                                // Clear previous options except for the default disabled one
                                purposeSelect.innerHTML = '<option value="" disabled selected>-- Select Purpose --</option>';

                                if (optionsData[selectedCategory]) {
                                    optionsDiv.removeAttribute("hidden"); // Show the options div
                                    
                                    optionsData[selectedCategory].forEach(option => {
                                        let newOption = document.createElement("option");
                                        newOption.value = option;
                                        newOption.textContent = option;
                                        purposeSelect.appendChild(newOption);
                                    });
                                } else {
                                    optionsDiv.setAttribute("hidden", "true"); // Hide if no valid category is selected
                                }
                            });
                        </script>
                              
                      
                    </div>
                      
                      
                     
                      <br>


                      <div class="h4 mt-5 text-center" style="font-weight: 700;">Personal Information</div>
                      <div class="row">
                        <div class="col w-25">
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
                
                

                <div class="d-flex mt-5">
                    <button type="button" id="back_button" onclick="window.location.href='../service.php'" class="button mt-2 ">
                        Back
                    </button>
                    <button type="button" id="next_button" class="button ms-auto mt-2 me-2" data-bs-target="#confirmation"data-bs-toggle="modal" >Finish</button>
                </div>


                
            </div>

          </div>

        </form>
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
    var form = document.getElementById("certificateForm");
    form.submit();
}
            </script>




</body>
</html>