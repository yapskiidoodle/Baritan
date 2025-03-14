<?php
require 'connect.php';

if (isset($_POST['delete_resident']) && isset($_POST['resident_id']) && isset($_POST['delete_reason'])) {
    $residentId = trim($_POST['resident_id']);
    $deleteReason = trim($_POST['delete_reason']);
    $deletedBy = "Admin"; // Replace with the actual username or session variable

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
                            echo "<script>alert('Resident archived and deleted successfully.'); window.location.href = '../admin/residents.php';</script>";
                        } else {
                            echo "<script>alert('Error deleting resident: " . $deleteStmt->error . "'); window.location.href = '../admin/residents.php';</script>";
                        }

                        $deleteStmt->close();
                    } else {
                        echo "<script>alert('Error preparing delete statement: " . $conn->error . "'); window.location.href = '../admin/residents.php';</script>";
                    }
                } else {
                    echo "<script>alert('Error archiving resident: " . $archiveStmt->error . "'); window.location.href = '../admin/residents.php';</script>";
                }

                $archiveStmt->close();
            } else {
                echo "<script>alert('Error preparing archive statement: " . $conn->error . "'); window.location.href = '../admin/residents.php';</script>";
            }
        } else {
            echo "<script>alert('Resident not found.'); window.location.href = '../admin/residents.php';</script>";
        }

        $fetchStmt->close();
    } else {
        echo "<script>alert('Error preparing fetch statement: " . $conn->error . "'); window.location.href = '../admin/residents.php';</script>";
    }
} else {
    echo "<script>alert('No Resident ID or reason provided.'); window.location.href = '../admin/residents.php';</script>";
}

$conn->close();
?>