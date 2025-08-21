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

include '../db_connect.php'; // ✅ connect to DB

// --- Stats ---
$total_students = $conn->query("SELECT COUNT(*) AS total FROM admin_dashboard_students")->fetch_assoc()['total'];
$pending = $conn->query("SELECT COUNT(*) AS total FROM admin_dashboard_documents WHERE doc_type='Pending' AND status='Active'")->fetch_assoc()['total'];
$expired = $conn->query("SELECT COUNT(*) AS total FROM admin_dashboard_documents WHERE doc_type='Expired' AND status='Active'")->fetch_assoc()['total'];
$liquidation = $conn->query("SELECT COUNT(*) AS total FROM admin_dashboard_documents WHERE doc_type='Liquidation' AND status='Active'")->fetch_assoc()['total'];

// --- Students ---
$students = $conn->query("SELECT * FROM admin_dashboard_students");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" type="image/x-icon" href="logo.png">
    <link rel="stylesheet" href="dashboardstyle.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/d8f1bbefaf.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- Sidebar -->
    <section id="menu">
        <?php include '../sidebar.php'; ?>
    </section>

    <!-- Main Interface -->
    <section id="interface">
        <div class="navigation">
            <div class="n1">
                <div>
                    <i id="menu-btn" class="fa-solid fa-bars"></i>
                </div>
                <div class="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" placeholder="Search" id="searchInput">
                </div>
            </div>
            <div class="profile">
                <i class="fa-solid fa-comment" id="messages"></i>
                <i class="fa-solid fa-bell" id="notifications">
                    <span id="notifCount" class="count"></span>
                </i>
                <img src="account.jpg" alt="Profile" class="profile-icon" id="profilePic" />
                <div id="profileDropdown" class="dropdown-menu"></div>
            </div>
        </div>

        <h3 class="i-name">Admin Dashboard</h3>

        <!-- Stats Section -->
        <div class="scholars">
            <div class="val-box">
                <i class="fa-solid fa-users"></i>
                <div>
                    <h3><?php echo $total_students; ?></h3>
                    <span>Student Scholars</span>
                </div>
            </div>

            <div class="val-box">
                <i class="fa-solid fa-hourglass-end"></i>
                <div>
                    <h3><?php echo $pending; ?></h3>
                    <span>Pending</span>
                </div>
            </div>

            <div class="val-box">
                <i class="fa-solid fa-file-excel"></i>
                <div>
                    <h3><?php echo $expired; ?></h3>
                    <span>Expired Docs</span>
                </div>
            </div>

            <div class="val-box">
                <i class="fa-solid fa-folder-open"></i>
                <div>
                    <h3><?php echo $liquidation; ?></h3>
                    <span>Liquidation</span>
                </div>
            </div>
        </div>

        <!-- Scholars Table -->
        <div class="board">
            <table width="100%">
                <thead>
                    <tr>
                        <td>Student ID Number</td>
                        <td>Name</td>
                        <td>Scholarship</td>
                        <td>Program</td>
                        <td>Year Level</td>
                        <td>Enrollment Status</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $students->fetch_assoc()) { ?>
                        <tr>
                            <td class="id">
                                <h5><?php echo $row['school_id']; ?></h5>
                            </td>
                            <td class="people">
                                <p><?php echo $row['name']; ?></p>
                            </td>
                            <td class="scholarship">
                                <p><?php echo $row['scholarship']; ?></p>
                            </td>
                            <td class="program">
                                <p><?php echo $row['program']; ?></p>
                            </td>
                            <td class="year">
                                <p><?php echo $row['year_level']; ?></p>
                            </td>
                            <td class="status">
                                <p
                                    style="color:<?php echo ($row['enrollment_status'] === 'Enrolled') ? 'green' : 'red'; ?>">
                                    <?php echo $row['enrollment_status']; ?>
                                </p>
                            </td>
                            <td>
                                <a href="#" class="edit-btn" data-id="<?php echo $row['id']; ?>"
                                    data-school_id="<?php echo $row['school_id']; ?>"
                                    data-name="<?php echo $row['name']; ?>"
                                    data-scholarship="<?php echo $row['scholarship']; ?>"
                                    data-program="<?php echo $row['program']; ?>"
                                    data-year="<?php echo $row['year_level']; ?>"
                                    data-status="<?php echo $row['enrollment_status']; ?>">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </section>

    <!-- ✅ MODAL -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Edit Student Info</h2>
            <form action="update_student.php" method="POST">
                <!-- Hidden field for DB ID -->
                <input type="hidden" id="edit-id" name="id">

                <label for="edit-school_id">Student ID Number</label>
                <input type="text" id="edit-school_id" name="school_id" required>

                <label for="edit-name">Name</label>
                <input type="text" id="edit-name" name="name" required>

                <label for="edit-scholarship">Scholarship</label>
                <input type="text" id="edit-scholarship" name="scholarship" required>

                <label for="edit-program">Program</label>
                <input type="text" id="edit-program" name="program" required>

                <label for="edit-year">Year Level</label>
                <input type="text" id="edit-year" name="year_level" required>

                <label for="edit-status">Enrollment Status</label>
                <select id="edit-status" name="enrollment_status" required>
                    <option value="Enrolled">Enrolled</option>
                    <option value="Not Enrolled">Not Enrolled</option>
                </select>

                <button type="submit" class="save-btn">Save Changes</button>
            </form>
        </div>
    </div>

    </div>

    <script src="sidebar.js" defer></script>
    <script src="topbar.js" defer></script>
    <script src="chat.js" defer></script>
    <script src="table.js" defer></script>

    <script>
    // ✅ Function to open modal and populate fields
    function openModal(id, school_id, name, scholarship, program, year_level, status) {
        document.getElementById("edit-id").value = id;
        document.getElementById("edit-school_id").value = school_id;
        document.getElementById("edit-name").value = name;
        document.getElementById("edit-scholarship").value = scholarship;
        document.getElementById("edit-program").value = program;
        document.getElementById("edit-year").value = year_level;
        document.getElementById("edit-status").value = status;

        document.getElementById("editModal").style.display = "flex";
    }

    // ✅ Attach click listeners to Edit buttons
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Get row data
            const row = this.closest("tr");
            const id = this.getAttribute("data-id");
            const school_id = row.querySelector("td.id h5").innerText.trim();
            const name = row.querySelector("td.people p").innerText.trim();
            const scholarship = row.querySelector("td.scholarship p").innerText.trim();
            const program = row.querySelector("td.program p").innerText.trim();
            const year_level = row.querySelector("td.year p").innerText.trim();
            const status = row.querySelector("td.status p").innerText.trim();

            openModal(id, school_id, name, scholarship, program, year_level, status);
        });
    });

    // ✅ Close modal when clicking the "×"
    function closeModal() {
        document.getElementById("editModal").style.display = "none";
    }

    // ✅ Also close when clicking outside modal
    window.addEventListener("click", function (e) {
        const modal = document.getElementById("editModal");
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
</script>


</body>

</html>
