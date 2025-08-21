<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: /scholarship/login.php");
    exit;
}

include(__DIR__ . "/../../../db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect student info
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'] ?? '';
    $student_id = $_POST['student_id'];
    $program = $_POST['program'];
    $year_level = $_POST['year_level'];
    $section = ($_POST['section'] === 'other') ? $_POST['other_section'] : $_POST['section'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $zipcode = $_POST['zipcode'];

    // Scholarship info
    $scholarship_type_raw = ($_POST['scholarship_type'] === 'other') 
        ? $_POST['other_scholarship'] 
        : $_POST['scholarship_type'];
    $scholarship_type = strtoupper(trim($scholarship_type_raw));
    $semester = $_POST['semester'];
    $academic_year = $_POST['academic_year'];

    $date_submitted = date("Y-m-d H:i:s");
    $status = "Pending";

    // Upload folder (centralized at project root)
    $uploadDir = __DIR__ . "/../../../uploads/"; // project_root/uploads/
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // File uploads
    $tdp_form = $reg_form = $grades_form = null;

    if (!empty($_FILES['tdp_form']['name'])) {
        $tdp_form = uniqid("tdp_") . ".pdf";
        move_uploaded_file($_FILES['tdp_form']['tmp_name'], $uploadDir . $tdp_form);
    }
    if (!empty($_FILES['reg_form']['name'])) {
        $reg_form = uniqid("reg_") . ".pdf";
        move_uploaded_file($_FILES['reg_form']['tmp_name'], $uploadDir . $reg_form);
    }
    if (!empty($_FILES['grades_form']['name'])) {
        $grades_form = uniqid("grades_") . ".pdf";
        move_uploaded_file($_FILES['grades_form']['tmp_name'], $uploadDir . $grades_form);
    }

    // Insert application
    $stmt = $conn->prepare("INSERT INTO student_applications 
        (student_id, first_name, last_name, middle_name, program, year_level, section, email, phone, dob, gender, address, zipcode, 
         scholarship_type, semester, academic_year, tdp_form, reg_form, grades_form, status, date_submitted) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "sssssssssssssssssssss",
        $student_id,
        $first_name,
        $last_name,
        $middle_name,
        $program,
        $year_level,
        $section,
        $email,
        $phone,
        $dob,
        $gender,
        $address,
        $zipcode,
        $scholarship_type,
        $semester,
        $academic_year,
        $tdp_form,
        $reg_form,
        $grades_form,
        $status,
        $date_submitted
    );

    if ($stmt->execute()) {
        echo "<script>alert('Application submitted successfully!'); window.location='../../students/dashboard.php';</script>";
    } else {
        die("Insert failed: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>
