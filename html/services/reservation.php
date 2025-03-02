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
        <div class="display-4 " style="font-weight: 700;">Reservation</div>
        <div class="container w-75 mt-5">

            <form action="">
        
   

      
            <div class="container " style="text-align: left;">


                <div class="tab " style="background-color: white;">
                    <div class="h4 mt-5 text-center" style="font-weight: 700;">Please Input the reservation details</div>
                    <div class="row">
                        <div class="col-12">
                                <div class="form-group mt-4" style="font-weight: 800;">
                                    <label for="exampleInputPassword1">Recievers Name</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="FName M.I. LName">
                                  </div>
                       
                        </div>
                        <div class="col-9">
                            <div class="col w-100">
                                <div class="form-group mt-4" style="font-weight: 800;">
                                    <label for="exampleInputPassword1">What to reserve? 
                                        <div class="lead d-inline" style="font-size: 15px;">(Equipment/Facility)</div>

                                    </label>
                                    <select class="form-control" >
                                        <option >--Choose--</option>
                                        <option value="table">Table</option>
                                        <option value="chair">Chair</option>
                                        <option value="tent">Tent</option>
                                        <option value="sound_system">Sound System</option>
                                        <option value="covered_court">Covered Court</option>
                                        <option value="multipurpose_hall">Multipurpose Hall</option>
    
                                      </select>
                                  </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="col w-100">
                                <div class="form-group mt-4" style="font-weight: 800;">
                                    <label for="exampleInputPassword1">Quantity</label> 
                                    <input type="number" class="form-control" id="exampleInputPassword1">
                                  </div>
                            </div>
                        </div>
                    </div>
                      
                    
                    <div class="form-group mt-4" style="font-weight: 800;">
                                        
                        <label for="exampleInputEmail1">Venue
                            <div class="lead d-inline" style="font-size: 15px;">(For Equipment Reservation Only)</div>
                        </label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="eg. Multipurpose hall, Jose Str., Court">
                      </div>
                      <div class="row">
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Date to Reserve</label>
                                <input type="date" class="form-control" id="exampleInputPassword1">
                              </div>  
                        </div>
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="exampleInputPassword1">Date to Return</label>
                                <input type="date" class="form-control" id="exampleInputPassword1" >
                              </div>
                        </div>
                        <div class="col">
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="purpose">Purpose of Reservation</label>
                                <select class="form-control" id="purpose">
                                    <option value="">--Choose--</option>
                                    <option value="birthday_celebration">Birthday Celebration</option>
                                    <option value="community_meeting">Community Meeting</option>
                                    <option value="wedding_ceremony">Wedding Ceremony</option>
                                    <option value="sports_event_tournament">Sports Event/Tournament</option>
                                    <option value="funeral">Funeral</option>
                                    <option value="other">Other (please specify)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col" id="other" hidden>
                            <div class="form-group mt-4" style="font-weight: 800;">
                                <label for="otherInput">Please Specify</label>
                                <input type="text" class="form-control" id="otherInput">
                            </div>
                        </div>
                        
                        <script>
                            document.getElementById("purpose").addEventListener("change", function() {
                                var type = this.value;
                                document.getElementById("other").hidden = type !== "other";
                            });
                        </script>

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
                    <button type="button" class="learn" data-bs-toggle="modal"  style="padding: 5px 15px;" onclick="window.location.href='../../'">Okay</button>
               </div>
             
            </div>
          </div>
        </div>
      </div>









  




</body>
</html>