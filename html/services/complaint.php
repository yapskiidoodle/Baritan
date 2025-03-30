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



    <div class="container text-center w-75" style=" background-color: white; padding: 3% 0%; margin-bottom:5%;margin-top:10%;"> 
        <div class="display-4 " style="font-weight: 700;">Complaint Form</div>
        <div class="lead">All section as marked <s style="color:red">*</s> are to be completed </div>
        <div class="lead" style="font-size: 16px;">All Personal Details remains <b>CONFIDENTIAL</b></div>
        <div class="container w-75 mt-5">

            <form action="../../src/complaintForm.php" method="POST" id="complaintForm">
                <div class=" row justify-content-center align-items-center mt-4" >
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
                      <div class="h6">Complaint</div>
                    </div>
                    <div class="col"><hr></div>
                    <div class="col">
                      <div class="step-circle inactive" >
                          3
                      </div>
                      <div class="h6">Confirmation</div>
                    </div>
                   
                  </div>
   

      
            <div class="container " style="text-align: left;">


                <div class="tab d-none" style="background-color: white;">
                    


                      <div class="h4 mt-5 text-center" style="font-weight: 700;">Personal Information</div>
                     
                        <div class="col w-100">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Name of Person making the Complaint</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="ex. Juan Dela Cruz" name="fullName">
                              </div>
                        </div>
                        <div class="col w-100">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Residential Address</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Block No. Street Name, Subd/Village/Sitio" name="address">
                              </div>
                        </div>
                        <div class="col w-100">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Contact Information</label>
                                <input type="number" class="form-control" id="exampleInputPassword1" placeholder="(09) " name="contact">
                              </div>
                        </div>
                        <div class="col w-100">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Email Address</label>
                                <input type="email" class="form-control" id="exampleInputPassword1" placeholder="example@gmail.com" name="email">
                              </div>
                        </div>
                        
                        
                     </div>

                </div>
                
                <div class="tab d-none">
                    <div class="h4 mt-5 text-center" style="font-weight: 700;">Complaint Details</div>

                   <div class="row" style="text-align: left;">
                    <div class="col-md-6 ">
                        <div class="form-group mt-4" style="font-weight: 800;">
                            <label for="exampleInputPassword1">Date  of Incident</label>
                            <input type="date" class="form-control" id="exampleInputPassword1" name="dateOfIncident">
                          </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group mt-4" style="font-weight: 800;">
                            <label for="exampleInputPassword1">Time of the Incident</label>
                            <input type="time" class="form-control" id="exampleInputPassword1" name="timeOfIncident">
                          </div>
                    </div>
                    <div class="col-md-12 w-100">
                        <div class="form-group mt-4" style="font-weight: 800;">
                            <label for="exampleInputPassword1">Location of the Incident</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" name="locationOfIncident">
                          </div>
                    </div>
                    <div class="col-md-12 w-100">
                        <div class="form-group mt-4" style="font-weight: 800;">
                            <label for="exampleInputPassword1">What is the Subject of your Complaint</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" name="whatSubjectOfComplaint">
                          </div>
                    </div>
                    <div class="col-md-12 w-100">
                        <div class="form-group mt-4" style="font-weight: 800;">
                            <label for="exampleInputPassword1">Who is the Subject of your complaint</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" name="whoSubjectOfComplaint">
                          </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group mt-4" style="font-weight: 800;">
                            <label for="exampleFormControlTextarea1">Summary of the Complaint</label>
                            <textarea class="form-control" name="summaryOfComplaint" id="exampleFormControlTextarea1" rows="3" ></textarea>
                          </div>
                    </div>
                   </div>

                   <div class="h4 mt-5 text-center" style="font-weight: 700;">Witness Details <br>
                (if possible)</div>
                    <div style="text-align: left;">
                        <div class="col w-100">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Name of the Witness</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="ex. Juan Dela Cruz" name="nameOfWitness">
                              </div>
                        </div>
                        <div class="col w-100">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Residential Address</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Block No. Street Name, Subd/Village/Sitio" name="witnessAddress">
                              </div>
                        </div>
                        <div class="col w-100">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Contact Information</label>
                                <input type="number" class="form-control" id="exampleInputPassword1" placeholder="(09) " name="witnessContact">
                              </div>
                        </div>
                        <div class="col w-100">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Email Address</label>
                                <input type="email" class="form-control" id="exampleInputPassword1" placeholder="example@gmail.com" name="witnessEmail">
                              </div>
                        </div>
                        
                    </div>

                </div>
                <div class="tab d-none">
                    <div class="row">
                        <div class="col">
                           <div class="" style="text-align: left;font-weight: 800;">
                            <label class="mt-5"> As a result of making this complaint, is there any outcome you would like to?</label>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="outcome" value="Yes" id="flexRadioDefault1" required>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="outcome" value="No" id="flexRadioDefault2" required>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    No
                                </label>
                            </div>

                           </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mt-4" style="font-weight: 800; text-align: left;">
                                <label for="exampleFormControlTextarea1">If yes, please provide details</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="outcomeDetails"></textarea>
                              </div>
                        </div>
                        
                        
                    </div>
                </div>
                
                

                
                    <div class="d-flex mt-5">
                        <button type="button" id="back_button"  onclick="back()" class="button  mt-2 ">Previous</button>
                        <button type="button" id="next_button" class="button ms-auto mt-2" onclick="next()" >Next</button>
                    </div>
            </form>
                    <script> 

                        var current = 0;
                        var tabs = $(".tab");
                        var tabs_pill = $(".step-circle");
                        loadFormData(current);
                        
                        function loadFormData(n) {
                        
                            $(tabs_pill[n]).addClass("active");
                            $(tabs_pill[n]).removeClass("inactive"); 
                            $(tabs[n]).removeClass("d-none");
                          
                        if (n == 0) {
                            $("#back_button").addClass("d-none"); // Hide the Back button
                        } else {
                            $("#back_button").removeClass("d-none"); // Show the Back button
                        }
                
                        n == tabs.length -1
                            ? $("#next_button")
                                .text("Submit")
                                .removeAttr("onclick")
                                .attr("data-bs-toggle", "modal")
                                .attr("data-bs-target","#exampleModal")
                            : $("#next_button")
                                .attr("type", "button")
                                .text("Next")
                                .attr("onclick", "next()");
                        
                        
                        }
                        
                        function next() {
                          $(tabs[current]).addClass("d-none");
                          $(tabs_pill[current]).addClass("inactive");
                         
                          current++;
                          loadFormData(current);
                        }
                        
                        function back() {
                          $(tabs[current]).addClass("d-none");
                          $(tabs_pill[current]).addClass("inactive");
                          
                          $("#next_button").removeAttr("data-bs-toggle","data-bs-target")
                
                        
                          current--;
                          loadFormData(current);
                        }
                        
                              </script>
                
                
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
        document.getElementById("complaintForm").submit();
        document.getElementById("complaintForm").disabled = true;

    }
</script>


</body>
</html>