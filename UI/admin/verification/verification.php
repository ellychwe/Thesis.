<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role'])) {
    header("Location: /scholarship/login.php");
    exit;
}

// Restrict access to admin-only dashboard
if ($_SESSION['role'] !== 'admin') {
    header("Location: /scholarship/login.php");
    exit;
}

include(__DIR__ . "/../../db_connect.php");

// Fetch all student applications
$sql = "SELECT * FROM student_applications ORDER BY date_submitted DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification</title>
    <link rel="icon" type="image/x-icon" href="logo.png">
    <link rel="stylesheet" href="verification.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/d8f1bbefaf.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <!-- Sidebar -->
    <section id="menu">
        <?php include __DIR__ . "/../../sidebar.php"; ?>
    </section>

    <section id="interface">
        <div class="navigation">
            <div class="n1">
                <div>
                    <i id="menu-btn" class="fa-solid fa-bars"></i>
                </div>
                <div class="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" placeholder="Search by name or ID">
                </div>
            </div>
            <div class="profile">
                <i class="fa-solid fa-comment"></i>
                <i class="fa-solid fa-bell"></i>
                <img src="account.jpg" alt="Profile" class="profile-icon" />
            </div>
        </div>

        <h3 class="i-name">Verification</h3>

        <div class="documents">
            <div class="val-box">
                <div class="dropdown">
                    <button onclick="toggleDropdown()" class="dropbtn">
                        All Scholarships <i class="fa fa-caret-down"></i>
                    </button>
                    <div id="scholarshipDropdown" class="dropdown-content">
                        <a href="#" data-scholarship="all">All</a>
                        <a href="#" data-scholarship="TES">TES</a>
                        <a href="#" data-scholarship="CHED">CHED</a>
                        <a href="#" data-scholarship="Local Grant">Local Grant</a>
                    </div>
                </div>
            </div>

            <div class="right-buttons">
                <div class="val-box same-size">
                    <button class="imppbtn">Import File</button>
                </div>
                <div class="val-box same-size">
                    <button class="exportbtn" onclick="window.location.href='export_pdf.php'">Export PDF</button>
                </div>
                <div class="val-box same-size">
                    <button class="exportbtn" onclick="window.location.href='export_excel.php'">Export Excel</button>
                </div>
            </div>
        </div>

        <div class="board">
            <table width="100%">
                <thead>
                    <tr>
                        <td>School ID</td>
                        <td>Name</td>
                        <td>Scholarship</td>
                        <td>Date Submitted</td>
                        <td>Status</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody id="applications-table">
                    <!-- Data will be inserted here via JS -->
                </tbody>
            </table>
        </div>
    </section>

    <script>
        fetch("fetch_submissions.php")
            .then(res => res.json())
            .then(data => {
                const table = document.getElementById("applications-table");
                if (data.length === 0) {
                    table.innerHTML = `<tr><td colspan="7">No submissions found</td></tr>`;
                    return;
                }
                data.forEach(app => {
                    let row = `
                        <tr>
                            <td>${app.student_id}</td>
                            <td>${app.first_name} ${app.last_name}</td>
                            <td>${app.scholarship_type}</td>
                            <td>${app.date_submitted}</td>
                            <td>${app.status}</td>
                            <td><a href="view_submission.php?id=${app.id}">View</a></td>
                        </tr>
                    `;
                    table.innerHTML += row;
                });
            })
            .catch(err => {
                console.error("Error fetching submissions:", err);
            });
    </script>

</body>
</html>
