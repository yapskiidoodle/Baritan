r
<!-- connect database -->
<?php
require 'connect.php'; // Use 'include' or 'require' to load the file
    

?>

<!-- Get user Info -->

<?php

// Resident ID 



//Add Account
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEmail = $_POST['userEmail'];
    $password = $_POST['password'];
    $famName = $_POST['famName'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $middleInitial = $_POST['middleInitial'];
    $sex = $_POST['sex'];
    $birthday = $_POST['birthday'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $occupation = $_POST['occupation'];
    $religion = $_POST['religion'];
    $civilStatus = $_POST['civilStatus'];
    $eligibilityStatus = $_POST['eligibilityStatus'];
    $emergencyPerson = $_POST['emergencyPerson'];
    $emergencyContact = $_POST['emergencyContact'];
    $emergencyRelation = $_POST['emergencyRelation'];
    $emergencyAddress = $_POST['emergency Address'];
    $address = trim($_POST['block'] . ' ' . $_POST['street']. ' ' .$_POST['subdivision']);
    $idType = $_POST['idType'];


    $query = "SELECT MAX(Resident_ID) AS max_id FROM residents_information_tbl";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $autoIncrement = $row['max_id'] + 1; // Increment the latest ID

    // Auto incriment ID 

    $residentID = strtoupper(substr($famName, 0, 3)).date("Y"). "000" . $autoIncrement;
}




?>