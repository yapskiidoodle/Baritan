<?php
require 'connect.php';
require 'account.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit();
}

// Sanitize input data
$fullName = isset($_POST['fullName']) ? trim($_POST['fullName']) : '';
$fullAddress = isset($_POST['fullAddress']) ? trim($_POST['fullAddress']) : '';
$contact = isset($_POST['contact']) ? trim($_POST['contact']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$dateIncident = isset($_POST['dateIncident']) ? trim($_POST['dateIncident']) : '';
$timeIncident = isset($_POST['timeIncident']) ? trim($_POST['timeIncident']) : '';
$caseStatus = isset($_POST['caseType']) ? trim($_POST['caseType']) : ''; // Maps to Case_Status
$subjectIncident = isset($_POST['subjectIncident']) ? trim($_POST['subjectIncident']) : '';
$blotterSummary = isset($_POST['blotterSummary']) ? trim($_POST['blotterSummary']) : '';

// Get Resident_ID if available
$residentID = isset($_SESSION['User_Data']['Resident_ID']) && !empty($_SESSION['User_Data']['Resident_ID']) 
              ? $_SESSION['User_Data']['Resident_ID'] 
              : null;

// Validate required fields
if (empty($fullName) || empty($fullAddress) || empty($contact) || empty($email) || empty($dateIncident) || empty($timeIncident) || empty($caseStatus) || empty($subjectIncident)) {
    echo "Error: Required fields are missing.";
    exit();
}

// Generate a unique Blotter Report ID
$blotterReportID = uniqid('BR_');

// SQL Query with conditional Resident_ID
$sql = "INSERT INTO blotter_report_tbl 
        (Blotter_Report_ID, Resident_ID, FullName, FullAddress, Person_Email, Contact_Number, Date_Happened, Time_of_Incident, Case_Status, Subject, Blotter_Summary, Date_Reported, Blotter_Status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE(), 'Pending')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssss", $blotterReportID, $residentID, $fullName, $fullAddress, $email, $contact, $dateIncident, $timeIncident, $caseStatus, $subjectIncident, $blotterSummary);

// Execute the statement
if ($stmt->execute()) {
    echo "Blotter report submitted successfully.";
    header("Location: ../index.php"); // Redirect to index
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
