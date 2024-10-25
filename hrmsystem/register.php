<?php
require_once 'includes/DBConnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $db = new DBConnection();
    $conn = $db->connect();

    // Sanitize inputs to prevent XSS attacks
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form inputs
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        // Check for password strength: at least 8 characters, contains letters and numbers
        $error_message = "Password must be at least 8 characters long and include both letters and numbers.";
    } else {
        // Hash the password securely
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists in the database
        $email_check_query = $conn->prepare("SELECT id FROM applicant WHERE email = ?");
        $email_check_query->bind_param("s", $email);
        $email_check_query->execute();
        $email_check_query->store_result();

        if ($email_check_query->num_rows > 0) {
            $error_message = "Email is already registered.";
        } else {
            // Prepare and bind to insert new user
            $stmt = $conn->prepare("INSERT INTO applicant (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            // Execute the statement
            if ($stmt->execute()) {
                // Registration successful
                header("Location: applicant-login.php"); // Redirect to a dashboard or login page
                exit();
            } else {
                $error_message = "Error: " . $stmt->error;
            }

            $stmt->close();
        }

        $email_check_query->close();
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Registration Form</title>
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
        .registration-container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
            
        }
        .registration-container h1 {
            margin-bottom: 1rem;
            color: #333;
        }
        .registration-container form {
            display: flex;
            flex-direction: column;
        }
        .registration-container label {
            margin-bottom: 0.5rem;
            text-align: left;
        }
        .registration-container input[type="text"],
        .registration-container input[type="password"] {
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }
        .registration-container input[type="submit"] {
            padding: 0.75rem;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-size: 1rem;
        }
        .registration-container input[type="submit"]:hover {
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
        .logo img {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <div class="logo">
            <a href="dashboard.php">
                <img src="logo300.png" alt="Logo" width="75" height="85">
            </a>
        </div>
        <h1>Applicant Registration</h1>
        <?php if (isset($error_message)) echo '<p class="error-message">' . htmlspecialchars($error_message) . '</p>'; ?>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <input type="submit" value="Register">
        </form>
        <div class="links">
            <a href="applicant-login.php">Already have an account? Log in</a>
        </div>
    </div>
</body>
</html>
