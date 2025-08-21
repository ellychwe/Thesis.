<?php
include '../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $school_id = $_POST['school_id'];
    $name = $_POST['name'];
    $scholarship = $_POST['scholarship'];
    $program = $_POST['program'];
    $year_level = $_POST['year_level'];
    $enrollment_status = $_POST['enrollment_status'];

    $stmt = $conn->prepare("UPDATE admin_dashboard_students 
        SET school_id=?, name=?, scholarship=?, program=?, year_level=?, enrollment_status=? 
        WHERE id=?");
    $stmt->bind_param("ssssssi", $school_id, $name, $scholarship, $program, $year_level, $enrollment_status, $id);

    if ($stmt->execute()) {
        header("Location: dashboard.php?success=1");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
