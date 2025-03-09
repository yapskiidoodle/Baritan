<?php
require 'connect.php'; // Use 'include' or 'require' to load the file
require 'account.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logoutButton'])) { 
    session_start();
    session_destroy();

    // Get the current file name
    $currentFile = basename($_SERVER['PHP_SELF']);

    if ($currentFile == "index.php") {
        header("Refresh:0"); // Refresh the page if already in index.php
    } elseif (file_exists("../index.php")) {
        header("Location: ../"); // Go back one level if index.php exists there
    } elseif (file_exists("../../index.php")) {
        header("Location: ../../"); // Go back two levels if index.php exists there
    } else {
        header("Location: /"); // Default: Go to the root directory
    }

    exit();
}
?>