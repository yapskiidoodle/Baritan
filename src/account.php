<?php
session_start();
require 'connect.php'; // Load the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loginButton'])) {
    $userEmail = $_POST["userEmail"] ?? '';
    $password = $_POST["password"] ?? '';

    // ✅ Validate input
    if (empty($userEmail) || empty($password)) {
        echo "<div class='invalid'><span>Please enter both email and password</span></div>";
        exit();
    }

    // ✅ Fetch user details
    $query = "SELECT * FROM account_tbl WHERE User_Email = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Query preparation failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $userEmail);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // ✅ Check if user exists
    if ($row = mysqli_fetch_assoc($result)) {
        $storedPassword = $row['Password']; // Password stored in the database
        $accountType = $row['Type']; // Account type

        $isPasswordValid = false;

        // ✅ Handle different password types
        if ($accountType == "Admin Account") {
            // Admin password is NOT hashed (plain text match)
            $isPasswordValid = ($password === $storedPassword);
        } else {
            // Other accounts use hashed passwords
            $isPasswordValid = password_verify($password, $storedPassword);
        }

        // ✅ If password is correct, create session and redirect
        if ($isPasswordValid) {
            $_SESSION['userEmail'] = $row['User_Email'];
            $_SESSION['type'] = $accountType;

            if ($accountType == "Admin Account") {
                header("Location: ../admin/residents.php");
            } elseif ($accountType == "Family Account") {
                header("Location: ../index.php");
            } else {
                echo "<div class='invalid'><span>Invalid account type</span></div>";
                exit();
            }
            exit();
        } else {
            echo "<div class='invalid'><span>Invalid password</span></div>";
        }
    } else {
        echo "<div class='invalid'><span>Invalid username or password</span></div>";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}
?>
