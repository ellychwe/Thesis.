<?php
include(__DIR__ . "/../../db_connect.php");

if (!isset($_GET['id']))
    die("No application selected.");
$app_id = intval($_GET['id']);

// Fetch application
$appResult = $conn->query("SELECT * FROM student_applications WHERE id = $app_id");
if ($appResult->num_rows === 0)
    die("Application not found.");
$app = $appResult->fetch_assoc();

// Prepare documents
$documents = [
    'TDP Form' => $app['tdp_form'],
    'Registration Form' => $app['reg_form'],
    'Grades Form' => $app['grades_form']
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Application</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-hover: #2563eb;
            --success-color: #10b981;
            --success-hover: #059669;
            --danger-color: #ef4444;
            --danger-hover: #dc2626;
            --warning-color: #f59e0b;
            --warning-hover: #d97706;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, var(--gray-50) 0%, #ffffff 100%);
            color: var(--gray-800);
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem 0;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            color: white;
            border-radius: 1rem;
            box-shadow: var(--shadow-lg);
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: capitalize;
            margin-top: 1rem;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
            overflow: hidden;
            border: 1px solid var(--gray-200);
            transition: all 0.3s ease;
            padding: 1.5rem 2rem;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .card-header {
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .card-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gray-800);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 0;
        }

        .info-item {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            transition: background-color 0.2s ease;
        }

        .info-item:hover {
            background: var(--gray-50);
        }

        .info-item:last-child,
        .info-item:nth-last-child(2):nth-child(odd) {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: var(--gray-600);
            width: 140px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-value {
            color: var(--gray-800);
            flex: 1;
            word-break: break-word;
        }

        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1rem;
            padding: 1.5rem;
        }

        .document-card {
            background: var(--gray-50);
            border: 2px dashed var(--gray-300);
            border-radius: 0.75rem;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .document-card:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .document-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .document-card:hover .document-icon {
            color: white;
        }

        .document-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .document-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .document-card:hover .document-link {
            background: white;
            color: var(--primary-color);
        }

        .document-link:hover {
            transform: scale(1.05);
        }

        .document-unavailable {
            color: var(--danger-color);
            font-weight: 500;
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .actions {
            padding: 2rem;
            background: var(--gray-50);
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            border-top: 1px solid var(--gray-200);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .btn-success {
            background: var(--success-color);
            color: white;
        }

        .btn-success:hover {
            background: var(--success-hover);
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background: var(--danger-hover);
        }

        .btn-secondary {
            background: white;
            color: var(--gray-700);
            border-color: var(--gray-300);
        }

        .btn-secondary:hover {
            background: var(--gray-50);
            border-color: var(--gray-400);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
            color: var(--gray-600);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--gray-400);
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .header h1 {
                font-size: 2rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .info-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .info-label {
                width: auto;
            }

            .actions {
                flex-direction: column;
                align-items: stretch;
            }

            .btn {
                justify-content: center;
            }

            .documents-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Loading animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeIn 0.6s ease-out;
        }

        .card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .card:nth-child(3) {
            animation-delay: 0.2s;
        }

        .card:nth-child(4) {
            animation-delay: 0.3s;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-user-graduate"></i> Application Review</h1>
            <p>Scholarship application details and document review</p>
            <div class="status-badge status-<?php echo strtolower($app['status']); ?>">
                <i class="fas fa-circle"></i>
                <?php echo htmlspecialchars($app['status']); ?>
            </div>
        </div>

        <!-- Student Information -->
        <div class="card">
            <h2>Student Info</h2>
            <p><strong>ID:</strong> <?= htmlspecialchars($app['student_id']) ?></p>
            <p><strong>Full Name:</strong>
                <?= htmlspecialchars($app['last_name'] . ", " . $app['first_name'] . " " . $app['middle_name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($app['email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($app['phone']) ?></p>
            <p><strong>Date of Birth:</strong> <?= htmlspecialchars($app['dob']) ?></p>
            <p><strong>Gender:</strong> <?= htmlspecialchars($app['gender']) ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($app['address']) ?></p>
            <p><strong>Zip Code:</strong> <?= htmlspecialchars($app['zipcode']) ?></p>
        </div>

        <div class="card">
            <h2>Academic Info</h2>
            <p><strong>Program:</strong> <?= htmlspecialchars($app['program']) ?></p>
            <p><strong>Year Level:</strong> <?= htmlspecialchars($app['year_level']) ?></p>
            <p><strong>Section:</strong> <?= htmlspecialchars($app['section']) ?></p>
            <p><strong>Scholarship Type:</strong> <?= htmlspecialchars($app['scholarship_type']) ?></p>
            <p><strong>Semester:</strong> <?= htmlspecialchars($app['semester']) ?></p>
            <p><strong>Academic Year:</strong> <?= htmlspecialchars($app['academic_year']) ?></p>
            <p><strong>Date Submitted:</strong> <?= htmlspecialchars($app['date_submitted']) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($app['status']) ?></p>
        </div>

        <!-- Documents -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-file-alt"></i> Uploaded Documents</h2>
            </div>
            <div class="card-body">
                <div class="documents-grid">
                    <?php foreach ($documents as $label => $fileName): ?>
                        <div class="document-card">
                            <i class="fas fa-file-pdf document-icon"></i>
                            <div class="document-title"><?= htmlspecialchars($label) ?></div>
                            <?php
                            $filePath = __DIR__ . "/../../uploads/" . $fileName;
                            $downloadPath = "../../uploads/" . $fileName;
                            if (!empty($fileName) && file_exists($filePath)):
                                ?>
                                <a class="document-link" href="<?= htmlspecialchars($downloadPath) ?>" download>
                                    <i class="fas fa-download"></i> Download
                                </a>
                            <?php else: ?>
                                <div class="document-unavailable">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    File not found
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Actions (Approve/Reject) -->
        <div class="card">
            <div class="actions">
                <a class="btn btn-success" href="approve.php?id=<?= $app_id ?>"><i class="fas fa-check"></i> Approve</a>
                <a class="btn btn-danger" href="reject.php?id=<?= $app_id ?>"><i class="fas fa-times"></i> Reject</a>
                <a class="btn btn-secondary" href="verification.php"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
</body>

</html>
<?php $conn->close(); ?>