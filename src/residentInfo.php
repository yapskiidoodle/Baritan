<?php

require 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve Form Data
    $userEmail = $_POST['userEmail'] ?? '';
    $password = $_POST['password'] ?? '';
    $LastName = $_POST['lastName'] ?? '';
    $FamilyName = $_POST['famName'] ?? '';

    $FirstName = $_POST['firstName'] ?? '';
    $MiddleName = $_POST['middleInitial'] ?? '';
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
    $Emergency_Address = $_POST['emergencyAddress'] ?? '';
    $Relationship_to_Person = $_POST['emergencyRelation'] ?? '';
    $Address = trim(($_POST['block'] ?? '') . ' ' . ($_POST['street'] ?? '') . ' ' . ($_POST['subdivision'] ?? ''));
    $Valid_ID_Type = $_POST['idType'] ?? '';

    // Secure Password Hashing
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // ✅ Generate Resident ID
    $query = "SELECT COUNT(*) AS total FROM residents_information_tbl";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $residentCount = ($row['total'] ?? 0) + 1;
    $Resident_ID = strtoupper(substr($LastName, 0, 3)) . date("Y") . str_pad($residentCount, 3, "0", STR_PAD_LEFT);

    // ✅ Calculate Age
    $dob = new DateTime($Date_of_Birth);
    $today = new DateTime();
    $Age = $today->diff($dob)->y;

    // ✅ Insert into `account_tbl` FIRST
    $queryAcc = "SELECT MAX(CAST(SUBSTRING(Account_ID, -3) AS UNSIGNED)) AS max_id FROM account_tbl";
    $resultAcc = mysqli_query($conn, $queryAcc);
    $rowAcc = mysqli_fetch_assoc($resultAcc);
    $accountCount = ($rowAcc['max_id'] ?? 0) + 1;
    $Account_ID = "FAM" . date("Y") . str_pad($accountCount, 3, "0", STR_PAD_LEFT);

    $sqlAccount = "INSERT INTO account_tbl (Account_ID, Role, Type, User_Email, Password, Status) 
                   VALUES (?, ?, ?, ?, ?, ?)";
    $stmtAccount = $conn->prepare($sqlAccount);
    $Account_Type = "Family Account";
    $AccountStatus = "Deactivated";
    $stmtAccount->bind_param("ssssss", $Account_ID, $Role, $Account_Type, $userEmail, $hashedPassword, $AccountStatus);

    if (!$stmtAccount->execute()) {
        die("Error inserting into account_tbl: " . $stmtAccount->error);
    }

    // ✅ Insert into `residents_information_tbl`
    $sqlAddInfo = "INSERT INTO residents_information_tbl 
        (Resident_ID, FirstName, MiddleName, LastName, Sex, Date_of_Birth, Role, Contact_Number, 
        Resident_Email, Occupation, Religion, Eligibility_Status, Civil_Status, Emergency_Person, 
        Emergency_Contact_No, Emergency_Address, Relationship_to_Person, Address, Valid_ID_Type, Age) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmtAddInfo = $conn->prepare($sqlAddInfo);
    if (!$stmtAddInfo) {
        die("Error preparing SQL: " . $conn->error);
    }

    $stmtAddInfo->bind_param("ssssssssssssssssssss", 
        $Resident_ID, $FirstName, $MiddleName, $LastName, $Sex, $Date_of_Birth, $Role, $Contact_Number,
        $Resident_Email, $Occupation, $Religion, $Eligibility_Status, $Civil_Status, $Emergency_Person,
        $Emergency_Contact_No, $Emergency_Address, $Relationship_to_Person, $Address, $Valid_ID_Type, $Age
    );

    if (!$stmtAddInfo->execute()) {
        die("Error inserting into residents_information_tbl: " . $stmtAddInfo->error);
    }

    // ✅ Generate Family Name ID
    $queryFam = "SELECT COUNT(*) AS totalFam FROM family_name_tbl";
    $resultFam = mysqli_query($conn, $queryFam);
    $rowFam = mysqli_fetch_assoc($resultFam);
    $familyCount = ($rowFam['totalFam'] ?? 0) + 1;
    $Family_Name_ID = strtoupper(substr($FamilyName, 0, 3)) . date("Y") . str_pad($familyCount, 3, "0", STR_PAD_LEFT);

    // ✅ Insert into `family_name_tbl`
    $sqlFamily = "INSERT INTO family_name_tbl (Family_Name_ID, Resident_ID, Account_ID, Family_Name, Status) 
                  VALUES (?, ?, ?, ?, ?)";
    $stmtFamily = $conn->prepare($sqlFamily);
    if (!$stmtFamily) {
        die("Error preparing family table SQL: " . $conn->error);
    }

    $status = "Inactive";
    $stmtFamily->bind_param("sssss", $Family_Name_ID, $Resident_ID, $Account_ID, $FamilyName, $status);

    if (!$stmtFamily->execute()) {
        die("Error inserting into family_name_tbl: " . $stmtFamily->error);
    }

    echo "<script>alert('Registration successful!'); window.location.href = '../index.php';</script>";
    exit();
}
?>
