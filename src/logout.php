<?php
require 'connect.php'; // Use 'include' or 'require' to load the file
require 'account.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logoutButton'])) { 

    session_destroy();


    // Redirect to login or another page (optional)
    header("Location: ../"); 

    exit();

}





?>
