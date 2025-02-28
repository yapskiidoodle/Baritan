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


    <!--header-->
    <div class="container-fluid" style="background-color:#1C3A5B;color: white;padding: 1%; width: 100%;  ">  
        <div class="row" >    
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
                    <a href="../../index.php">Home</a>
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
                    <a href="../../index.php?#contact"  >Contact Us</a>
                </div>
                <div class="vr"></div>
                <div hidden>
                    <img src="pics/logo.png" alt="Barangay Baritan Logo" style="width: 75px; margin-top: -26.6%; margin-left: 5%;">
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
        <div class="display-4 " style="font-weight: 700;">Barangay ID</div>
        <div class="container w-75 mt-5">

            <form action="">
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
                    


                      <div class="h4 mt-5 text-center" style="font-weight: 700;">Personal Information</div>
                      <div class="row">
                        <div class="col w-25">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">First Name</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="ex. Juan">
                              </div>
                        </div>
                        <div class="col w-25">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Last Name</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="ex. Dela Cruz">
                              </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">M.I.</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="ex. B">
                              </div>
                        </div>
                      </div>


                      <div class="row">
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Sex</label>
                                <select class="form-control" id="exampleFormControlSelect1">
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other? ewan</option>
                                    
                                  </select>
                              </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Date of Birth</label>
                                <input type="date" class="form-control" id="exampleInputPassword1" placeholder="ex. Dela Cruz">
                              </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Role</label>
                                <select class="form-control" id="exampleFormControlSelect1">
                                    <option>Head of the Family</option>
                                    <option>Father</option>
                                    <option>Mother</option>
                                    <option>Daughter</option>
                                    <option>Son</option>
                                    <option>Other</option>
                                  </select>
                              </div>
                        </div>
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="example@gmail.com">
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputEmail1">Contact Number</label>
                        <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="(09)">
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputEmail1">Occupation</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="example@gmail.com">
                      </div>
                      <div class="row">
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Religion</label>
                                <select class="form-control" id="exampleFormControlSelect1">
                                    <option>Roman Catholic</option>
                                    <option>Islam</option>
                                    <option>Jehovah’s Witnesses</option>
                                    <option>Christian</option>
                                    <option>Iglesia ni Cristo (INC)</option>
                                    
                                  </select>
                              </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Civil Status</label>
                                <select class="form-control" id="exampleFormControlSelect1">
                                    <option>Single</option>
                                    <option>Married</option>
                                    <option>Widowed</option>
                                    <option>Divorced</option>
                                    <option>Annuled</option>
                                    <option>Seperated</option>
                                  </select>
                              </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Eligibility Status</label>
                                <select class="form-control" id="exampleFormControlSelect1">
                                    <option>PWD</option>
                                    <option>Single Parent</option>
                                    <option>Employed/Unemployed</option>
                                    <option>Student</option>
                                    <option>Senior Citizen</option>
                                    <option>Other</option>
                                  </select>
                              </div>
                        </div>
                      </div>
                      <br>

                      <div class="h4 mt-5 text-center" style="font-weight: 700;">Address</div>
                    
                    <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputEmail1">Block No.</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="example@gmail.com">
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Street Name</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password">
                      </div>
                      <div class="form-group mt-4" style="font-weight: 800;">
                        <label for="exampleInputPassword1">Subdivision/Village/Sitio (Optional)</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password">
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
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" class="learn" data-bs-toggle="modal"  style="padding: 5px 15px;" onclick="window.location.href='../../'">Okay</button>
               </div>
             
            </div>
          </div>
        </div>
    </div>


</body>
</html>