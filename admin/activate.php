<?php
require ('../src/connect.php');
require ('../src/account.php');

if (isset($_POST['Account_ID'])) {
    $accountId = $_POST['Account_ID'];

    // Update the account status to "Activated"
    $sql = "UPDATE account_tbl SET Status = 'Activated' WHERE Account_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $accountId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Account activated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to activate account.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

$conn->close();
?>