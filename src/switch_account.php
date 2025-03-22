<?php
require 'connect.php';
require 'account.php';

session_regenerate_id(true);

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request method!");
}


// Ensure Resident_ID is provided
if (!isset($_POST['Resident_ID'])) {
    die("Invalid request! Resident_ID is required.");
}

$residentID = $_POST['Resident_ID'];
$enteredPassword = $_POST['passwordMember'] ?? ''; // Get entered password if provided

// Fetch resident data
$query = "SELECT 
    r.Resident_ID, r.FirstName, r.MiddleName, r.LastName, r.Suffix, 
    r.Sex, r.Date_of_Birth, r.Resident_Email, r.Contact_Number, 
    r.Occupation, r.Religion, r.Civil_Status, r.Eligibility_Status, r.Address, r.Age, 
    r.Emergency_Person, r.Emergency_Contact_No, r.Emergency_Address, 
    r.Relationship_to_Person, r.Valid_ID_Type, r.Valid_ID_Picture_Front, 
    r.Valid_ID_Picture_Back, r.Pic_Path, r.Role AS Resident_Role, 
    r.Family_Name_ID, f.Account_ID, a.Role AS Account_Role, a.Type AS Account_Type, 
    a.User_Email, a.Status AS Account_Status, asettings.Member_Password
  FROM residents_information_tbl r
  LEFT JOIN family_name_tbl f ON r.Family_Name_ID = f.Family_Name_ID
  LEFT JOIN account_tbl a ON f.Account_ID = a.Account_ID
  LEFT JOIN account_setting_tbl asettings ON a.Account_ID = asettings.Account_ID
  WHERE r.Resident_ID = ?"; 

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("🔥 SQL Error: " . $conn->error);
}

// Bind the parameter
$stmt->bind_param("s", $residentID);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if the user exists
if (!$user) {
    die("Error: User not found.");
}

// Check if the user is a head
$isHead = $user['Resident_Role'] === 'Head';

// If the user is NOT the head, verify their password
if (!$isHead) {
    if (empty($enteredPassword)) {
        var_dump($enteredPassword);
        die("Error: Password is required for non-head users.");
    }

    // Verify password (assuming it's stored as a hash)
    if (!password_verify($enteredPassword, $user['Member_Password'])) {
        die("Error: Incorrect password.");
    }
}

// If validation passes, update session data
$_SESSION['User_Data'] = [
    'Account_ID' => $user['Account_ID'],
    'Account_Role' => $user['Account_Role'],
    'Family_Name_ID' => $user['Family_Name_ID'],
    'Resident_ID' => $user['Resident_ID'],
    'FirstName' => $user['FirstName'],
    'MiddleName' => $user['MiddleName'],
    'LastName' => $user['LastName'],
    'Sex' => $user['Sex'],
    'Date_of_Birth' => $user['Date_of_Birth'],
    'Resident_Role' => $user['Resident_Role'],
    'Contact_Number' => $user['Contact_Number'],
    'Resident_Email' => $user['Resident_Email'],
    'Occupation' => $user['Occupation'],
    'Religion' => $user['Religion'],
    'Civil_Status' => $user['Civil_Status'],
    'Eligibility_Status' => $user['Eligibility_Status'],
    'Address' => $user['Address'],
    'Emergency_Person' => $user['Emergency_Person'],
    'Emergency_Contact_No' => $user['Emergency_Contact_No'],
    'Emergency_Address' => $user['Emergency_Address'],
    'Relationship_to_Person' => $user['Relationship_to_Person'],
    'Valid_ID_Type' => $user['Valid_ID_Type'],
    'Valid_ID_Picture_Front' => $user['Valid_ID_Picture_Front'],
    'Valid_ID_Picture_Back' => $user['Valid_ID_Picture_Back'],
    'Pic_Path' => $user['Pic_Path'],
    'Age' => $user['Age'],
    'Member_Password' => $user['Member_Password']
];

// Redirect to the homepage or another page
header("Location: ../index.php");
exit();
?>
