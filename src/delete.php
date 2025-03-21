<?php
require 'connect.php';
require 'account.php';


if (isset($_POST['delete_resident']) && isset($_POST['resident_id']) && isset($_POST['delete_reason'])) {
    $residentId = trim($_POST['resident_id']);
    $deleteReason = trim($_POST['delete_reason']);
    $deletedBy = $_SESSION['Account_Role']; // Get the admin's role from the session

    // Fetch the resident's data from the main table
    $fetchSql = "SELECT * FROM Residents_information_tbl WHERE Resident_ID = ?";
    $fetchStmt = $conn->prepare($fetchSql);

    if ($fetchStmt) {
        $fetchStmt->bind_param("s", $residentId);
        $fetchStmt->execute();
        $result = $fetchStmt->get_result();

        if ($result->num_rows > 0) {
            $residentData = $result->fetch_assoc();

            // Generate the archive_id
            $currentDate = date("Ymd"); // YYYYMMDD format
            $lastArchiveId = null;

            // Fetch the last archive_id for the current day
            $lastIdSql = "SELECT archive_id FROM Archive_Residents_Information_tbl WHERE archive_id LIKE ? ORDER BY archive_id DESC LIMIT 1";
            $lastIdStmt = $conn->prepare($lastIdSql);

            if ($lastIdStmt) {
                $searchPattern = $currentDate . "%"; // Match archive_id for the current day
                $lastIdStmt->bind_param("s", $searchPattern);
                $lastIdStmt->execute();
                $lastIdStmt->bind_result($lastArchiveId);
                $lastIdStmt->fetch();
                $lastIdStmt->close();
            }

            // Determine the next archive_id
            if ($lastArchiveId) {
                $lastIncrement = (int) substr($lastArchiveId, -3); // Extract the last 3 digits
                $nextIncrement = $lastIncrement + 1;
            } else {
                $nextIncrement = 1; // First record for the day
            }

            $archiveId = $currentDate . str_pad($nextIncrement, 3, "0", STR_PAD_LEFT); // YYYYMMDDXXX

            // Insert the resident's data into the archive table
            $archiveSql = "INSERT INTO Archive_Residents_Information_tbl (
                archive_id, Resident_ID, FirstName, MiddleName, LastName, Sex, Date_of_Birth, Role, Contact_Number,
                Resident_Email, Religion, Eligibility_Status, Civil_Status, Emergency_Person,
                Emergency_Contact_No, Relationship_to_Person, Address, Valid_ID_Type, Valid_ID_Picture_Front,
                Valid_ID_Picture_Back, Pic_Path, deletion_reason, deleted_by
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $archiveStmt = $conn->prepare($archiveSql);

            if ($archiveStmt) {
                $archiveStmt->bind_param(
                    "sssssssssssssssssssssss",
                    $archiveId,
                    $residentData['Resident_ID'],
                    $residentData['FirstName'],
                    $residentData['MiddleName'],
                    $residentData['LastName'],
                    $residentData['Sex'],
                    $residentData['Date_of_Birth'],
                    $residentData['Role'],
                    $residentData['Contact_Number'],
                    $residentData['Resident_Email'],
                    $residentData['Religion'],
                    $residentData['Eligibility_Status'],
                    $residentData['Civil_Status'],
                    $residentData['Emergency_Person'],
                    $residentData['Emergency_Contact_No'],
                    $residentData['Relationship_to_Person'],
                    $residentData['Address'],
                    $residentData['Valid_ID_Type'],
                    $residentData['Valid_ID_Picture_Front'],
                    $residentData['Valid_ID_Picture_Back'],
                    $residentData['Pic_Path'],
                    $deleteReason,
                    $deletedBy
                );

                if ($archiveStmt->execute()) {
                    // Delete the resident's data from the main table
                    $deleteSql = "DELETE FROM Residents_information_tbl WHERE Resident_ID = ?";
                    $deleteStmt = $conn->prepare($deleteSql);

                    if ($deleteStmt) {
                        $deleteStmt->bind_param("s", $residentId);

                        if ($deleteStmt->execute()) {
                            // Generate log_id for admin_activity_log
                            $logIdPrefix = strtoupper(substr($deletedBy, 0, 3)); // First 3 letters of the admin role
                            $logIdDateTime = date("YmdHis"); // Current date and time in YYYYMMDDHHMMSS format
                            $logId = $logIdPrefix . $logIdDateTime; // Combine prefix and date-time

                            // Insert into admin_activity_log
                            $activityLogSql = "INSERT INTO admin_activity_log (log_id, admin_id, action_by, action, created_at)
                                              VALUES (?, ?, ?, ?, NOW())";
                            $activityLogStmt = $conn->prepare($activityLogSql);

                            if ($activityLogStmt) {
                                $action = "Deleted resident with ID: $residentId"; // Description of the action
                                $activityLogStmt->bind_param("ssss", $logId, $_SESSION['Account_ID'], $deletedBy, $action);

                                if ($activityLogStmt->execute()) {
                                    // Redirect with success message
                                    $message = urlencode("Resident archived and removed successfully.");
                                    header("Location: ../admin/residents.php?message=" . $message);
                                    exit();
                                } else {
                                    // Redirect with error message
                                    $message = urlencode("Error logging admin activity: " . $activityLogStmt->error);
                                    header("Location: ../admin/residents.php?message=" . $message);
                                    exit();
                                }

                                $activityLogStmt->close();
                            } else {
                                // Redirect with error message
                                $message = urlencode("Error preparing activity log statement: " . $conn->error);
                                header("Location: ../admin/residents.php?message=" . $message);
                                exit();
                            }
                        } else {
                            // Redirect with error message
                            $message = urlencode("Error deleting resident: " . $deleteStmt->error);
                            header("Location: ../admin/residents.php?message=" . $message);
                            exit();
                        }

                        $deleteStmt->close();
                    } else {
                        // Redirect with error message
                        $message = urlencode("Error preparing delete statement: " . $conn->error);
                        header("Location: ../admin/residents.php?message=" . $message);
                        exit();
                    }
                } else {
                    // Redirect with error message
                    $message = urlencode("Error archiving resident: " . $archiveStmt->error);
                    header("Location: ../admin/residents.php?message=" . $message);
                    exit();
                }

                $archiveStmt->close();
            } else {
                // Redirect with error message
                $message = urlencode("Error preparing archive statement: " . $conn->error);
                header("Location: ../admin/residents.php?message=" . $message);
                exit();
            }
        } else {
            // Redirect with error message
            $message = urlencode("Resident not found.");
            header("Location: ../admin/residents.php?message=" . $message);
            exit();
        }

        $fetchStmt->close();
    } else {
        // Redirect with error message
        $message = urlencode("Error preparing fetch statement: " . $conn->error);
        header("Location: ../admin/residents.php?message=" . $message);
        exit();
    }
} else {
    // Redirect with error message
    $message = urlencode("No Resident ID or reason provided.");
    header("Location: ../admin/residents.php?message=" . $message);
    exit();
}

$conn->close();
?>