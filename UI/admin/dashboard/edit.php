<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /scholarship/login.php");
    exit;
}

include '../db_connect.php';

// Get student ID from URL
if (!isset($_GET['id'])) {
    die("No student ID provided.");
}
$id = intval($_GET['id']);

// Handle update form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        header("Location: dashboard.php"); // ✅ go back after save
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Fetch student data
$result = $conn->query("SELECT * FROM admin_dashboard_students WHERE id=$id");
if ($result->num_rows === 0) {
    die("Student not found.");
}
$student = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <link rel="stylesheet" href="dashboardstyle.css">
</head>
<body>
    <h2>Edit Student</h2>
    <form method="POST">
        <label>School ID:</label>
        <input type="text" name="school_id" value="<?php echo $student['school_id']; ?>" required><br>

        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $student['name']; ?>" required><br>

        <label>Scholarship:</label>
        <input type="text" name="scholarship" value="<?php echo $student['scholarship']; ?>" required><br>

        <label>Program:</label>
        <input type="text" name="program" value="<?php echo $student['program']; ?>" required><br>

        <label>Year Level:</label>
        <input type="text" name="year_level" value="<?php echo $student['year_level']; ?>" required><br>

        <label>Enrollment Status:</label>
        <select name="enrollment_status" required>
            <option value="Enrolled" <?php if ($student['enrollment_status'] === 'Enrolled') echo 'selected'; ?>>Enrolled</option>
            <option value="Not Enrolled" <?php if ($student['enrollment_status'] === 'Not Enrolled') echo 'selected'; ?>>Not Enrolled</option>
        </select><br><br>

        <button type="submit">Save</button>
        <a href="dashboard.php">Cancel</a>
    </form>
</body>
</html>
