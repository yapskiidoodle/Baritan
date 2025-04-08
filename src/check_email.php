<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'connect.php';

if (isset($_POST['userEmail'])) {
    $newEmail = trim($_POST['userEmail']);
    $currentEmail = $_SESSION['User_Data']['userEmail'] ?? '';

    if ($newEmail === $currentEmail) {
        echo json_encode(["status" => "ok"]);
        exit();
    }

    $stmt = $conn->prepare("SELECT COUNT(*) FROM account_tbl WHERE User_Email = ?");
    $stmt->bind_param("s", $newEmail);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo json_encode(["status" => "taken"]);
    } else {
        echo json_encode(["status" => "ok"]);
    }

    exit();
}
?>