<?php
// update_resident.php
require ('../src/connect.php');
require '../src/account.php';


$edit_by = $_SESSION['Account_Role'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resident_id = $_POST['resident_id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $sex = $_POST['sex'];
    $dob = $_POST['dob'];
    $role = $_POST['role'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $religion = $_POST['religion'];
    $eligibility_status = $_POST['eligibility_status'];
    $civil_status = $_POST['civil_status'];
    $emergency_person = $_POST['emergency_person'];
    $emergency_contact = $_POST['emergency_contact'];
    $relationship = $_POST['relationship'];
    $address = $_POST['address'];

    // Prepare the SQL statement
    $sql = "UPDATE Residents_information_tbl SET
            FirstName = ?, MiddleName = ?, LastName = ?, Sex = ?, 
            Date_of_Birth = ?, Role = ?, Contact_Number = ?, Resident_Email = ?, 
            Religion = ?, Eligibility_Status = ?, Civil_Status = ?, 
            Emergency_Person = ?, Emergency_Contact_No = ?, Relationship_to_Person = ?, 
            Address = ? 
            WHERE Resident_ID = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param(
            "ssssssssssssssss",
            $first_name, $middle_name, $last_name, $sex, 
            $dob, $role, $contact_number, $email, 
            $religion, $eligibility_status, $civil_status, 
            $emergency_person, $emergency_contact, $relationship, 
            $address, $resident_id
        );

        // Execute the statement
        if ($stmt->execute()) {
          if ($stmt->affected_rows > 0) {
            $logIdPrefix = strtoupper(substr($edit_by, 0, 3)); // First 3 letters of the admin role
            $logIdDateTime = date("YmdHis"); // Current date and time in YYYYMMDDHHMMSS format
            $logId = $logIdPrefix . $logIdDateTime; // Combine prefix and date-time

            $activityLogSql = "INSERT INTO admin_activity_log (log_id, admin_id, action_by, action, created_at)
                                VALUES (?, ?, ?, ?, NOW())";
            $activityLogStmt = $conn->prepare($activityLogSql);

            if ($activityLogStmt) {
                $action = "Updated resident information with ID: $resident_id"; // Description of the action
                $activityLogStmt->bind_param("ssss", $logId, $_SESSION['Account_ID'], $edit_by, $action);

                if ($activityLogStmt->execute()) {
                    $message = "Resident Information updated successfully!";
                }

                
            }
            
            // Success: Resident updated
            
        } else {
            // No changes made
            $message = "There are no changes!";
        }
        } else {
            // Error: Failed to execute query
        $message = "Error updating resident: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();

        // Pass the message to residents.php using a query parameter
        header("Location: residents.php?message=" . urlencode($message));
        exit;
    } else {
         // Invalid request method
          $message = "Invalid request method.";
          header("Location: residents.php?message=" . urlencode($message));
          exit;
    }

    // Close the connection
    $conn->close();
}
?>
