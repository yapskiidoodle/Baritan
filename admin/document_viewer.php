<?php
require('../src/connect.php');
require('../src/account.php');

// Check authorization
if (!isset($_SESSION['Account_Role']) || 
    !in_array($_SESSION['type'], ["Super Admin", "Admin", "Editor"])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['file'])) {
    $filename = basename($_GET['file']);
    $filepath = 'temp/' . $filename;
    
    if (file_exists($filepath)) {
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        readfile($filepath);
        exit;
    } else {
        die('File not found');
    }
} else {
    die('Invalid request');
}
?>