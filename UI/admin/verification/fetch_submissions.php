<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "scholarship";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT id, student_id, first_name, last_name, program, scholarship_type, date_submitted, status 
        FROM student_applications 
        ORDER BY date_submitted DESC";

$result = $conn->query($sql);

$applications = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $applications[] = $row;
    }
}

echo json_encode($applications);
$conn->close();
?>
