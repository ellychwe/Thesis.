<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$role = $_SESSION['role'] ?? null;

// Menu items by role
$menu = [
    "admin" => [
        ["icon" => "fa-gauge", "label" => "Dashboard", "url" => "/scholarship/Admin/dashboard.php"],
        ["icon" => "fa-file-pen", "label" => "Verification", "url" => "/scholarship/Admin/Verification/verification.php"],
        ["icon" => "fa-file-import", "label" => "Liquidation", "url" => "/scholarship/Admin/liquidation/liquidation.php"],
        ["icon" => "fa-file", "label" => "Reports", "url" => "/scholarship/Admin/reports/reports.php"],
        ["icon" => "fa-brands fa-google-scholar", "label" => "Scholars List", "url" => "/scholarship/Admin/list/list.php"],
        ["icon" => "fa-gear", "label" => "Settings", "url" => "/scholarship/Admin/settings/settings.php"],
        ["icon" => "fa-right-from-bracket", "label" => "Log-out", "url" => "/scholarship/logout.php"]
    ],
    "student" => [
        ["icon" => "fa-gauge", "label" => "Dashboard", "url" => "/scholarship/students/dashboard/dashboard.php"],
        ["icon" => "fa-user", "label" => "My Profile", "url" => "/scholarship/students/profile/profile.php"],
        ["icon" => "fa-file-import", "label" => "Apply for Scholarship", "url" => "/scholarship/students/apply/apply.php"],
        ["icon" => "fa-circle-notch", "label" => "Application Status", "url" => "/scholarship/students/status/status.php"],
        ["icon" => "fa-file", "label" => "Documents", "url" => "/scholarship/students/documents/documents.php"],
        ["icon" => "fa-file-contract", "label" => "Renewal & Expiry Tracker", "url" => "/scholarship/students/renew/renew.php"],
        ["icon" => "fa-square-poll-vertical", "label" => "Scholarship Results", "url" => "/scholarship/students/results/results.php"],
        ["icon" => "fa-right-from-bracket", "label" => "Log-out", "url" => "/scholarship/logout.php"]
    ],
    "osa" => [
        ["icon" => "fa-gauge", "label" => "Dashboard", "url" => "/scholarship/OSAS/dashboard.php"],
        ["icon" => "fa-file", "label" => "Reports", "url" => "/scholarship/OSAS/reports/reports.php"],
        ["icon" => "fa-gear", "label" => "Settings", "url" => "/scholarship/OSAS/settings/settings.php"],
        ["icon" => "fa-right-from-bracket", "label" => "Log-out", "url" => "/scholarship/logout.php"]
    ]
];

$currentPath = strtok($_SERVER['REQUEST_URI'], '?'); // strip query string
?>

<?php if ($role && isset($menu[$role])): ?>
    <div class="logo">
        <img src="/scholarship/logo.png" alt="">
        <h2>Scholarship System</h2>
    </div>

    <ul class="items">
        <?php foreach ($menu[$role] as $item): ?>
            <li class="<?= ($currentPath === $item['url']) ? 'active' : '' ?>">
                <a href="<?= $item['url'] ?>">
                    <i class="fa-solid <?= $item['icon'] ?>"></i>
                    <span><?= $item['label'] ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>