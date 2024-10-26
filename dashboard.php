<?php
session_start();

// Use absolute paths for including header and footer
//include 'C:/xampp/htdocs/hrmsystem/includes/header.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './sidebar/head.php' ?>
    <?php include './sidebar/sidebar_admin.php' ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        
        .header {
            background-color: #007bff;
            padding: 20px;
            image-orientation: none;
            text-align: center;
            color: black;
            font-size: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 150;
            width: 100%;
            z-index: 1000;
        }

        .content {
            margin: 80px 20px 20px 20px; /* Adjust margin for header and padding */
            padding: 20px;
        }

        .dashboard-header {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            text-align: center; /* Center-align header */
        }

        .dashboard-items {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center; /* Center-align items */
        }

        .dashboard-item {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex: 1 1 calc(30% - 20px);
            max-width: calc(30% - 20px);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .dashboard-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .dashboard-item h3 {
            margin-bottom: 10px;
            font-size: 1.5rem;
            color: #007bff;
        }

        .dashboard-item a {
            text-decoration: none;
            color: #007bff;
            font-size: 1.1rem;
        }

        .dashboard-item a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
    <h1><insert><img src="logo300.png" alt="Logo" width= "75" height="85"></insert>
         Human Resources Department</h1>
    </div>
    <div class="header-top-left">
        <a href="policies.html"class="policies-button">Policies</a>
    </div>
    <div class="content">
        <h1 class="dashboard-header">Admin Dashboard</h1>
        
        <div class="dashboard-items">
        <div class="dashboard-item">
    <h3>Applicant Management</h3>
    <a href="/hrmsystem/management/applicant-management.php">Manage Applicants</a>
</div>

<div class="dashboard-item">
    <h3>Recruitment Management</h3>
    <a href="/hrmsystem/management/recruitment-management.php">Manage Recruitment</a>
</div>

<div class="dashboard-item">
    <h3>Employee Onboarding</h3>
    <a href="/hrmsystem/management/employee-onboarding.php">Onboard Employees</a>
</div>

<div class="dashboard-item">
    <h3>Performance Management</h3>
    <a href="/hrmsystem/management/performance-management.php">Manage Performance and Attendance</a>
</div>

<div class="dashboard-item">
    <h3>Disciplinary Management</h3>
    <a href="/hrmsystem/management/disciplinary-management.php">Manage Disciplinary Actions</a>
</div>

<!-- <div class="dashboard-item"> 
    <h3>Time and Attendance</h3>
    <a href="/hrmsystem/management/time-attendance.php">Manage Time & Attendance</a>
</div>-->

<div class="dashboard-item">
    <h3>Leave Management</h3>
    <a href="/hrmsystem/management/leave-management.php">Manage Leave Requests</a>
</div>

<!-- <div class="dashboard-item"> 
    <h3>Reports & Analytics</h3>
    <a href="/hrmsystem/management/reports-analytics.php">View Reports & Analytics</a>
</div> -->

<div class="dashboard-item">
    <h3>Staff Management</h3>
    <a href="/hrmsystem/management/staff-management.php">Manage Staff Request</a>
</div>

        </div>
    </div>

    <!-- Include the footer with absolute path -->
    <?php //include 'C:/xampp/htdocs/hrmsystem/includes/footer.php'; ?>

</body>
</html>
