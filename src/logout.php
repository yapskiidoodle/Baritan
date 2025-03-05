<?php
require 'connect.php'; // Use 'include' or 'require' to load the file

session_destroy();

// Redirect to login or another page (optional)
header("Location: ../"); 
echo "<script>alert('nakalogout ka na');</script>";
exit();


?>
