<!DOCTYPE html>
<html lang="en">
<head>
<?php

require '../src/connect.php'; // Use 'include' or 'require' to load the file
require '../src/account.php';
require '../src/residentInfo.php';



$FirstName = $_SESSION['User_Data']['FirstName'] ?? '';
$LastName = $_SESSION['User_Data']['LastName'] ?? '';
$Address = $userData['Address']?? '';
$userEmail =  $_SESSION['User_Data']['Resident_Email'] ?? '';


$familyID = $_SESSION['User_Data']['Family_Name_ID'] ?? '';



// Fetch residents with the same Family ID
$query = "SELECT Resident_ID, Resident_Email, Role FROM residents_information_tbl WHERE Family_Name_ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $familyID);
$stmt->execute();
$result = $stmt->get_result();

$members = [];
while ($row = $result->fetch_assoc()) {
    $members[] = $row;
}


?>

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
                   <div class="dropdown" id="profile" name="profile" hidden>
                        <button class="btn dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../pics/profile.jpg" alt="" style="border-radius: 50%; width: 30px;">
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                            <!--<li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li> -->
                            <li><a class="dropdown-item" href="profile.php" name="logoutButton"><i class="fas fa-sign-out-alt"></i> Profile</a></li>
                            <li><form action="../src/logout.php" method="POST"><button class="dropdown-item" href="index.php" name="logoutButton"><i class="fas fa-sign-out-alt"></i> Logout</button></li></form>

                        </ul>
                    </div>
                   <div id="start" name="start">
                        <button id="login" class="btn btn-danger ms-2" style="margin-top: -8.6%; width: 100%;">Log In</button>
                   </div>
               </div>
           </div>
        </div>
    </div>
    <!--END HEADER-->

    <?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success m-3" ><?= $_SESSION['success_message']; ?></div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger m-3"><?= $_SESSION['error_message']; ?></div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

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
            <div class="col-md-10" style=" text-align: left;">
                <div class="container d-inline ">
                    <h4 class="mt-4 "><?php echo sprintf("%s %s", $FirstName, $LastName); ?>
                       
                    </h4>
                    
                    <div class="h1 "> 
                
                       


                        <?php echo sprintf("%s", $LastName); ?> <div class="lead d-inline"> Family</div>
                        <div class="lead" style="font-size: 16px;">
                            <?php echo sprintf("%s", $userEmail); ?>
                        </div>
                        <div class="lead" style="font-size: 16px;">
                            <?php echo sprintf("%s", $Address); ?>

                        </div>
                    </div>
                   
                </div>
                <!-- <button class="button" style="margin-left: 10%;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-suit-heart-fill" viewBox="0 0 16 16" style="color: rgb(238, 255, 4);">
                                <path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1"/>
                              </svg>
                              <div class="lead d-inline ">
                                Change Head of the family
                              </div>
                        </button> -->
            </div>
            <div class="col" style="height: 100%;">
            <div class="d-flex justify-content-end mt-auto gap-2">
    <button type="button" id="switch_button" class="button mt-2" 
        style="padding: 0% 2%; font-size: 20px;" 
        data-bs-toggle="modal" data-bs-target="#account">
        Switch Account
    </button>
<!-- 
    <button type="button" id="edit_button" class="btn btn-warning text-white mt-2" 
        style="padding: 0% 2%; font-size: 20px;" 
        data-bs-toggle="modal" data-bs-target="#editModal">
        Edit Profile
    </button> -->

    <button type="button" id="add_account_button" class="button mt-2" 
        style="padding: 0% 2%; font-size: 20px;" 
        data-bs-toggle="modal" data-bs-target="#registerModal">
        Add Member
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
                <th scope="col">Remove</th>
              </tr>
            </thead>
            <tbody id="tableBody">
    <?php
   

    
   

    if ($familyID) {
        $query = "SELECT 
            Resident_ID,
            Address,
            FirstName,
            COALESCE(MiddleName, '') AS MiddleName,
            LastName,
            COALESCE(Suffix, '') AS Suffix,  -- ✅ ADDED Suffix
            Sex,
            Date_of_Birth,
            Role,
            Contact_Number,
            Resident_Email,
            Religion,
            Eligibility_Status,
            Civil_Status,
            Emergency_Person,
            Emergency_Contact_No,
            Relationship_to_Person,
            Emergency_Address,
            Occupation,
            TIMESTAMPDIFF(YEAR, Date_of_Birth, CURDATE()) AS Age
        FROM Residents_information_tbl
        WHERE Family_Name_ID = ?";

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Query preparation failed: " . $conn->error);
        }
        $stmt->bind_param("s", $familyID);
        $stmt->execute();
        $result = $stmt->get_result();

        $count = 0; // Row counter
        while ($row = $result->fetch_assoc()) {
            $count++;
            ?>
            <tr>
                <th scope="row"><?= $count ?></th>
                <td><?= htmlspecialchars($row['FirstName']) ?> 
                    <?= !empty($row['MiddleName']) ? htmlspecialchars(substr($row['MiddleName'], 0, 1)) . "." : "" ?>
                    <?= htmlspecialchars($row['LastName']) ?>
                    <?= !empty($row['Suffix']) ? htmlspecialchars($row['Suffix']) : "" ?>  <!-- ✅ SHOW SUFFIX -->
                </td>
                <td><?= htmlspecialchars($row['Role']) ?></td>
                <td>
                    <button class="btn btn-warning btn-sm" 
                        data-bs-toggle="modal" 
                        data-bs-target="#editModal"
                        onclick="populateEditModal(
                            '<?= htmlspecialchars($row['Resident_ID']) ?>', 
                            '<?= htmlspecialchars($row['FirstName']) ?>', 
                            '<?= htmlspecialchars($row['MiddleName']) ?>', 
                            '<?= htmlspecialchars($row['LastName']) ?>', 
                            '<?= htmlspecialchars($row['Suffix']) ?>',  /* ✅ ADDED SUFFIX */
                            '<?= htmlspecialchars($row['Sex']) ?>', 
                            '<?= htmlspecialchars($row['Date_of_Birth']) ?>', 
                            '<?= htmlspecialchars($row['Resident_Email']) ?>', 
                            '<?= htmlspecialchars($row['Contact_Number']) ?>', 
                            '<?= htmlspecialchars($row['Occupation']) ?>', 
                            '<?= htmlspecialchars($row['Religion']) ?>', 
                            '<?= htmlspecialchars($row['Eligibility_Status']) ?>', 
                            '<?= htmlspecialchars($row['Civil_Status']) ?>', 
                            '<?= htmlspecialchars($row['Address']) ?>', 
                            '<?= htmlspecialchars($row['Emergency_Person']) ?>', 
                            '<?= htmlspecialchars($row['Emergency_Contact_No']) ?>', 
                            '<?= htmlspecialchars($row['Relationship_to_Person']) ?>', 
                            '<?= htmlspecialchars($row['Emergency_Address']) ?>', 
                            '<?= htmlspecialchars($row['Role']) ?>'
                        )">
                        Edit
                    </button>
                </td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="confirmDelete('<?= htmlspecialchars($row['Resident_ID']) ?>')">
                        Remove
                    </button>
                </td>
            </tr>
            <?php
        }

        if ($count === 0) {  
            echo "<tr><td colspan='5' class='text-center'>No family members found.</td></tr>";
        }

        $stmt->close();
    } else {
        echo "<tr><td colspan='5' class='text-center'>No family members found.</td></tr>";
    }
    ?>
</tbody>
          </table>
    </div>
    












 
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

<!-- Edit Resident Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editResidentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1C3A5B; color: white;">
                <h5 class="modal-title text-center" id="editResidentModalLabel">Edit Resident Information</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="editResidentForm" action="../src/editProfile.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><strong>Resident ID:</strong></label>
                                <input type="text" class="form-control" id="editResidentId" name="residentID" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>First Name:</strong></label>
                                <input type="text" class="form-control" id="editResidentFirstName" name="first_name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Middle Name:</strong></label>
                                <input type="text" class="form-control" id="editResidentMiddleName" name="middle_name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Last Name:</strong></label>
                                <input type="text" class="form-control" id="editResidentLastName" name="last_name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Suffix:</strong></label>
                                <input type="text" class="form-control" id="editResidentSuffix" name="suffix">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Age:</strong></label>
                                <input type="text" class="form-control" id="editResidentAge" name="age" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Sex:</strong></label>
                                <select class="form-select" id="editResidentSex" name="sex">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Date of Birth:</strong></label>
                                <input type="date" class="form-control" id="editResidentDob" name="dob">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><strong>Role:</strong></label>
                                <select class="form-control" id="editResidentRole" name="role">
                                    <option value="Head">Head of the Family</option>
                                    <option value="Father">Father</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Daughter">Daughter</option>
                                    <option value="Son">Son</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Address:</strong></label>
                                <input type="text" class="form-control" id="editResidentAddress" name="address">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Occupation:</strong></label>
                                <input type="text" class="form-control" id="editResidentOccupation" name="occupation">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Eligibility Status:</strong></label>
                                <!-- <input type="text" class="form-control" id="editResidentEligibility" name="eligibility_status"> -->
                                <select class="form-control" id="editResidentEligibility" name="eligibility_status">
                                  <option value="Person with Disability">PWD (Person with Disability)</option>
                                  <option value="Single Parent">Single Parent</option>
                                  <option value="Employed">Employed</option>
                                  <option value="Unemployed">Unemployed</option>
                                  <option value="Student">Student</option>
                                  <option value="Senior Citizen">Senior Citizen</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Civil Status:</strong></label>
                                <select class="form-select" id="editResidentCivilStatus" name="civil_status">
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Contact Number:</strong></label>
                                <input type="text" class="form-control" id="editResidentContact" name="contact_number">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Email:</strong></label>
                                <input type="email" class="form-control" id="editResidentEmail" name="email">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Religion:</strong></label>
                                <!-- <input type="text" class="form-control" id="editResidentReligion" name="religion"> -->
                                <select class="form-control" id="editResidentReligion" name="religion">
                                    <option value="Roman Catholic" >Roman Catholic</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Jehovah’s Witnesses">Jehovah’s Witnesses</option>
                                    <option value="Christian">Christian</option>
                                    <option value="Iglesia ni Cristo (INC)">Iglesia ni Cristo (INC)</option>
                                    
                                  </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <h6 class="text-center" style="color: #1C3A5B; font-weight: bold;">Emergency Contact</h6>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Emergency Contact Person:</strong></label>
                                <input type="text" class="form-control" id="editResidentEmergencyPerson" name="emergency_person">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Emergency Contact Number:</strong></label>
                                <input type="text" class="form-control" id="editResidentEmergencyContact" name="emergency_contact">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Relationship:</strong></label>
                                <input type="text" class="form-control" id="editResidentRelationship" name="relationship">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label"><strong>Address of the Emergency Contact:</strong></label>
                                <input type="text" class="form-control" id="editResidentEmergencyAddress" name="emergencyAddress">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function setInputValue(id, value) {
    let input = document.getElementById(id);
    if (input) {
        input.value = value || "";
    } else {
        console.warn(`Element not found: ${id}`);
    }
}

function setSelectValue(id, value) {
    let select = document.getElementById(id);
    if (select) {
        let optionExists = [...select.options].some(option => option.value === value);
        select.value = optionExists ? value : select.options[0].value;
    } else {
        console.warn(`Dropdown not found: ${id}`);
    }
}

function calculateAge(dob) {
    if (!dob) return 'N/A';
    let birthDate = new Date(dob);
    let today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    if (today.getMonth() < birthDate.getMonth() || 
        (today.getMonth() === birthDate.getMonth() && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}
function populateEditModal(
    residentId, firstName, middleName, lastName, suffix,  
    sex, dob, email, contact, occupation, religion, 
    eligibility, civilStatus, address, emergencyPerson, 
    emergencyContact, relationship, emergencyAddress, role
) {
    document.getElementById('editResidentId').value = residentId;
    document.getElementById('editResidentFirstName').value = firstName;
    document.getElementById('editResidentMiddleName').value = middleName;
    document.getElementById('editResidentLastName').value = lastName;
    document.getElementById('editResidentSuffix').value = suffix || "";  
    document.getElementById('editResidentSex').value = sex;
    document.getElementById('editResidentDob').value = dob;
    document.getElementById('editResidentEmail').value = email;
    document.getElementById('editResidentContact').value = contact;
    document.getElementById('editResidentOccupation').value = occupation;
    document.getElementById('editResidentReligion').value = religion;
    document.getElementById('editResidentEligibility').value = eligibility;
    document.getElementById('editResidentCivilStatus').value = civilStatus;
    document.getElementById('editResidentAddress').value = address;
    document.getElementById('editResidentEmergencyPerson').value = emergencyPerson;
    document.getElementById('editResidentEmergencyContact').value = emergencyContact;
    document.getElementById('editResidentRelationship').value = relationship;
    document.getElementById('editResidentEmergencyAddress').value = emergencyAddress;
    document.getElementById('editResidentRole').value = role;

    // ✅ Calculate and set Age  
    document.getElementById('editResidentAge').value = calculateAge(dob);
}

function setSelectValue(id, value) {
    let select = document.getElementById(id);
    if (select) {
        select.value = value || select.options[0].value; // Default to the first option if empty
    }
}


</script>





<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalTitle">
    <div class="modal-dialog modal-dialog-centered" role="document" >
      <div class="modal-content"  style="width:  280%;  ">
        <div class="modal-header">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="40" fill="currentColor" class="bi bi-info" viewBox="0 0 16 16">
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
              </svg>
          <h5 class="modal-title" id="exampleModalLongTitle">Privacy Notice
            
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class=" tc_body">
                <ol>
                  <li>
                    <h3>Terms of use</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, quidem doloribus cumque vero, culpa voluptates dolorum reprehenderit nihil nisi odit necessitatibus voluptate voluptatibus magni ducimus sed accusamus illo nobis veniam.</p>
                  </li>
                  <li>
                    <h3>Intellectual property rights</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, quidem doloribus cumque vero, culpa voluptates dolorum reprehenderit nihil nisi odit necessitatibus voluptate voluptatibus magni ducimus sed accusamus illo nobis veniam.</p>
                  </li>
                  <li>
                    <h3>Prohibited activities</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, quidem doloribus cumque vero, culpa voluptates dolorum reprehenderit nihil nisi odit necessitatibus voluptate voluptatibus magni ducimus sed accusamus illo nobis veniam.</p>
                  </li>
                  <li>
                    <h3>Termination clause</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, quidem doloribus cumque vero, culpa voluptates dolorum reprehenderit nihil nisi odit necessitatibus voluptate voluptatibus magni ducimus sed accusamus illo nobis veniam.</p>
                  </li>
                  <li>
                    <h3>Governing law</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, quidem doloribus cumque vero, culpa voluptates dolorum reprehenderit nihil nisi odit necessitatibus voluptate voluptatibus magni ducimus sed accusamus illo nobis veniam.</p>
                  </li>
                </ol>
              </div>
        </div>
        <div class="modal-footer">
         
                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="termsCheckbox">
                            <label class="form-check-label" for="termsCheckbox">
                              I have read and agree to the <br>  <a href="#" style="text-decoration: none;color: #94c8ff; ">Terms and Conditions</a>
                            </label>
                          </div>
                          
                    </div>
                    <div class="col text-center" >
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.reload();">Close</button>
                        <button type="button" class="btn btn-primary" id="submitBtn" disabled style="background-color: #1C3A5B;" data-bs-dismiss="modal" >I Accept</button>
                    
                    </div>
                </div>

                <script>
    document.getElementById("termsCheckbox").addEventListener("change", function() {
        let submitBtn = document.getElementById("submitBtn");
        submitBtn.disabled = !this.checked;
    });

    document.getElementById("submitBtn").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent default behavior (useful in forms)
   
        // Close the current modal
        var registerModal = new bootstrap.Modal(document.getElementById("registerModal"));
        registerModal.hide();  // Close the register modal
        
        // Open the next modal (questionModal)
        var questionModal = new bootstrap.Modal(document.getElementById("questionModal"));
        questionModal.show();  // Open the question modal
    });
</script>
        
                
 
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="registerModalTitle">
    <div class="modal-dialog modal-dialog-centered" role="document">
   

        <div class="modal-content">
            <div class="modal-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="40" fill="currentColor" class="bi bi-info" viewBox="0 0 16 16">
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg>
                <h5 class="modal-title" id="exampleModalLongTitle">Add Member</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Initial text showing options -->
                <p>If you choose "With Account," you will be asked to set a password. If you choose "Without Account," no password will be required.</p>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <!-- Close Button -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.reload();">Close</button>
                </div>

                <div class="text-center mt-3">
                    <!-- Grouped Buttons for With and Without Account -->
                   
                        <div class="btn-group" role="group">
                        <form action="addMember.php" method="POST" id="accountForm">
                            <input type="hidden" id="accountTypeField" name="accountType" value="">
                            <button type="submit" class="btn btn-primary" onclick="setAccountType('with')">With Account</button>
                            <button type="submit" class="btn btn-primary" onclick="setAccountType('without')">Without Account</button>
                        </form>

                        <script>
                            function setAccountType(value) {
                                document.getElementById('accountTypeField').value = value;
                            }
                        </script>
                        </div>
              

                    
                </div>
            </div>
        </div>

    </div>
</div>




  <script>
    document.getElementById("accountForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Stop default form submission
    this.submit(); // Manually submit
});

    function validateForm() {
    return true; // Ensures the form actually submits
}


    document.addEventListener("DOMContentLoaded", function () {
        var profile = document.getElementById("profile");
        var start = document.getElementById("start");

        <?php if (isset($_SESSION['userEmail'])) { ?>
            profile.hidden = false;
            start.hidden = true;
        <?php } else { ?>
            profile.hidden = true;
            start.hidden = false;
        <?php } ?>
    });

    $(document).ready(function () {
    $("#saveChanges").click(function (event) {
        var firstInvalid = validateInputs();

        if (firstInvalid) {
            event.preventDefault(); // Prevent form submission if there are errors
            firstInvalid.focus(); // Focus on the first invalid field
        }
    });
});

$(document).ready(function () {
    $("#saveChanges").click(function (event) {
        var firstInvalid = validateInputs();

        if (firstInvalid) {
            event.preventDefault(); // Prevent form submission if there are errors
            firstInvalid.focus(); // Focus on the first invalid field
        }
    });
});

function validateInputs() {
    var firstInvalid = null;
    var specialCharRegex = /[^a-zA-Z0-9ñ ]/; // Allows only letters, numbers, and space
    var specialCharRegexEmail = /[^a-zA-Z0-9@.]/; // Allows only letters, numbers, @, and .
    var passwordRegex = /^(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/; // Password: 8+ chars, 1 uppercase, 1 special char
    var allValid = true;

    $("input[required], select[required]").each(function () {
        var value = $(this).val().trim();
        var inputType = $(this).attr("type");
        var inputId = $(this).attr("id");
        var isEmail = inputType === "email";
        var isPassword = inputId === "password" || inputId === "rePassword";
        var isDate = inputType === "date" || inputId.toLowerCase().includes("date");
        var feedbackSpan = $(this).next(".invalid-feedback");

        // Empty field
        if (!value) {
            showError(this, "This field is required.");
            allValid = false;
            if (!firstInvalid) firstInvalid = this;
        } 
        // Email validation
        else if (isEmail && specialCharRegexEmail.test(value)) {
            showError(this, "Only letters, numbers, @, and . are allowed.");
            allValid = false;
            if (!firstInvalid) firstInvalid = this;
        } 
        // Password validation
        else if (isPassword && !passwordRegex.test(value)) {
            showError(this, "Password must be at least 8 characters, contain an uppercase letter, and a special character.");
            allValid = false;
            if (!firstInvalid) firstInvalid = this;
        } 
        // Allow dates to have special characters
        else if (!isEmail && !isPassword && !isDate && specialCharRegex.test(value)) {
            showError(this, "Special characters are not allowed.");
            allValid = false;
            if (!firstInvalid) firstInvalid = this;
        } 
        // Password confirmation
        else if (inputId === "rePassword") {
            validatePasswords();
        } 
        // Valid input
        else {
            removeError(this);
        }
    });

    return allValid ? null : firstInvalid;
}

// ✅ Password matching check
function validatePasswords() {
    var password = $("#password").val();
    var rePassword = $("#rePassword").val();
    var rePasswordField = $("#rePassword");

    if (!password || !rePassword) return;

    if (password !== rePassword) {
        showError(rePasswordField, "Passwords do not match.");
    } else {
        removeError(rePasswordField);
    }
}

// ✅ Show error message
function showError(element, message) {
    $(element).addClass("is-invalid").removeClass("is-valid");
    $(element).next(".invalid-feedback").remove();
    $(element).after('<div class="invalid-feedback">' + message + '</div>');
}

// ✅ Remove error message
function removeError(element) {
    $(element).removeClass("is-invalid").addClass("is-valid");
    $(element).next(".invalid-feedback").remove();
}
    
</script>





</body>
</html>