<?php
ob_start();                 // make sure header() can send
session_start();
require __DIR__ . '/db_connect.php';

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error_message = "Please enter username and password.";
    } else {
        $sql = "SELECT id, username, password, role FROM users WHERE username = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                // ✅ good login
                session_regenerate_id(true);
                $_SESSION['user_id']  = (int)$row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role']     = $row['role'];

                // ✅ redirect by role (use absolute paths)
                switch ($row['role']) {
                    case 'admin':
                        header("Location: /scholarship/Admin/dashboard.php"); exit;
                    case 'osa':
                        header("Location: /scholarship/OSAS/dashboard/dashboard.php"); exit;
                    case 'student':
                        header("Location: /scholarship/students/dashboard/dashboard.php"); exit;
                    default:
                        $error_message = "Unknown role.";
                }
            } else {
                $error_message = "Invalid password.";
            }
        } else {
            $error_message = "Invalid username.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Information System</title>
    <link rel="icon" type="image/x-icon" href="logo.png">
    <link rel="stylesheet" href="login.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h1 id="title">Scholarship Information System</h1>
            <form action="login.php" method="POST"> 
            <div class="input-group">

                <!-- Username -->
                <div class="input-field">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" id="username" name="username" placeholder="Enter username" required>
                </div>

                <!-- Password -->
                <div class="input-field">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                    <i class="fa-solid fa-eye" id="togglePassword" style="cursor:pointer;"></i>
                </div>

                <!-- Remember Me -->
                <div class="remember">
                    <label><input type="checkbox" name="rememberMe" id="rememberMe" class="checkbox"> Remember me </label>
                </div>

                <!-- Error message -->
                    <?php if (!empty($error_message)): ?>
                        <p id="error-message" style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
                    <?php endif; ?>

                <!-- Login Button -->
                <div class="btn-field">
                    <button type="submit" id="logInBtn">Login</button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <!-- ✅ Correct script path -->
    <script src="script.js" defer></script>
</body>
</html>
