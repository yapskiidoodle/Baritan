<?php
require '../src/connect.php';
require '../src/account.php'; // Ensures session_start()





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve Logged-in User's Family Name ID
    $Family_Name_ID = $_SESSION['User_Data']['Family_Name_ID'] ?? '';

    // Retrieve Form Data
    $password = $_POST['password'] ?? '';

    $FirstName = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
    $FirstName = preg_replace('/[^a-zA-Zñ ]/', '', $FirstName);
    $FirstName = ucwords(strtolower($FirstName));

    $MiddleName = isset($_POST['middleInitial']) ? trim($_POST['middleInitial']) : '';
    $MiddleName = preg_replace('/[^a-zA-Zñ ]/', '', $MiddleName);
    $MiddleName = ucwords(strtolower($MiddleName));

    $LastName = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';
    $LastName = preg_replace('/[^a-zA-Zñ ]/', '', $LastName);
    $LastName = ucwords(strtolower($LastName));

    $Suffix = isset($_POST['suffix']) ? trim($_POST['suffix']) : '';
    $Suffix = preg_replace('/[^a-zA-Z0-9. ]/', '', $Suffix);
    $Suffix = ucwords(strtolower($Suffix));

    $Sex = $_POST['sex'] ?? '';
    $Date_of_Birth = $_POST['birthday'] ?? '';

    // Handle Role Input
    $Role = $_POST['role'] ?? '';
    if ($Role === 'Others' && !empty($_POST['otherRole'])) {
        $Role = $_POST['otherRole']; // Override with user input
    }


    $Contact_Number = $_POST['contact'] ?? '';
    $Resident_Email = $_POST['email'] ?? '';
    $Occupation = $_POST['occupation'] ?? '';
    $Religion = $_POST['religion'] ?? '';
    $Civil_Status = $_POST['civilStatus'] ?? '';
    $Emergency_Person = $_POST['emergencyPerson'] ?? '';
    $Emergency_Contact_No = $_POST['emergencyContact'] ?? '';
    $Emergency_Address = $_POST['emergencyAddress'] ?? '';
    $Relationship_to_Person = $_POST['emergencyRelation'] ?? '';
    $Address = $_SESSION['User_Data']['Address'] ?? '';
    $Valid_ID_Type = $_POST['idType'] ?? '';

    // Generate Resident ID
    $query = "SELECT COUNT(*) AS total FROM residents_information_tbl";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $residentCount = ($row['total'] ?? 0) + 1;
    $Resident_ID = strtoupper(substr($LastName, 0, 3)) . date("Y") . str_pad($residentCount, 4, "0", STR_PAD_LEFT);

    // Calculate Age
    $dob = new DateTime($Date_of_Birth);
    $today = new DateTime();
    $Age = $today->diff($dob)->y;

    // Insert into residents_information_tbl
    $sqlAddInfo = "INSERT INTO residents_information_tbl 
        (Resident_ID, Family_Name_ID, FirstName, MiddleName, LastName, Suffix, Sex, Date_of_Birth, Role, Contact_Number, 
        Resident_Email, Occupation, Religion, Eligibility_Status, Civil_Status, Emergency_Person, Emergency_Contact_No, 
        Emergency_Address, Relationship_to_Person, Address, Valid_ID_Type, Valid_ID_Picture_Front, Valid_ID_Picture_Back, 
        Pic_Path, Age) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";  // 25 placeholders

    $stmtAddInfo = $conn->prepare($sqlAddInfo);
    if (!$stmtAddInfo) {
        die("Error preparing SQL: " . $conn->error);
    }

    $stmtAddInfo->bind_param("sssssssssssssssssssssssss", 
        $Resident_ID, $Family_Name_ID, $FirstName, $MiddleName, $LastName, $Suffix, $Sex, $Date_of_Birth, $Role, $Contact_Number,
        $Resident_Email, $Occupation, $Religion, $Eligibility_Status, $Civil_Status, $Emergency_Person, $Emergency_Contact_No, 
        $Emergency_Address, $Relationship_to_Person, $Address, $Valid_ID_Type, $Valid_ID_Picture_Front, $Valid_ID_Picture_Back, 
        $Pic_Path, $Age
        );

    if (!$stmtAddInfo->execute()) {
        die("Error inserting into residents_information_tbl: " . $stmtAddInfo->error);
    }

    // If a password is provided, insert into account_setting_tbl
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $sqlAccount = "INSERT INTO account_setting_tbl (Profile_ID, Account_ID, Password, Date_Created) 
                       VALUES (?, ?, ?, NOW())";
        $stmtAccount = $conn->prepare($sqlAccount);
        if (!$stmtAccount) {
            die("Error preparing account setting table SQL: " . $conn->error);
        }

        $Profile_ID = "PROF" . date("Y") . str_pad($residentCount, 4, "0", STR_PAD_LEFT);
        $Account_ID = $_SESSION['User_Data']['Account_ID'] ?? '';

        $stmtAccount->bind_param("sss", $Profile_ID, $Account_ID, $hashedPassword);

        if (!$stmtAccount->execute()) {
            die("Error inserting into account_setting_tbl: " . $stmtAccount->error);
        }
    }

    // Redirect back to the member list
    header("Location: ../html/profile.php");
    exit();
}
?>
