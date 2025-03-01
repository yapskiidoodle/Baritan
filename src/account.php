<?php

require 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Use null-coalescing operator to prevent undefined array key errors
    $userEmail = $_POST['userEmail'] ?? '';
    $password = $_POST['password'] ?? '';
    $famName = $_POST['famName'] ?? '';

    $FirstName = $_POST['firstName'] ?? '';
    $MiddleName = $_POST['middleInitial'] ?? '';
    $LastName = $_POST['lastName'] ?? '';
    $Sex = $_POST['sex'] ?? '';
    $Date_of_Birth = $_POST['birthday'] ?? '';
    $Role = $_POST['role'] ?? '';
    $Contact_Number = $_POST['contact'] ?? '';
    $Resident_Email = $_POST['email'] ?? '';
    $Occupation = $_POST['occupation'] ?? '';
    $Religion = $_POST['religion'] ?? '';
    $Eligibility_Status = $_POST['eligibilityStatus'] ?? '';
    $Civil_Status = $_POST['civilStatus'] ?? '';
    $Emergency_Person = $_POST['emergencyPerson'] ?? '';
    $Emergency_Contact_No = $_POST['emergencyContact'] ?? '';
    $Emergency_Address = $_POST['emergencyAddress'] ?? ''; // Fixed typo
    $Relationship_to_Person = $_POST['emergencyRelation'] ?? '';
    $Address = trim($_POST['block'] ?? '' . ' ' . $_POST['street'] ?? '' . ' ' . $_POST['subdivision'] ?? '');
    $Valid_ID_Type = $_POST['idType'] ?? '';

    $residentFolder = "../resident_folder";
    $validIdFolder = $residentFolder . "/valid_id/";
    $picFolder = $residentFolder . "/2x2pic/";

    if (!file_exists($validIdFolder)) mkdir($validIdFolder, 0777, true);
    if (!file_exists($picFolder)) mkdir($picFolder, 0777, true);

    // Handle ID Front Upload
    $idFrontPath = $validIdFolder . basename($_FILES['idFront']['name'] ?? '');
    $idBackPath = $validIdFolder . basename($_FILES['idBack']['name'] ?? '');
    $picPath = $picFolder . basename($_FILES['2x2pic']['name'] ?? '');

    move_uploaded_file($_FILES['idFront']['tmp_name'] ?? '', $idFrontPath);
    move_uploaded_file($_FILES['idBack']['tmp_name'] ?? '', $idBackPath);
    move_uploaded_file($_FILES['2x2pic']['tmp_name'] ?? '', $picPath);

    $query = "SELECT MAX(Resident_ID) AS max_id FROM residents_information_tbl";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $autoIncrement = ($row['max_id'] ?? 0) + 1;

    $Resident_ID = strtoupper(substr($famName, 0, 3)) . date("Y") . "000" . $autoIncrement;

    // Fixed column names
    $sqlAddInfo = "INSERT INTO residents_information_tbl 
    (Resident_ID, FirstName, MiddleName, LastName, Sex, Date_of_Birth, Role, Contact_Number, 
    Resident_Email, Occupation, Religion, Eligibility_Status, Civil_Status, Emergency_Person, 
    Emergency_Contact_No, Emergency_Address, Relationship_to_Person, Address, Valid_ID_Type, 
    Valid_ID_Picture_Front, Valid_ID_Picture_Back, Pic_Path) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmtAdd = $conn->prepare($sqlAddInfo);

    if ($stmtAdd === false) {
        die("Error preparing SQL: " . $conn->error);
    }

    $stmtAdd->bind_param("ssssssssssssssssssssss", 
        $Resident_ID,
        $FirstName,
        $MiddleName,
        $LastName,
        $Sex,
        $Date_of_Birth,
        $Role,
        $Contact_Number,
        $Resident_Email,
        $Occupation,
        $Religion,
        $Eligibility_Status,
        $Civil_Status,
        $Emergency_Person,
        $Emergency_Contact_No,
        $Emergency_Address,
        $Relationship_to_Person,
        $Address,
        $Valid_ID_Type,
        $idFrontPath,
        $idBackPath,
        $picPath
    );

    if ($stmtAdd->execute()) {
        echo "Resident added successfully.";
    } else {
        echo "Error inserting data: " . $stmtAdd->error;
    }

    $stmtAdd->close();
    header("Location: ../index.php");
    exit();
}


?>