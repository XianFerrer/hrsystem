    <?php
    session_start();
    if (!isset($_SESSION['employee'])) {
        header('Location: employee-login.php');
        exit();
    }

    require_once 'includes/DBConnection.php';
    $db = new DBConnection();
    $conn = $db->connect();

    $username = $_SESSION['employee'];
    $query = "SELECT * FROM employees WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Profile</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f0f2f5;
                margin: 0;
                padding: 20px;
            }
            .profile-container {
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                max-width: 600px;
                margin: auto;
            }
            h1 {
                margin-top: 0;
            }
            .profile-info {
                margin-bottom: 20px;
            }
            .profile-info label {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="profile-container">
            <h1>Profile</h1>
            <div class="profile-info">
                <label>Username:</label>
                <p><?php echo htmlspecialchars($employee['username']); ?></p>
            </div>
            <div class="profile-info">
                <label>Name:</label>
                <p><?php echo htmlspecialchars($employee['name']); ?></p>
            </div>
            <div class="profile-info">
                <label>Email:</label>
                <p><?php echo htmlspecialchars($employee['email']); ?></p>
            </div>
            <div class="profile-info">
                <label>Position:</label>
                <p><?php echo htmlspecialchars($employee['position']); ?></p>
            </div>
            <a href="employee-dashboard.php">Back to Dashboard</a>
        </div>
    </body>
    </html>
