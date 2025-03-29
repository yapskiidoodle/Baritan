<?php
session_start(); // Ensure session is started
require '../src/connect.php'; // Your database connection file
require '../src/account.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader
require '../vendor/autoload.php'; // Adjust the path to your PHPMailer autoload file

// Function to send email using PHPMailer
function sendEmail($category, $message, $target_audience, $recipient_email, $recipient_name) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP(); // Use SMTP
        $mail->Host = 'smtp.gmail.com'; // SMTP server (e.g., Gmail)
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'borromeo.anton@ue.edu.ph'; // Your email address
        $mail->Password = 'zfft kgvo oote fwvt'; // Your email password or app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('borromeo.anton@ue.edu.ph', 'Barangay Baritan'); // Sender
        $mail->addAddress($recipient_email, $recipient_name); // Recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = "New Announcement: $category";
        $mail->Body = "<h1>$category</h1><p>$message</p>";

        // Send email
        if ($mail->send()) {
            return true; // Email sent successfully
        } else {
            throw new Exception("Email could not be sent. Error: {$mail->ErrorInfo}");
        }
    } catch (Exception $e) {
        throw new Exception("Email could not be sent. Error: {$e->getMessage()}");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize response array
    $response = ['success' => false, 'message' => ''];

    try {
        // Retrieve form data
        $category = $_POST['category'];
        $message = $_POST['message'];
        $target_audience = implode(', ', $_POST['target_audience']); // Convert array to string
        $delivery_channels = $_POST['delivery_channels'];
        $start_date = ($delivery_channels === 'Website') ? $_POST['start_date'] : null; // Conditional start date
        $end_date = ($delivery_channels === 'Website') ? $_POST['end_date'] : null; // Conditional end date

        

        // Generate the announcement_id directly
        $prefix = strtoupper(substr($_SESSION['Account_Role'], 0, 3)); // First 3 letters of Account_Role, uppercase
        $current_date = new DateTime();
        $month = $current_date->format('m'); // Two-digit month
        $year = $current_date->format('y'); // Last two digits of the year
        $hours = $current_date->format('H'); // Hours in 24-hour format
        $minutes = $current_date->format('i'); // Minutes
        $announcement_id = $prefix . $month . $year . $hours . $minutes; // Combine all parts

        // Handle file upload (if applicable)
        $image_path = '';
        if ($delivery_channels === 'Website' && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true); // Create the uploads directory if it doesn't exist
            }

            // Validate file type and size
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 5 * 1024 * 1024; // 5MB

            if (!in_array($_FILES['image']['type'], $allowed_types)) {
                throw new Exception('Only JPEG, PNG, and GIF images are allowed.');
            }

            if ($_FILES['image']['size'] > $max_size) {
                throw new Exception('The image size must be less than 5MB.');
            }

            $image_name = basename($_FILES['image']['name']);
            $image_url = $upload_dir . uniqid() . '_' . $image_name; // Add a unique ID to avoid filename conflicts

            if (move_uploaded_file($_FILES['image']['tmp_name'], $image_url)) {
                $image_path = $image_url;
            } else {
                throw new Exception('Failed to upload image.');
            }
        }

        // Validate start and end dates for Website delivery channel
        if ($delivery_channels === 'Website') {
            if (empty($start_date) || empty($end_date)) {
                throw new Exception('Start date and end date are required for Website delivery channel.');
            }

            if ($start_date >= $end_date) {
                throw new Exception('End date must be after the start date.');
            }
        }

        // Insert announcement into the database
        $sql = "INSERT INTO announcement_tbl (announcement_id, category, message, target_audience, delivery_channels, start_date, end_date, image_path, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception('Database error: ' . $conn->error);
        }
        $stmt->bind_param("ssssssss", $announcement_id, $category, $message, $target_audience, $delivery_channels, $start_date, $end_date, $image_path);

        // Execute the database query
        if ($stmt->execute()) {
            $logIdPrefix = strtoupper(substr($_SESSION['Account_Role'], 0, 3)); // First 3 letters of the admin role
            $logIdDateTime = date("YmdHis"); // Current date and time in YYYYMMDDHHMMSS format
            $logId = $logIdPrefix . $logIdDateTime; // Combine prefix and date-time

            if ($delivery_channels === 'Website') {
                $action = "Created announcement message through website: $announcement_id"; // Description of the action through website
            } else {
                $action = "Created announcement message via EMAIL/SMS: $announcement_id"; // Description of the action via email/sms
            }

            $activityLogSql = "INSERT INTO admin_activity_log (log_id, admin_id, action_by, action, created_at)
                                VALUES (?, ?, ?, ?, NOW())";
            $activityLogStmt = $conn->prepare($activityLogSql);

            if ($activityLogStmt) {
                $activityLogStmt->bind_param("ssss", $logId, $_SESSION['Account_ID'], $_SESSION['Account_Role'], $action);

                if ($activityLogStmt->execute()) {
                    exit();
                }          
            }
            // Send email if delivery channel is Email/SMS
            if ($delivery_channels === 'Email/SMS') {
                // Check if "All Residents" is selected
                if (in_array('All Residents', $_POST['target_audience'])) {
                    // Fetch all resident emails from Residents_information_tbl
                    $sql = "SELECT Resident_Email, CONCAT(FirstName, ' ', LastName) AS Full_Name FROM residents_information_tbl";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $emails_sent = 0;
                        while ($row = $result->fetch_assoc()) {
                            $recipient_email = $row['Resident_Email'];
                            $recipient_name = $row['Full_Name'];

                            // Send email to each resident
                            if (sendEmail($category, $message, $target_audience, $recipient_email, $recipient_name)) {
                                $emails_sent++;
                            }
                        }

                        $response['success'] = true;
                        $response['message'] = "Announcement created and emails sent to $emails_sent residents successfully!";
                    } else {
                        throw new Exception('No residents found in the database.');
                    }
                } if (in_array('Head of the Family', $_POST['target_audience'])) {
                    // Fetch all resident emails from Residents_information_tbl
                    $sql = "SELECT Resident_Email, CONCAT(FirstName, ' ', LastName) AS Full_Name FROM residents_information_tbl WHERE Role = 'Head'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $emails_sent = 0;
                        while ($row = $result->fetch_assoc()) {
                            $recipient_email = $row['Resident_Email'];
                            $recipient_name = $row['Full_Name'];

                            // Send email to each resident
                            if (sendEmail($category, $message, $target_audience, $recipient_email, $recipient_name)) {
                                $emails_sent++;
                            }
                        }

                        $response['success'] = true;
                        $response['message'] = "Announcement created and emails sent to $emails_sent residents successfully!";
                    } else {
                        throw new Exception('No residents found in the database.');
                    }
                } if (in_array('Senior Citizen', $_POST['target_audience'])) {
                    // Fetch all resident emails from Residents_information_tbl
                    $sql = "SELECT Resident_Email, CONCAT(FirstName, ' ', LastName) AS Full_Name FROM residents_information_tbl WHERE Eligibility_Status = 'Senior Citizen'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $emails_sent = 0;
                        while ($row = $result->fetch_assoc()) {
                            $recipient_email = $row['Resident_Email'];
                            $recipient_name = $row['Full_Name'];

                            // Send email to each resident
                            if (sendEmail($category, $message, $target_audience, $recipient_email, $recipient_name)) {
                                $emails_sent++;
                            }
                        }

                        $response['success'] = true;
                        $response['message'] = "Announcement created and emails sent to $emails_sent residents successfully!";
                    } else {
                        throw new Exception('No residents found in the database.');
                    }
                } if (in_array('PWD', $_POST['target_audience'])) {
                    // Fetch all resident emails from Residents_information_tbl
                    $sql = "SELECT Resident_Email, CONCAT(FirstName, ' ', LastName) AS Full_Name FROM residents_information_tbl WHERE Eligibility_Status = 'Person with Disabilty'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $emails_sent = 0;
                        while ($row = $result->fetch_assoc()) {
                            $recipient_email = $row['Resident_Email'];
                            $recipient_name = $row['Full_Name'];

                            // Send email to each resident
                            if (sendEmail($category, $message, $target_audience, $recipient_email, $recipient_name)) {
                                $emails_sent++;
                            }
                        }

                        $response['success'] = true;
                        $response['message'] = "Announcement created and emails sent to $emails_sent residents successfully!";
                    } else {
                        throw new Exception('No residents found in the database.');
                    }
                } if (in_array('Male (Age Range)', $_POST['target_audience'])) {
                    if ($male_min_age !== null && $male_max_age !== null) {
                        // Fetch male residents within the specified age range
                        $sql = "SELECT Resident_Email, CONCAT(FirstName, ' ', LastName) AS Full_Name 
                                FROM residents_information_tbl 
                                WHERE Gender = 'Male' AND Age BETWEEN ? AND ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ii", $male_min_age, $male_max_age);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $recipient_email = $row['Resident_Email'];
                                $recipient_name = $row['Full_Name'];

                                // Send email to each resident
                                if (sendEmail($category, $message, $target_audience, $recipient_email, $recipient_name)) {
                                    $emails_sent++;
                                }
                            }
                        } else {
                            throw new Exception('No male residents found within the specified age range.');
                        }
                    } else {
                        throw new Exception('Male age range values are missing.');
                    }
                } if (in_array('Female (Age Range)', $_POST['target_audience'])) {
                    if ($female_min_age !== null && $female_max_age !== null) {
                        // Fetch female residents within the specified age range
                        $sql = "SELECT Resident_Email, CONCAT(FirstName, ' ', LastName) AS Full_Name 
                                FROM residents_information_tbl 
                                WHERE Gender = 'Female' AND Age BETWEEN ? AND ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ii", $female_min_age, $female_max_age);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $recipient_email = $row['Resident_Email'];
                                $recipient_name = $row['Full_Name'];

                                // Send email to each resident
                                if (sendEmail($category, $message, $target_audience, $recipient_email, $recipient_name)) {
                                    $emails_sent++;
                                }
                            }
                        } else {
                            throw new Exception('No female residents found within the specified age range.');
                        }
                    } else {
                        throw new Exception('Female age range values are missing.');
                    }
                } 
            } else {
                $response['success'] = true;
                $response['message'] = 'Announcement created successfully!';
            }
        } else {
            throw new Exception('Failed to create announcement: ' . $stmt->error);
        }
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>