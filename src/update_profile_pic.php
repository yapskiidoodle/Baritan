<?php
session_start();
require 'connect.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {
    $residentId = $_SESSION['User_Data']['Resident_ID'];
    
    // File upload handling
    $file = $_FILES['profile_pic'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileError = $file['error'];
    
    if ($fileError === UPLOAD_ERR_OK) {
        // Generate unique filename
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid('profile_') . '.' . $fileExt;
        $uploadPath = '../resident_folder/profile/' . $newFileName;
        
        // Move uploaded file
        if (move_uploaded_file($fileTmpName, $uploadPath)) {
            // Update database
            $query = "UPDATE residents_information_tbl SET Pic_Path = ? WHERE Resident_ID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $newFileName, $residentId);
            
            if ($stmt->execute()) {
                // Update session
                $_SESSION['User_Data']['Pic_Path'] = $newFileName;
                $_SESSION['success'] = "Profile picture updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update profile picture in database.";
            }
            $stmt->close();
        } else {
            $_SESSION['error'] = "Failed to upload file.";
        }
    } else {
        $_SESSION['error'] = "File upload error: " . $fileError;
    }
}

header("Location: ../html/profile.php"); // Redirect back to profile page
exit();
?>