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
        <div class="display-4 " style="font-weight: 700;">Document Issuance</div>
        <div class="container w-75 mt-5">

            <form action="">
        
   

      
            <div class="container " style="text-align: left;">


                <div class="tab " style="background-color: white;">
                    <div class="h4 mt-5 text-center" style="font-weight: 700;">Login Details</div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;" id="type">
                                <label for="exampleInputEmail1">Document Type</label>
                                <select class="form-control" id="documentType">
                                    <option >-Choose-</option>
                                    <option value="indigency">Indigency</option>
                                    <option value="clearance">Clearance/Certificate/Permit</option>
                                </select>
                              </div>
                        </div>
                        <div class="col" id="indigency" hidden> 
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputEmail1">Indigency</label>
                                <select class="form-control" id="exampleFormControlSelect1">
                                    <option value="financial_assistance">Financial Assistance</option>
                                    <option value="medical_assistance">Medical Assistance</option>
                                    <option value="educational_assistance">Educational Assistance</option>
                                    <option value="social_pension_requirement">Social Pension Requirement</option>
                                    <option value="burial_assistance">Burial Assistance</option>
                                    <option value="pwd_id_requirement">P.W.D ID Requirement</option>
                                    <option value="anti_rabies_vaccination">Anti Rabies Vaccination</option>
                                    <option value="requirement">Requirement</option>
                                    <option value="legal_assistance">Legal Assistance</option>
                                    <option value="4ps_requirement">4P's Requirement</option>
                                    <option value="osca_requirement">OSCA Requirement</option>
                                    <option value="solo_parent_id_requirement">Solo Parent ID Requirement</option>
                                    <option value="drug_test_requirement">Drug Test Requirement</option>
                                </select>
                              </div>
                        </div>
                        <div class="col" id="clearance" hidden> 
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputEmail1">Clearance</label>
                                <select class="form-control" id="exampleFormControlSelect1">
                                    <option value="sss_requirements">SSS REQUIREMENTS</option>
                                    <option value="philhealth_requirements">PHILHEALTH REQUIREMENTS</option>
                                    <option value="demolition_permit">DEMOLITION PERMIT</option>
                                    <option value="business_permit_closure">BUSINESS PERMIT/BUSINESS CLOSURE</option>
                                    <option value="loan_requirements">LOAN REQUIREMENTS</option>
                                    <option value="bank_requirements">BANK REQUIREMENTS</option> 
                                </select>
                              </div>
                        </div>
                    </div>
                      
                      
                     
                      <br>


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
                
                

                <div class="d-flex mt-5">
                    <button type="button" id="back_button" onclick="window.location.href='../service.php'" class="button mt-2">
                        Back
                    </button>
                    <button type="button" id="next_button" class="button ms-auto mt-2" data-bs-target="#confirmation"data-bs-toggle="modal" >Finish</button>
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
                    <button type="button" class="learn" data-bs-toggle="modal"  style="padding: 5px 15px;" onclick="window.location.href='../../'">Okay</button>
               </div>
             
            </div>
          </div>
        </div>
      </div>









    <script> 

    
        
        document.getElementById("documentType").addEventListener("change", function() {
    var type = this.value; // Get selected value
    document.getElementById("indigency").hidden = type !== "indigency";
    document.getElementById("clearance").hidden = type !== "clearance";
});
            </script>




</body>
</html>