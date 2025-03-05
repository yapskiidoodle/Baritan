<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "Barangay_Baritan";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the residents table (Modify query based on your table structure)
$query = "SELECT * FROM Residents_information_tbl";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Set CSV headers
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=population_report.csv');

    // Open output stream
    $output = fopen('php://output', 'w');

    // Get column names dynamically
    $columns = array();
    while ($field_info = $result->fetch_field()) {
        $columns[] = $field_info->name;
    }

    // Add column headers to CSV
    fputcsv($output, $columns);

    // Add data rows
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    fclose($output);
} else {
    echo "No records found.";
}

// Close connection
$conn->close();
?>
