<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'connect.php'; // Load the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loginButton'])) {
    $userEmail = trim($_POST["userEmail"] ?? '');
    $password = trim($_POST["password"] ?? '');

    // ✅ Fetch user details securely
    $query = "SELECT 
    a.Account_ID, a.Role AS Account_Role, a.Type AS Account_Type, a.User_Email, a.Password, a.Status AS Account_Status,
    f.Family_Name_ID, f.Family_Name, f.Status AS Family_Status,
    r.Resident_ID, r.FirstName, r.MiddleName, r.LastName, r.Suffix, r.Sex, r.Date_of_Birth, r.Role AS Resident_Role,
    r.Contact_Number, r.Resident_Email, r.Occupation, r.Religion, r.Civil_Status, r.Eligibility_Status, r.Address,
    r.Emergency_Person, r.Emergency_Contact_No, r.Emergency_Address, r.Relationship_to_Person,
    r.Valid_ID_Type, r.Valid_ID_Picture_Front, r.Valid_ID_Picture_Back, r.Pic_Path, r.Age, r.Date_Created AS Resident_Created
  FROM account_tbl a
  LEFT JOIN family_name_tbl f ON a.Account_ID = f.Account_ID
  LEFT JOIN residents_information_tbl r ON f.Family_Name_ID = r.Family_Name_ID
  WHERE a.User_Email = ?";

$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
die("Query preparation failed: " . mysqli_error($conn));
}



    mysqli_stmt_bind_param($stmt, "s", $userEmail);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $storedPassword = $row['Password']; 
        $accountType = $row['Account_Type']; 
        $accountID = $row['Account_ID']; 
        $accountStatus = $row['Account_Status']; 
        $accountRole =  $row['Account_Role'];

        // ✅ Verify password securely
        if (!password_verify($password, $storedPassword)) {
            $_SESSION['try']++; // Increment try count
            if ($_SESSION['try'] >= 5) {
                $_SESSION['error_message'] = "Too many failed attempts. Please try again later.";
                header("Location: ../html/login.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Wrong Username or Password. Attempt {$_SESSION['try']} of 5.";
                header("Location: ../html/login.php");
                exit();
            }
        }

        session_regenerate_id(true);

        // ✅ Reset try count on success
        $_SESSION['try'] = 0;

        // ✅ Check if the account is deactivated
        if ($accountStatus === "Deactivated") {
            $_SESSION['deactivated'] = true; 
            header("Location: ../index.php");
            exit();
        }

        // ✅ Store session variables
        $_SESSION['userEmail'] = $row['User_Email'];
        $_SESSION['type'] = $accountType;
        $_SESSION['Account_ID'] = $accountID;
        $_SESSION['status'] = $accountStatus;
        $_SESSION['Account_Role'] = $accountRole;
        
        // ✅ Store additional user details
        $_SESSION['User_Data'] = [
            'Account_ID' => $row['Account_ID'],
            'Account_Role' => $row['Account_Role'],
            'Family_Name_ID' => $row['Family_Name_ID'], // ✅ Add this
            'Resident_ID' => $row['Resident_ID'],
            'FirstName' => $row['FirstName'],
            'MiddleName' => $row['MiddleName'],
            'LastName' => $row['LastName'],
            'Sex' => $row['Sex'],
            'Date_of_Birth' => $row['Date_of_Birth'],
            'Resident_Role' => $row['Resident_Role'],
            'Contact_Number' => $row['Contact_Number'],
            'Resident_Email' => $row['Resident_Email'],
            'Occupation' => $row['Occupation'],
            'Religion' => $row['Religion'],
            'Civil_Status' => $row['Civil_Status'],
            'Eligibility_Status' => $row['Eligibility_Status'],
            'Address' => $row['Address'],
            'Emergency_Person' => $row['Emergency_Person'],
            'Emergency_Contact_No' => $row['Emergency_Contact_No'],
            'Emergency_Address' => $row['Emergency_Address'],
            'Relationship_to_Person' => $row['Relationship_to_Person'],
            'Valid_ID_Type' => $row['Valid_ID_Type'],
            'Valid_ID_Picture_Front' => $row['Valid_ID_Picture_Front'],
            'Valid_ID_Picture_Back' => $row['Valid_ID_Picture_Back'],
            'Pic_Path' => $row['Pic_Path'],
            'Age' => $row['Age'],
            'Resident_Created' => $row['Resident_Created']
        ];

        // ✅ Redirect based on account type
        if (($accountType === "Editor")||($accountType === "Super Admin") || ($accountType === "Admin")) {
       
            header("Location: ../admin/residents.php");
            exit();
        } elseif ($accountType === "Family Account") {   
            $_SESSION['show_modal'] = true;
            header("Location: ../html/login.php");
            exit();
        }
    } else {

                
        // Initialize the disable button flag
        $disableButton = false;
            // Check if this is the first failed attempt and set the timestamp
            if (!isset($_SESSION['first_failed_time']) && isset($_SESSION['try']) && $_SESSION['try'] >= 1) {
                $_SESSION['first_failed_time'] = time();
            }

            // Check if 1 minute has passed since the first failed attempt
            if (isset($_SESSION['first_failed_time']) && (time() - $_SESSION['first_failed_time'] > 60)) {
                // Reset the attempt counter and re-enable the button after 1 minute
                $_SESSION['try'] = 0;
                unset($_SESSION['first_failed_time']); // Remove the timestamp
                $disableButton = false;
            }

            // Handle invalid login attempt
            if ($_SESSION['try'] == 5) {
                // Too many failed attempts, calculate remaining time
                $remainingTime = 60 - (time() - $_SESSION['first_failed_time']); // Remaining time in seconds
                $_SESSION['remaining_time'] = $remainingTime; // Store the remaining time in session
                $_SESSION['error_message'] = "Too many failed attempts. Please try again in {$remainingTime} seconds.";
                $disableButton = true;  // Disable the login button
                header("Location: ../html/login.php");
                exit();
            } else {
                // Handle wrong username/password
                $_SESSION['try']++;
                
                $_SESSION['error_message'] = "Wrong Username or Password. Attempt {$_SESSION['try']} of 5.";
                if ($_SESSION['try'] == 5) {
                    $_SESSION['error_message'] = "";
                }
                header("Location: ../html/login.php");
                exit();
            }

    }

    // ✅ Close statement
    mysqli_stmt_close($stmt);
}

?>


<!-- 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 
    
-->