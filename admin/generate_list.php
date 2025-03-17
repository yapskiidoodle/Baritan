<?php
require '../src/connect.php'; // Include your database connection file
require('fpdf186/fpdf.php'); // Include the FPDF library

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $residentType = $_POST['resident_type'];
    $maleMinAge = $_POST['male_min_age'] ?? null;
    $maleMaxAge = $_POST['male_max_age'] ?? null;
    $femaleMinAge = $_POST['female_min_age'] ?? null;
    $femaleMaxAge = $_POST['female_max_age'] ?? null;
    $purpose = $_POST['purpose']; // Get the purpose/reason

    // Build the SQL query based on the selected criteria
    $sql = "SELECT * FROM Residents_information_tbl WHERE 1=1";

    if ($residentType === "Senior Citizen") {
        $sql .= " AND Eligibility_Status = 'senior_citizen'";
    } elseif ($residentType === "Head of the Family") {
        $sql .= " AND Role = 'Head'";
    } elseif ($residentType === "pwd") {
        $sql .= " AND Eligibility_Status = 'pwd'";
    } elseif ($residentType === "Single Parent") {
        $sql .= " AND Eligibility_Status = 'Single Parent'";
    } elseif ($residentType === "Male Age Range") {
        if ($maleMinAge !== null && $maleMaxAge !== null) {
            $sql .= " AND Sex = 'Male' AND TIMESTAMPDIFF(YEAR, Date_of_Birth, CURDATE()) BETWEEN $maleMinAge AND $maleMaxAge";
        }
    } elseif ($residentType === "Female Age Range") {
        if ($femaleMinAge !== null && $femaleMaxAge !== null) {
            $sql .= " AND Sex = 'Female' AND TIMESTAMPDIFF(YEAR, Date_of_Birth, CURDATE()) BETWEEN $femaleMinAge AND $femaleMaxAge";
        }
    }

    // Execute the query
    $result = $conn->query($sql);

    // Create a new PDF instance
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Set the PDF title (internal title)
    $pdf->SetTitle("Resident List - " . $residentType);

    // Add Logo
    $pdf->Image('pics/logo.png', 90, 5, 25); // (x, y, width)

    $pdf->Ln(15);

    // Barangay Header
    $pdf->Cell(0, 10, 'Barangay Baritan - Resident Population Report', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, 'Official Barangay Report', 0, 1, 'C');
    $pdf->Cell(0, 5, 'Generated on: ' . date("F d, Y"), 0, 1, 'C');
    $pdf->Ln(1);

    // Add report details
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, 'Generated Resident List for: ' . $residentType, 0, 1, 'C');

    // Display the correct age range based on the resident type
    if ($residentType === "Male Age Range") {
        $pdf->Cell(0, 10, 'Age Range: ' . $maleMinAge . ' - ' . $maleMaxAge, 0, 1, 'C');
    } elseif ($residentType === "Female Age Range") {
        $pdf->Cell(0, 10, 'Age Range: ' . $femaleMinAge . ' - ' . $femaleMaxAge, 0, 1, 'C');
    }

    // Add the purpose/reason to the PDF
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, 'Purpose: ' . $purpose . '', 0, 5, 'C'); // Format the purpose/reason

    // Add a line break
    $pdf->Ln(1);

    if ($result->num_rows > 0) {
        // Center the table
        $table_width = 170; // Total width of the table
        $start_x = (210 - $table_width) / 2; // Calculate center position
        $pdf->SetX($start_x);

        // Set font for the table header
        $pdf->SetFont('Arial', 'B', 8);

        // Table header
        $pdf->Cell(30, 8, 'Last Name', 1, 0, 'C'); // Adjusted width
        $pdf->Cell(30, 8, 'First Name', 1, 0, 'C'); // Adjusted width
        $pdf->Cell(15, 8, 'Age', 1, 0, 'C'); // Adjusted width
        $pdf->Cell(15, 8, 'Sex', 1, 0, 'C'); // Adjusted width
        $pdf->Cell(55, 8, 'Address', 1, 0, 'C'); // Adjusted width
        $pdf->Cell(25, 8, 'Contact', 1, 1, 'C'); // Adjusted width

        // Set font for the table content
        $pdf->SetFont('Arial', '', 8);

        // Fetch and add data to the PDF
        $totalResidents = 0;
        while ($row = $result->fetch_assoc()) {
            $pdf->SetX($start_x); // Ensure each row starts at the center position

            // Add table row data
            $pdf->Cell(30, 5, $row['LastName'], 1, 0, 'C');
            $pdf->Cell(30, 5, $row['FirstName'], 1, 0, 'C');
            $pdf->Cell(15, 5, date_diff(date_create($row['Date_of_Birth']), date_create('today'))->y, 1, 0, 'C');
            $pdf->Cell(15, 5, $row['Sex'], 1, 0, 'C');
            $pdf->Cell(55, 5, $row['Address'], 1, 0, 'C');
            $pdf->Cell(25, 5, $row['Contact_Number'], 1, 1, 'C');

            $totalResidents++;
        }

        // Add a summary section
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, 'Summary:', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Total Residents: ' . $totalResidents, 0, 1, 'C');
    } else {
        // If no residents are found, display a message
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'No residents found matching the criteria.', 0, 1, 'C');
    }

    // Generate a custom filename based on the selected list
    $filename = "Resident_List_" . str_replace(" ", "_", $residentType) . ".pdf";

    // Output the PDF to the browser with the custom filename
    $pdf->Output('I', $filename);

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request.";
}
?>