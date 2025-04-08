<?php
require ('../src/connect.php');

// Simplified query that gets all role counts
$sql = "SELECT Role, COUNT(*) as count FROM account_tbl GROUP BY Role";
$result = $conn->query($sql);

$counts = [];
while ($row = $result->fetch_assoc()) {
    $counts[$row['Role']] = (int)$row['count'];
}

// Ensure all roles exist in the response
$requiredRoles = ['Chairman', 'Secretary', 'Treasurer', 'Counselor', 'Lupon', 'SK'];
foreach ($requiredRoles as $role) {
    if (!isset($counts[$role])) {
        $counts[$role] = 0;
    }
}

header('Content-Type: application/json');
echo json_encode($counts);
?>