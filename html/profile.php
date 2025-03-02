<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../pics/logo.png">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../design.css"> 

    <title>Register</title>
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



    <div class="container mt-5 text-center" style="background-color: white; padding: 3%; margin-bottom: 5%;"> 
        <div class="container d-flex justify-content-end">
           <button class="btn btn-warning rounded-pill ">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="45" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16" style="color: white;">
                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901"/>
            </svg> 
           </button>
        </div>
        
        <div class="row " style=" width: 95%; height: auto; margin: auto; padding: 10px;"> 
            <div class="col-md-2 mt-4" >
                <img src="../pics/profile.jpg" style="border-radius: 50%; width: 150px;">
            </div>
            <div class="col-md-6" style=" text-align: left;">
                <div class="container d-inline ">
                    <h4 class="mt-4 ">Juan Dela Cruz
                        <button class="button" style="margin-left: 10%;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-suit-heart-fill" viewBox="0 0 16 16" style="color: rgb(238, 255, 4);">
                                <path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1"/>
                              </svg>
                              <div class="lead d-inline ">
                                Change Head of the family
                              </div>
                        </button>
                    </h4>
                    
                    <div class="h1 "> 
                        
                       


                        Dela Cruz <div class="lead d-inline"> Family</div>
                        <div class="lead" style="font-size: 16px;">
                            juandelacruz@gmail.com
                        </div>
                        <div class="lead" style="font-size: 16px;">
                            123, Barangay Baritan, Malabon City
                        </div>
                    </div>
                   
                </div>
 
            </div>
            <div class="col-md-4" style="height: 100%; margin-top: 15%;">
                <div class="d-flex mt-auto">
                    <button type="button" id="back_button" onclick="" class="button me-auto mt-2" style="padding: 0% 2%; font-size: 20px;" data-bs-toggle="modal" data-bs-target="#account">
                        Switch Account
                    </button>
                    <button type="button" id="next_button" class="btn btn-warning text-white mt-2" data-bs-toggle="modal" data-bs-target="#confirmation" style="padding: 0% 2%; font-size: 20px;">
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>
        <hr>
        <div class="display-5" style="text-align: left;">
            Family Members
        </div>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Email</th>
                <th scope="col">Relationship</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody id="tableBody">
              <tr>
                
               
              </tr>
            </tbody>
          </table>
    </div>
    <script>
        // Function to generate a random email
        function getRandomEmail() {
            const domains = ["gmail.com", "yahoo.com", "outlook.com", "example.com"];
            const names = ["john", "jane", "alex", "mike", "sara", "emma", "chris", "lisa"];
            return names[Math.floor(Math.random() * names.length)] + Math.floor(Math.random() * 100) + "@" + domains[Math.floor(Math.random() * domains.length)];
        }
    
        // Function to generate a random relationship
        function getRandomRelationship() {
            const relationships = ["Parent", "Sibling", "Friend", "Colleague", "Cousin", "Neighbor"];
            return relationships[Math.floor(Math.random() * relationships.length)];
        }
    
        // Function to populate the table with random data
        function populateTable(rows = 5) {
            const tableBody = document.getElementById("tableBody");
            tableBody.innerHTML = ""; // Clear previous data
    
            for (let i = 1; i <= rows; i++) {
                const row = document.createElement("tr");
    
                row.innerHTML = `
                    <th scope="row">${i}</th>
                    <td>${getRandomEmail()}</td>
                    <td>${getRandomRelationship()}</td>
                    <td><button class="btn btn-warning btn-sm">Edit</button></td>
                    <td><button class="btn btn-danger btn-sm">Delete</button></td>
                `;
    
                tableBody.appendChild(row);
            }
        }
    
        // Call the function to populate table with random data
        populateTable(10);
    </script>


 
<!-- Modal -->
<div class="modal fade" id="account" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select Account</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row " style="text-align: center;">
            <div class="col-md-6">
               <a data-bs-dismiss="modal">
                <img src="../pics/profile.jpg" alt="" style="width: 85px;">
                <div class="lead">Juan </div>
               </a>
            </div>
            <div class="col-md-6">
                <a data-bs-dismiss="modal">
                 <img src="../pics/profile.jpg" alt="" style="width: 85px;">
                 <div class="lead">Juan </div>
                </a>
             </div>
             <div class="col-md-6">
                <a data-bs-dismiss="modal">
                 <img src="../pics/profile.jpg" alt="" style="width: 85px;">
                 <div class="lead">Juan </div>
                </a>
             </div>
             <div class="col-md-6">
                <a data-bs-dismiss="modal">
                 <img src="../pics/profile.jpg" alt="" style="width: 85px;">
                 <div class="lead">Juan </div>
                </a>
             </div>
             <div class="col-md-6">
                <a data-bs-dismiss="modal">
                 <img src="../pics/profile.jpg" alt="" style="width: 85px;">
                 <div class="lead">Juan </div>
                </a>
             </div>
          </div>
          
         
        </div>
        <div class="modal-footer">
          
        </div>
      </div>
    </div>
  </div>

   


</body>
</html>