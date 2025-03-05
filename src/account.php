<?php
require 'connect.php'; // Use 'include' or 'require' to load the file

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loginButton'])) {
    $userEmail= $_POST["userEmail"];
    $password = $_POST["password"];

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM account_tbl WHERE User_Email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $userEmail);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        session_start();
        $row = mysqli_fetch_assoc($result);
    
        // Verify the password (assuming password is hashed in the database)
        if ($password == $row['Password'] ){
           
            // Set session variables
            $_SESSION['userEmail'] = $userEmail;
            $_SESSION['type'] = $row['Type']; // Store the account type in the session
    
            // Redirect based on account type
            if ($row['Type'] == "Admin Account") {
              
                header("Location: ../admin/residents.php");
                exit();
            } elseif ($row['Type'] == "Family Account") {
                header("Location: index.php");
                exit();
            } else {
                // Handle unexpected account types (optional)
                echo "<div class='invalid'>
                        <span>Invalid account type</span>
                      </div>";
            }
        } else {
            echo "<div class='invalid'>
                    <span>Invalid username or password</span>
                  </div>";
        }
    } else {
        echo "<div class='invalid'>
                <span>Invalid username or password</span>
              </div>";
    }

    mysqli_stmt_close($stmt);
}




?>