<?php
require ('../src/connect.php');

// Check if Account_ID is provided
if (isset($_GET['Account_ID'])) {
    $accountId = $_GET['Account_ID'];

    // Fetch admin data from the database
    $sql = "SELECT Account_ID, Role, Type, Status FROM account_tbl WHERE Account_ID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $accountId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            echo json_encode(['success' => true, 'admin' => $admin]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Admin not found.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to prepare the SQL statement.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Account_ID is required.']);
}

// Close the database connection
$conn->close();
?>