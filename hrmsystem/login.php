<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once 'includes/DBConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Plain text password from user input

    $db = new DBConnection();
    $conn = $db->connect();

    // Prepare the SQL statement to select the admin user by username
    $query = "SELECT * FROM admins WHERE username = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Check if user was found
    if (!$admin) {
        $error_message = "Invalid login credentials."; // User not found
    } else {
        $stored_password = $admin['password']; // Get the plain text password from the database

        if ($password === $stored_password) { // Compare plain text passwords
            // Correct password
            session_regenerate_id(); // Prevent session fixation attacks
            $_SESSION['admin'] = $admin['username'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .login-container h1 {
            margin-bottom: 1rem;
            color: #333;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
        }
        .login-container label {
            margin-bottom: 0.5rem;
            text-align: left;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .login-container input[type="submit"] {
            padding: 0.75rem;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-size: 1rem;
        }
        .login-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: #e74c3c;
            margin-bottom: 1rem;
        }
        .links {
            margin-top: 1rem;
        }
        .links a {
            color: #007bff;
            text-decoration: none;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1><insert>
    <div class="logo">
    <a href="dashboard.php">
        <img src="logo300.png" alt="Logo" width= "75" height="85">
    </a>
</div>Admin Login</h1>
        <?php if (isset($error_message)) echo '<p class="error-message">' . htmlspecialchars($error_message) . '</p>'; ?>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Login">
        </form>
        <div class="links">
            <p>Not an admin? <a href="employee-login.php">Login as Employee</a></p>
        </div>
    </div>
</body>
</html>
