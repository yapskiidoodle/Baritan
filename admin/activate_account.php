<?php
require ('../src/connect.php'); // Include the database connection file

// Get the account ID from the request
$accountId = $_GET['id'];

// Update the account status to "Activated"
$sql = "UPDATE account_tbl SET Status = 'Activated' WHERE Account_ID = $accountId";
if ($conn->query($sql)) {
    // Return a success response
    echo json_encode(["success" => true]);
} else {
    // Return an error response
    echo json_encode(["success" => false, "error" => $conn->error]);
}

$conn->close(); // Close the database connection
?>