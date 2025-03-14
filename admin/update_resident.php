<?php
// update_resident.php
require ('../src/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resident_id = $_POST['resident_id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $sex = $_POST['sex'];
    $dob = $_POST['dob'];
    $role = $_POST['role'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $religion = $_POST['religion'];
    $eligibility_status = $_POST['eligibility_status'];
    $civil_status = $_POST['civil_status'];
    $emergency_person = $_POST['emergency_person'];
    $emergency_contact = $_POST['emergency_contact'];
    $relationship = $_POST['relationship'];
    $address = $_POST['address'];

    $sql = "UPDATE Residents_information_tbl SET
            FirstName = '$first_name',
            MiddleName = '$middle_name',
            LastName = '$last_name',
            Sex = '$sex',
            Date_of_Birth = '$dob',
            Role = '$role',
            Contact_Number = '$contact_number',
            Resident_Email = '$email',
            Religion = '$religion',
            Eligibility_Status = '$eligibility_status',
            Civil_Status = '$civil_status',
            Emergency_Person = '$emergency_person',
            Emergency_Contact_No = '$emergency_contact',
            Relationship_to_Person = '$relationship',
            Address = '$address'
            WHERE Resident_ID = '$resident_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Resident updated successfully');
                window.location.href = 'residents.php';
              </script>";
    } else {
        echo "<script>
                alert('Error updating resident: " . $conn->error . "');
                window.history.back(); // Go back to the previous page
              </script>";
    }
}
?>