<?php
require 'connect.php'; // Database connection
require 'account.php'; // Contains session_start()

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $complaintID = uniqid("CR_");
    
    // Get Resident_ID if available
    $residentID = isset($_SESSION['User_Data']['Resident_ID']) && !empty($_SESSION['User_Data']['Resident_ID']) 
        ? $_SESSION['User_Data']['Resident_ID'] 
        : null; // Ensure this is handled in DB

    // Sanitize Inputs
    $fullName = isset($_POST['fullName']) ? ucwords(strtolower(trim($_POST['fullName']))) : '';
    $address = isset($_POST['address']) ? ucwords(strtolower(trim($_POST['address']))) : '';
    $contact = isset($_POST['contact']) ? trim($_POST['contact']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    $dateOfIncident = isset($_POST['dateOfIncident']) ? trim($_POST['dateOfIncident']) : '';
    $timeOfIncident = isset($_POST['timeOfIncident']) ? trim($_POST['timeOfIncident']) : '';
    $locationOfIncident = isset($_POST['locationOfIncident']) ? trim($_POST['locationOfIncident']) : '';
    $whatSubjOfComplaint = isset($_POST['whatSubjectOfComplaint']) ? trim($_POST['whatSubjectOfComplaint']) : '';
    $whoSubjOfComplaint = isset($_POST['whoSubjectOfComplaint']) ? trim($_POST['whoSubjectOfComplaint']) : '';
    $summaryOfComplaint = isset($_POST['summaryOfComplaint']) ? trim($_POST['summaryOfComplaint']) : '';

    $nameOfWitness = isset($_POST['nameOfWitness']) ? ucwords(strtolower(trim($_POST['nameOfWitness']))) : '';
    $witnessAddress = isset($_POST['witnessAddress']) ? trim($_POST['witnessAddress']) : '';
    $witnessContact = isset($_POST['witnessContact']) ? trim($_POST['witnessContact']) : '';
    $witnessEmail = isset($_POST['witnessEmail']) ? trim($_POST['witnessEmail']) : '';

    $outcome = isset($_POST['outcome']) ? trim($_POST['outcome']) : '';
    $outcomeDetails = isset($_POST['outcomeDetails']) ? trim($_POST['outcomeDetails']) : '';

    // Debugging: Uncomment if needed
    // var_dump($_POST); exit(); 

    // Prepare SQL statement
    $sql = "INSERT INTO complaint_report_tbl 
        (Complaint_ID, Resident_ID, FullName, Address, Contact_Information, Email, Date_of_Incident, 
        Time_of_Incident, Location_of_Incident, What_Sbj_Complaint, Who_Sbj_Complaint, Complaint_Summary, 
        Witness_Name, Witness_Address, Witness_Contact, Witness_Email, Outcome, Outcome_Details) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param(
        "ssssssssssssssssss", 
        $complaintID, $residentID, $fullName, $address, $contact, $email, 
        $dateOfIncident, $timeOfIncident, $locationOfIncident, 
        $whatSubjOfComplaint, $whoSubjOfComplaint, $summaryOfComplaint, 
        $nameOfWitness, $witnessAddress, $witnessContact, $witnessEmail, 
        $outcome, $outcomeDetails // Fixed typo here
    );

    if ($stmt->execute()) {
        echo "Complaint submitted successfully.";
        header("Location: ../index.php"); // Redirect to index
        exit(); // Stop execution after redirect
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
