<!DOCTYPE html>
<html lang="en">
<head>
<?php
require '../src/connect.php'; // Use 'include' or 'require' to load the file
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
                   <div hidden>
                       <img src="../pics/logo.png" alt="Barangay Baritan Logo" style="width: 75px; margin-top: -26.6%; margin-left: 5%;">
                   </div>
                   <div>
                        <button id="login" class="btn btn-danger ms-2" style="margin-top: -8.6%; width: 100%;">Log In</button>
                   </div>
               </div>
           </div>
        </div>
    </div>
    <!--END HEADER-->



    <div class="container mt-5 text-center" style=" background-color: white; padding: 3% 0%; margin-bottom:5%;"> 
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
              <div class="col">
                <div class="step-circle inactive" >
                    2
                </div>
                <div class="h6">Address</div>
              </div>
              <div class="col"><hr></div>
              <div class="col">
                <div class="step-circle inactive" >
                    3
                </div>
                <div class="h6">Proof of Identity</div>
              </div>
             
            </div>
   
            <form id="registrationForm" action="../src/residentInfo.php" method="POST">
          <!-- Login Details -->
            <div class="container " style="text-align: left;">


                <div class="tab d-none" style="background-color: white;">
                    <div class="h4 mt-5 text-center" style="font-weight: 700;">Login Details</div>
                    <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputEmail1">Enter valid Email address</label>
                        <input type="text" class="form-control" id="userEmail" name="userEmail" aria-describedby="emailHelp" placeholder="example@gmail.com">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Enter Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Re-Enter Password</label>
                        <input type="password" class="form-control" id="rePassword" placeholder="Password">
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Enter Family Name</label>
                        <input type="text" class="form-control" id="famName" name="famName" placeholder="ex. Dela Cruz">
                      </div>
                      <br>

                    <!--  Personal Information -->
                      <div class="h4 mt-5 text-center" style="font-weight: 700;">Personal Information</div>
                      <div class="row">
                        <div class="col w-25">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="ex. Juan">
                              </div>
                        </div>
                        <div class="col w-25">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName"placeholder="ex. Dela Cruz">
                              </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">M.I.</label>
                                <input type="text" class="form-control" id="middleInitial" name="middleInitial" placeholder="ex. B">
                              </div>
                        </div>
                      </div>


                      <div class="row">
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Sex</label>
                                <select class="form-control" id="sex" name="sex">
                                    <option value="Male">Male</option>
                                    <option  value="Female">Female</option>
        
                                  </select>
                              </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Date of Birth</label>
                                <input type="date" class="form-control" id="birthday" name="birthday" placeholder="ex. Dela Cruz">
                              </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Role</label>
                                <select class="form-control" id="role" name="role">
                                    <option value="Head">Head of the Family</option>
                                    <option value="Father">Father</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Daughter">Daughter</option>
                                    <option value="Son">Son</option>
                                    <option value="otherRole">Other</option>
                                  </select>
                              </div>
                        </div>
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="text" class="form-control" id="email" name="email"aria-describedby="emailHelp" placeholder="example@gmail.com">
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputEmail1">Contact Number</label>
                        <input type="number" class="form-control" id="contact" name="contact" aria-describedby="emailHelp" placeholder="(09)">
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputEmail1">Occupation</label>
                        <input type="text" class="form-control" id="occupation" name="occupation" aria-describedby="emailHelp" placeholder="example@gmail.com">
                      </div>
                      <div class="row">
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Religion</label>
                                <select class="form-control" id="religion" name="religion">
                                    <option value="Roman Catholic" >Roman Catholic</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Jehovah’s Witnesses">Jehovah’s Witnesses</option>
                                    <option value="Christian">Christian</option>
                                    <option value="Iglesia ni Cristo (INC)">Iglesia ni Cristo (INC)</option>
                                    
                                  </select>
                              </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Civil Status</label>
                                <select class="form-control" id="civilStatus" name="civilStatus">
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
                                <label for="exampleInputPassword1">Eligibility Status</label>
                                <select class="form-control" id="eligibilityStatus" name="eligibilityStatus">
                                  <option value="pwd">PWD (Person with Disability)</option>
                                  <option value="single_parent">Single Parent</option>
                                  <option value="employed">Employed</option>
                                  <option value="unemployed">Unemployed</option>
                                  <option value="student">Student</option>
                                  <option value="senior_citizen">Senior Citizen</option>
                                </select>
                              </div>
                        </div>
                      </div>
                      <br>


            <!-- Emergency Contact -->
                      <div class="h4 mt-5 text-center" style="font-weight: 700;">Emergency Contact Information</div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Emergency Contact Person</label>
                        <input type="text" class="form-control" id="emergencyPerson" name="emergencyPerson"placeholder="">
                      </div>

                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Emergency Contact Number</label>
                        <input type="number" class="form-control" id="emergencyContact" name="emergencyContact" placeholder="09" max="11">
                      </div>

                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Relationship</label>
                        <input type="text" class="form-control" id="emergencyRelation" name="emergencyRelation" placeholder="">
                      </div>

                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleFormControlTextarea1">Address</label>
                        <textarea class="form-control" id="emergencyAddress" name="emergencyAddress"rows="3"></textarea>
                      </div>


                      <!--Address-->
                </div>
                <div class="tab d-none">
                    <div class="h4 mt-5 text-center" style="font-weight: 700;">Address</div>
                    <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputEmail1">Block No.</label>
                        <input type="text" class="form-control" id="block" name="block" placeholder="Enter your Block No.">
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Street Name</label>
                        <input type="text" class="form-control" id="street" name="street" placeholder="Enter your street">
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Subdivision/Village/Sitio (Optional)</label>
                        <input type="text" class="form-control" id="subdivision" name="subdivision" placeholder="Enter your Subdivision/Village/Sitio (Optional)">
                      </div>

                    <!-- proof of identity -->
                </div>
                <div class="tab d-none">
                    <div class="h4 mt-5 text-center" style="font-weight: 700">Proof of Identity</div>

                    <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Type of Identification Card (ID)</label>
                        <select class="form-control" id="idType" name="idType">
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
                        <input type="file" class="form-control" id="idFront"name="idFront">
                        <div class="lead mt-4" style="font-size: 16px;">Back Side</div>
                        <input type="file" class="form-control" id="idBack" name="idBack">
                      </div>

                      <div class="form-group mt-5" style="font-weight: 800;">
                        <label for="exampleInputEmail1">Upload 2x2 Picture</label>
                        <div class="lead mt-4" style="font-size: 16px;">(With White Background)</div>
                        <input type="file" class="form-control" id="2x2pic" name="2x2pic">
                        
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
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Are you sure?
            </div>
            <div class="modal-footer">
             <div class="me-auto">
                <button type="button" class="learn mt-2"  style="padding: 5px 15px; background-color: rgb(162, 164, 167);" data-bs-dismiss="modal">Close</button>
             </div>
              <button type="button" class="learn mt-2"  style="padding: 5px 15px;" data-bs-target="#exampleModal" data-bs-toggle="modal" onclick="submitForm()">Yes</button>
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
                    <button type="button" class="learn" data-bs-toggle="modal"  style="padding: 5px 15px;" onclick="window.location.href='../../'">Okay</button>
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
                .attr("data-bs-target","#confirmation")
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

        function submitForm() {
          document.getElementById("registrationForm").submit();
        }
        
              </script>




</body>
</html>