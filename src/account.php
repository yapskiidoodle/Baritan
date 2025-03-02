<?php
require 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $Resident_ID = $_GET['resident_id'] ?? '';
    $Family_Name_ID = $_GET['fam_id'] ?? '';
    $Account_ID = $_GET['account_id'] ?? '';
    $Role = $_GET['role'] ?? '';
    $FamilyName = $_GET['fam_name'] ?? '';
    $UserEmail = $_GET['email'] ?? '';
    $Password = $_GET['password'] ?? '';

    // Insert into family_name_tbl
    $sqlFamily = "INSERT INTO family_name_tbl (Family_Name_ID, Resident_ID, Account_ID, Family_Name, Status) VALUES (?, ?, ?, ?, ?)";
    $stmtFamily = $conn->prepare($sqlFamily);
    $status = "Inactive";
    
    if (!$stmtFamily) {
        die("Hi Error preparing family_name_tbl SQL: " . $conn->error);
    }

    $stmtFamily->bind_param("sssss", $Family_Name_ID, $Resident_ID, $Account_ID, $FamilyName, $status);

    if (!$stmtFamily->execute()) {
        die("Error inserting into family_name_tbl: " . $stmtFamily->error);
    }

    // Insert into account_tbl
    $sqlAccount = "INSERT INTO account_tbl (Account_ID, Role, Type, User_Email, Password, Status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmtAccount = $conn->prepare($sqlAccount);
    $Account_Type = "Family Account";
    $AccountStatus = "Deactivated";

    if (!$stmtAccount) {
        die("Error preparing account_tbl SQL: " . $conn->error);
    }

    $stmtAccount->bind_param("ssssss", $Account_ID, $Role, $Account_Type, $UserEmail, $Password, $AccountStatus);

    if (!$stmtAccount->execute()) {
        die("Error inserting into account_tbl: " . $stmtAccount->error);
    }

    echo "<script>alert('Registration successful!'); window.location.href = '../index.php';</script>";
    exit();
}
?>