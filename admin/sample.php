<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../src/connect.php'; // Your database connection file
require '../src/account.php';

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

function sendEmail($category, $message, $target_audience, $recipient_email, $recipient_name, $recipient_sex) {
    if ($recipient_sex === 'Male') {
        $recipient_is = 'Mr. ';
    } else {
        $recipient_is = 'Mrs. ';
    }

    $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'malatik.16@gmail.com';
            $mail->Password = 'qizq xfhr xtgg yhmo';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('malatik.16@gmail.com', 'Barangay Baritan');
            $mail->addAddress($recipient_email, $recipient_name);
            $mail->Subject = $category;
            $mail->Body = 'Good Day, '.$recipient_is .$recipient_name.'! '. $message;

            $mail->send();
        } catch (Exception $e) {
            echo "Email could not be sent. Error: {$mail->ErrorInfo}";
        }
    
}


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         // Retrieve form data
         $category = $_POST['category'];
         $message = $_POST['message'];
         $target_audience = implode(', ', $_POST['target_audience']); // Convert array to string
         $delivery_channels = $_POST['delivery_channels'];
         $start_date = ($delivery_channels === 'Website') ? $_POST['start_date'] : null; // Conditional start date
         $end_date = ($delivery_channels === 'Website') ? $_POST['end_date'] : null; // Conditional end date
         
         // Retrieve male age range values
        $male_min_age = isset($_POST['male_min_age']) ? $_POST['male_min_age'] : null;
        $male_max_age = isset($_POST['male_max_age']) ? $_POST['male_max_age'] : null;

        // Retrieve Female age range values
        $female_min_age = isset($_POST['female_min_age']) ? $_POST['female_min_age'] : null;
        $female_max_age = isset($_POST['female_max_age']) ? $_POST['female_max_age'] : null;
 
         // Generate the announcement_id directly
         $prefix = strtoupper(substr($_SESSION['Account_Role'], 0, 3)); // First 3 letters of Account_Role, uppercase
         $current_date = new DateTime();
         $month = $current_date->format('m'); // Two-digit month
         $year = $current_date->format('y'); // Last two digits of the year
         $hours = $current_date->format('H'); // Hours in 24-hour format
         $minutes = $current_date->format('i'); // Minutes
         $announcement_id = $prefix . $month . $year . $hours . $minutes; // Combine all parts

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
        
         if ($delivery_channels === 'Email/SMS') {
            // Check if "All Residents" is selected
            if ($target_audience === 'All Residents') {
                // Fetch all resident emails from Residents_information_tbl
                $sql = "SELECT Resident_Email, CONCAT(FirstName, ' ', LastName) AS Full_Name, Sex FROM residents_information_tbl";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $emails_sent = 0;
                    while ($row = $result->fetch_assoc()) {
                        $recipient_email = $row['Resident_Email'];
                        $recipient_name = $row['Full_Name'];
                        $recipient_sex = $row['Sex'];

                        // Send email to each resident
                        if (sendEmail($category, $message, $target_audience, $recipient_email, $recipient_name, $recipient_sex)) {
                            $emails_sent++;
                        }
                    }

                    
                } else {
                    throw new Exception('No residents found in the database.');
                }
            } if ($target_audience === 'Head of the Family') {
                // Fetch all resident emails from Residents_information_tbl
                $sql = "SELECT Resident_Email, CONCAT(FirstName, ' ', LastName) AS Full_Name, Sex FROM residents_information_tbl WHERE Role = 'Head'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $emails_sent = 0;
                    while ($row = $result->fetch_assoc()) {
                        $recipient_email = $row['Resident_Email'];
                        $recipient_name = $row['Full_Name'];
                        $recipient_sex = $row['Sex'];

                        // Send email to each resident
                        if (sendEmail($category, $message, $target_audience, $recipient_email, $recipient_name, $recipient_sex)) {
                            $emails_sent++;
                        }
                    }

                    
                } else {
                    throw new Exception('No residents found in the database.');
                }
            } if ($target_audience === 'Senior Citizen') {
                // Fetch all resident emails from Residents_information_tbl
                $sql = "SELECT Resident_Email, CONCAT(FirstName, ' ', LastName) AS Full_Name, Sex FROM residents_information_tbl WHERE Eligibility_Status = 'Senior Citizen'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $emails_sent = 0;
                    while ($row = $result->fetch_assoc()) {
                        $recipient_email = $row['Resident_Email'];
                        $recipient_name = $row['Full_Name'];
                        $recipient_sex = $row['Sex'];

                        // Send email to each resident
                        if (sendEmail($category, $message, $target_audience, $recipient_email, $recipient_name, $recipient_sex)) {
                            $emails_sent++;
                        }
                    }

                } else {
                    throw new Exception('No residents found in the database.');
                }
            } if ($target_audience === 'PWD') {
                // Fetch all resident emails from Residents_information_tbl
                $sql = "SELECT Resident_Email, CONCAT(FirstName, ' ', LastName) AS Full_Name, Sex FROM residents_information_tbl WHERE Eligibility_Status = 'Person with Disability'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $emails_sent = 0;
                    while ($row = $result->fetch_assoc()) {
                        $recipient_email = $row['Resident_Email'];
                        $recipient_name = $row['Full_Name'];
                        $recipient_sex = $row['Sex'];

                        // Send email to each resident
                        if (sendEmail($category, $message, $target_audience, $recipient_email, $recipient_name, $recipient_sex)) {
                            $emails_sent++;
                        }
                    }

                    
                } else {
                    throw new Exception('No residents found in the database.');
                }
            } if ($target_audience === 'Male (Age Range)') {
                if ($male_min_age !== null && $male_max_age !== null) {
                    // Fetch male residents within the specified age range
                    $sql = "SELECT Resident_Email, CONCAT(FirstName, ' ', LastName) AS Full_Name, Sex 
                            FROM residents_information_tbl 
                            WHERE Sex = 'Male' AND Age BETWEEN ? AND ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $male_min_age, $male_max_age);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $recipient_email = $row['Resident_Email'];
                            $recipient_name = $row['Full_Name'];
                            $recipient_sex = $row['Sex'];

                            // Send email to each resident
                            if (sendEmail($category, $message, $target_audience, $recipient_email, $recipient_name, $recipient_sex)) {
                                $emails_sent++;
                            }
                        }
                    } else {
                        throw new Exception('No male residents found within the specified age range.');
                    }
                } else {
                    throw new Exception('Male age range values are missing.');
                }
            } if ($target_audience === 'Female (Age Range)') {
                if ($female_min_age !== null && $female_max_age !== null) {
                    // Fetch female residents within the specified age range
                    $sql = "SELECT Resident_Email, CONCAT(FirstName, ' ', LastName) AS Full_Name, Sex 
                            FROM residents_information_tbl 
                            WHERE Sex = 'Female' AND Age BETWEEN ? AND ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $female_min_age, $female_max_age);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $recipient_email = $row['Resident_Email'];
                            $recipient_name = $row['Full_Name'];
                            $recipient_sex = $row['Sex'];

                            // Send email to each resident
                            if (sendEmail($category, $message, $target_audience, $recipient_email, $recipient_name, $recipient_sex)) {
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
    
         }
    } 
    

    }

?>