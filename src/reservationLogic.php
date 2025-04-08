<?php
require 'connect.php'; // Database connection
require 'account.php'; // Contains session_start()




if ($_SERVER["REQUEST_METHOD"] == "POST")  {
    $reservationID = uniqid("RES_");
    $residentID = $_SESSION['User_Data']['Resident_ID'];

    $firstName = ucwords(strtolower($_POST['firstName']));
    $middleInitial = strtoupper($_POST['middleName'][0]) . '.'; // Ensure uppercase middle initial
    $lastName = ucwords(strtolower($_POST['lastName']));
    $suffix = ucwords(strtolower($_POST['suffix'])); // In case the suffix is something like "jr" or "iii"

    $fullName = trim("$firstName $middleInitial $lastName $suffix");
    
    $equipment = $_POST['equipment'];
    $quantity = $_POST['quantity'];
    $venue = $_POST['venue'];
    $dateToReserve = $_POST['dateToReserve'];
    $dateToReturn = $_POST['dateToReturn'];

    // Handle 'Other' purpose
    $purpose = $_POST['purpose'];
    if ($purpose === "Other") {
        $purpose = $_POST['otherInput']; // Get custom purpose input
    }

    // Prepare SQL statement
    $sql = "INSERT INTO reservation_information_tbl 
            (Reservation_ID, Resident_ID, FullName, Equipment, Quantity, Venue, Date_to_Reserve, Date_to_Return, Purpose) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("sssssssss", $reservationID, $residentID, $fullName, $equipment, $quantity, $venue, $dateToReserve, $dateToReturn, $purpose);
    
    if ($stmt->execute()) {
        echo "Reservation submitted successfully.";
        header("Location: ../index.php"); // Redirect to index
        exit(); // Ensure script stops execution after redirect
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
