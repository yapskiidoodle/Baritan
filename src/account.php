<?php
require 'src/connect.php'; // Use 'include' or 'require' to load the file

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loginButton'])) {
    $username = $_POST["userEmail"];
    $password = $_POST["password"];

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM account_tbl WHERE User_Email = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    
        // Verify the password (assuming password is hashed in the database)
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['username'] = $username;
            $_SESSION['firstname'] = $row['firstname'];
            $_SESSION['type'] = $row['type']; // Store the account type in the session
    
            // Redirect based on account type
            if ($row['type'] == "Admin Account") {
                header("Location: residents.php");
                exit();
            } elseif ($row['type'] == "Family Account") {
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