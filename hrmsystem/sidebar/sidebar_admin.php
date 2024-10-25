<?php

require_once 'includes/DBConnection.php';

// Assuming the admin is logged in and their username is stored in the session
if (isset($_SESSION['admin'])) {
    $db = new DBConnection();
    $conn = $db->connect();

    // Get the admin's details from the database
    $admin_username = $_SESSION['admin'];
    $query = "SELECT username, email, created_at FROM admins WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $admin_username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin_data = $result->fetch_assoc();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Sidebar</title>
    <style>
        #sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #f8f9fa;
            transition: transform 0.3s ease;
        }

        #sidebar.collapsed {
            transform: translateX(-100%);
        }

        #page-content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        #page-content.collapsed {
            margin-left: 0;
        }

        .profile-info {
            text-align: center;
            padding: 20px;
        }

        .profile-info img {
            border-radius: 50%;
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
        }

        .nav-link {
            display: block;
            padding: 10px;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
    <script src="./js/jquery/jquery.min.js"></script>
</head>
<body>
    <!-- Sidebar -->
    <div id="sidebar" class="bg-light text-center shadow">
        <div class="p-3">
            <img src="./sidebar/bcp_logo.png" alt="Logo" width="75" height="85">
            <h4 class="mb-4">Admin Dashboard</h4>

            <div class="profile-info">
               
                <img src="./sidebar/default-profile.jfif" alt="Profile Picture" width="75" height="85">
                <p><?php echo htmlspecialchars($admin_data['email']); ?></p>
            </div>

            <a class="nav-link border border-dark rounded text-danger" href="logout.php" id="logout">Logout</a>
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content">
        <nav>
            <button class="btn shadow" type="button" id="toggle-sidebar">
                ☰ Menu
            </button>
        </nav>

        <!-- Page content goes here -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var sidebar = document.getElementById('sidebar');
            var content = document.getElementById('page-content');
            var toggleButton = document.getElementById('toggle-sidebar');

            toggleButton.addEventListener('click', function () {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('collapsed');
            });
        });
    </script>
</body>
</html>
