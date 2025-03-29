<?php
require ('../src/connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $accountId = $_POST['Account_ID'];
    $role = $_POST['Role'];
    $type = $_POST['Type'];
    $status = $_POST['Status'];

    // Validate input data
    if (empty($accountId) || empty($role) || empty($type) || empty($status)) {
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        exit;
    }

    // Prepare and execute the SQL query to update the admin account
    $sql = "UPDATE account_tbl SET Role = ?, Type = ?, Status = ? WHERE Account_ID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $role, $type, $status, $accountId);
        if ($stmt->execute()) {
            // Check if any rows were affected
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => true, 'message' => 'Admin account updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'error' => 'No changes were made.']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to execute the query.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to prepare the SQL statement.']);
    }
} else {
    // If the request method is not POST, return an error
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}

// Close the database connection
$conn->close();
?>