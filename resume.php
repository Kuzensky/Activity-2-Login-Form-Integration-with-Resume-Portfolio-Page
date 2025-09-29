<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$name = "Nayre, Christian B.";
$email = "cbnayre04@gmail.com";
$phone = "+63 956-513-6811";
$location = "Darasa, Tanauan City, Batangas";
$summary = "Computer Science student with a focus on web development and web design. Skilled in creating responsive, user-friendly websites using HTML, CSS, JavaScript, and modern frameworks. Passionate about blending creativity with technology to build engaging digital experiences, while continuously learning and adapting to new tools. Strong teamwork and problem-solving abilities with a genuine interest in contributing to innovative projects.";

$skills = [
    "Programming Languages: Python, Java, C#, C++",
    "Web Development: HTML, CSS, JavaScript, React Framework",
    "Mobile Development: Flutter",
    "Databases: MySQL, PostgreSQL, Mongoose (MongoDB)",
    "Tools & Platforms: GitHub, XAMPP, VS Code"
];

$projects = [
    [
        "title" => "FarmEase – Farmer-to-Market E-Commerce Website",
        "type" => "School Project | 2025",
        "details" => [
            "Developed an e-commerce platform using React Framework and Tailwind CSS, deployed via Vercel.",
            "Implemented CRUD operations (GET, POST, UPDATE) for product management and integrated third-party authentication and database services for secure user access.",
            "Optimized website performance with faster image loading and responsive design for seamless user experience."
        ]
    ],
    [
        "title" => "UI/UX Design Competition – 3rd Place",
        "type" => "School Competition | 2025",
        "details" => [
            "Developed an e-commerce platform using React Framework and Tailwind CSS, deployed via Vercel.",
            "Implemented CRUD operations (GET, POST, UPDATE) for product management and integrated third-party authentication and database services for secure user access."
        ]
    ],
    [
        "title" => "Quiller – Learning Management System",
        "type" => "Capstone Project | 2023",
        "details" => [
            "Designed and developed a learning management system (LMS) inspired by Google Classroom using HTML, CSS, and JavaScript.",
            "Enabled teachers to upload lessons, resources, and activities, while allowing students to access materials, track progress, and engage with content.",
            "Focused on scalable database integration (conceptual planning) and clean UI/UX to deliver an intuitive digital learning environment."
        ]
    ]
];

$organizations = [
    "Junior Philippine Computer Society (JPCS) – Member",
    "Association of Computer Engineering Students and Scholars (ACCESS) – Member"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name; ?> - Resume</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .resume-page {
            background: var(--background);
            min-height: 100vh;
            padding: 24px;
        }

        .action-buttons {
            position: absolute;
            top: 24px;
            right: 24px;
            display: flex;
            gap: 12px;
            z-index: 10;
        }

        .btn-print {
            padding: 12px 20px;
            background: var(--success);
            color: var(--text-inverse);
            text-decoration: none;
            border: none;
            border-radius: var(--border-radius);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
            animation: slideInDown 0.6s ease-out 0.3s both;
        }

        .btn-print:hover {
            background: #059669;
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-logout {
            padding: 12px 20px;
            background: var(--error);
            color: var(--text-inverse);
            text-decoration: none;
            border-radius: var(--border-radius);
            font-size: 14px;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
            animation: slideInDown 0.6s ease-out 0.4s both;
        }

        .btn-logout:hover {
            background: #dc2626;
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .resume-name {
            font-size: 48px;
            font-weight: 700;
            color: var(--text-primary);
            text-align: center;
            margin-bottom: 12px;
            letter-spacing: -0.025em;
        }

        .resume-contact {
            text-align: center;
            color: var(--text-secondary);
            font-size: 16px;
            margin-bottom: 40px;
            padding-bottom: 24px;
            border-bottom: 2px solid var(--border);
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 20px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--primary);
            display: inline-block;
        }

        .skills-list {
            list-style: none;
            padding: 0;
        }

        .skills-list li {
            background: var(--surface-elevated);
            padding: 12px 16px;
            margin-bottom: 8px;
            border-radius: var(--border-radius);
            border: 1px solid var(--border);
            font-weight: 500;
        }

        .project-item {
            background: var(--surface-elevated);
            padding: 24px;
            border-radius: var(--border-radius);
            border: 1px solid var(--border);
            margin-bottom: 20px;
        }

        .project-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .project-type {
            color: var(--text-secondary);
            font-style: italic;
            margin-bottom: 12px;
        }

        .project-details {
            list-style: none;
            padding: 0;
        }

        .project-details li {
            color: var(--text-primary);
            margin-bottom: 8px;
            padding-left: 16px;
            position: relative;
        }

        .project-details li::before {
            content: '•';
            color: var(--primary);
            position: absolute;
            left: 0;
            font-weight: bold;
        }

        .organizations-list {
            list-style: none;
            padding: 0;
        }

        .organizations-list li {
            background: var(--surface-elevated);
            padding: 16px 20px;
            margin-bottom: 12px;
            border-radius: var(--border-radius);
            border: 1px solid var(--border);
            color: var(--text-primary);
            font-weight: 500;
        }

        @media print {
            .resume-page {
                background: white !important;
                padding: 0 !important;
            }

            .action-buttons,
            .btn-print,
            .btn-logout {
                display: none !important;
            }

            .resume-container {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                padding: 20px !important;
            }
        }

        @media (max-width: 768px) {
            .action-buttons {
                position: fixed;
                top: 16px;
                right: 16px;
            }

            .resume-name {
                font-size: 36px;
            }

            .section-title {
                font-size: 20px;
            }
        }

        @media (max-width: 480px) {
            .resume-page {
                padding: 16px;
            }

            .resume-name {
                font-size: 28px;
            }

            .action-buttons {
                position: fixed;
                top: 12px;
                right: 12px;
                flex-direction: column;
                gap: 8px;
            }

            .btn-print,
            .btn-logout {
                padding: 10px 16px;
                font-size: 12px;
            }
        }
    </style>
</head>

<body class="resume-page">
    <div class="action-buttons">
        <button class="btn-print" onclick="printResume()">Print Resume</button>
        <a href="logout.php" class="btn-logout" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
    </div>

    <div class="resume-container">
        <h1 class="resume-name"><?php echo $name; ?></h1>
        <div class="resume-contact">
            <?php echo $email; ?> | <?php echo $phone; ?> | <?php echo $location; ?>
        </div>

        <div class="resume-section">
            <h2 class="section-title">Summary</h2>
            <div class="section-content">
                <?php echo $summary; ?>
            </div>
        </div>

        <div class="resume-section">
            <h2 class="section-title">Technical Skills</h2>
            <div class="section-content">
                <ul class="skills-list">
                    <?php foreach ($skills as $skill): ?>
                        <li><?php echo $skill; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="resume-section">
            <h2 class="section-title">Projects</h2>
            <div class="section-content">
                <?php foreach ($projects as $project): ?>
                    <div class="project-item">
                        <h3 class="project-title"><?php echo $project['title']; ?></h3>
                        <p class="project-type"><?php echo $project['type']; ?></p>
                        <ul class="project-details">
                            <?php foreach ($project['details'] as $detail): ?>
                                <li><?php echo $detail; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="resume-section">
            <h2 class="section-title">Organizations</h2>
            <div class="section-content">
                <ul class="organizations-list">
                    <?php foreach ($organizations as $org): ?>
                        <li><?php echo $org; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <script>
        function printResume() {
            window.print();
        }

        // Add smooth scrolling
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
</body>
</html>