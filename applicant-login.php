<?php
require_once 'includes/DBConnection.php';

session_start(); // Start the session to store user information

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $db = new DBConnection();
    $conn = $db->connect();

    // Sanitize inputs
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];

    // Check if the form fields are empty
    if (empty($username) || empty($password)) {
        $error_message = "All fields are required.";
    } else {
        // Prepare and execute SQL query to fetch user based on username
        $stmt = $conn->prepare("SELECT id, username, password, email FROM applicant WHERE username = ?"); // Include email in the SELECT statement
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $fetched_username, $hashed_password, $fetched_email); // Include email in bind_result
            $stmt->fetch();

            // Verify the password with the hashed one in the database
            if (password_verify($password, $hashed_password)) {
                // Login successful, store user information in session
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $fetched_username;
                $_SESSION['email'] = $fetched_email; // Store email in session
                header("Location: applicant-dashboard.php"); // Redirect to dashboard
                exit();
            } else {
                $error_message = "Incorrect password.";
            }
        } else {
            $error_message = "Username not found.";
        }

        $stmt->close();
    }

    $conn->close();
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
        <h1>
            <div class="logo">
                <a href="dashboard.php">
                    <img src="logo300.png" alt="Logo" width="75" height="85">
                </a>
            </div>Applicant Login
        </h1>
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
