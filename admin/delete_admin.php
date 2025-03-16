<?php
require ('../src/connect.php'); // Include the database connection file

// Get the account ID from the request
$accountId = $_POST['id'];

// Delete the admin account
$sql = "DELETE FROM account_tbl WHERE Account_ID = $accountId";
if ($conn->query($sql)) {
    // Return a success response
    echo json_encode(["success" => true]);
} else {
    // Return an error response
    echo json_encode(["success" => false, "error" => $conn->error]);
}

$conn->close(); // Close the database connection
?>