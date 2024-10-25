<?php
session_start();

// Use absolute paths for including header and footer
//include 'C:/xampp/htdocs/hrmsystem/includes/header.php';

if (!isset($_SESSION['employee'])) {
    header('Location: employee-login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './sidebar/head.php' ?>
    <?php include './sidebar/sidebar_user.php' ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 1rem;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .dashboard-container h1 {
            margin-top: 0;
            color: #333;
        }
        .dashboard-menu {
            display: flex;
            flex-direction: column;
            margin-bottom: 2rem;
        }
        .dashboard-menu a {
            text-decoration: none;
            padding: 1rem;
            margin-bottom: 0.5rem;
            background-color: #007bff;
            color: #fff;
            border-radius: 4px;
            text-align: center;
        }
        .dashboard-menu a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['employee']); ?>!</h1>
        <div class="dashboard-menu">
            <a href="profile.php">Profile</a>
            <a href="announcement.php">Announcement</a>
            <a href="home-hr-policies.php">Home - HR Policies</a>
            <a href="trainings.php">Trainings</a>
            <a href="leave-request.php">Leave Request</a>
            <a href="job-opening.php">Job Opening</a>
        </div>
    </div>

     <!-- Include the footer with absolute path -->
     <?php //include '../includes/footer.php'; ?>
</body>
</html>
