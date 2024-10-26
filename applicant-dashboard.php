<?php
session_start();
require_once 'includes/DBConnection.php'; // Include your DB connection

if (!isset($_SESSION['email'])) {
    header('Location: applicant-login.php');
    exit();
}

// Database connection
$db = new DBConnection();
$conn = $db->connect();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_applicant'])) {
    // Collect data from the form
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $position = $conn->real_escape_string($_POST['position']);
    $status = 'pending';

    // Validate form data
    if (empty($name) || empty($email) || empty($phone) || empty($position)) {
        echo "<div class='message'>Error: All fields are required.</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='message'>Error: Invalid email format.</div>";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo "<div class='message'>Error: Invalid phone number format. Use 10 digits.</div>";
    } else {
        // Prepare the SQL statement
        $sql = "INSERT INTO applicants (name, email, phone, position_applied, status) 
                VALUES (?, ?, ?, ?, ?)";

        // Use a prepared statement to prevent SQL injection
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("sssss", $name, $email, $phone, $position, $status);

        try {
            // Execute the statement
            $stmt->execute();
            echo "Application submitted successfully";
        } catch (mysqli_sql_exception $e) {
            // Check for duplicate entry error
            if ($e->getCode() == 1062) { // Duplicate entry error code
                echo "<script>alert('Error: You have already applied for this position with this email')</script>";
            } else {
                echo "<script>alert('Error: " . htmlspecialchars($e->getMessage()) . "');</script>";

            }
        }

        // Close the statement
        $stmt->close();
    }
}


// Fetch applicant applications
$applicant_email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT * FROM applicants WHERE email = ?");
$stmt->bind_param("s", $applicant_email);
$stmt->execute();
$result = $stmt->get_result();

// Fetch job titles from recruitment table
$stmt_job_titles = $conn->prepare("SELECT job_title FROM recruitments WHERE status = 'open'");
$stmt_job_titles->execute();
$job_titles_result = $stmt_job_titles->get_result();

// Fetch job postings from recruitment table
$stmt_jobs = $conn->prepare("SELECT id, job_title, description, posted_date, status FROM recruitments WHERE status = 'open' ORDER BY posted_date DESC");
$stmt_jobs->execute();
$job_result = $stmt_jobs->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Applicant Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        h1 {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            margin: 0;
            text-align: center;
        }

        .container {
            display: flex;
            justify-content: space-between;
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
        }

        .form-container, .job-postings-container {
            width: 48%; /* Set the width of each section */
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .job-postings-container {
    width: 48%; /* Set the width of each section */
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 40px;
    max-height: 400px; /* Set the maximum height */
    overflow-y: auto; /* Enable vertical scrolling */
}


        form {
            display: flex;
            flex-direction: column;
        }

        form input, form select, form button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
        }

        form input:focus, form select:focus, form textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 1rem;
            color: #333;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .dashboard-button,
        .policies-button {
            display: flex;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border-radius: 5%;
            font-weight: normal;
            transition: background-color 0.3s;
            position: absolute;
            top: 40px;
            right: 100px;
            z-index: 1000;
        }

        .policies-button {
            right: 210px; /* Adjust positioning */
        }

        .dashboard-button:hover,
        .policies-button:hover {
            background-color: #132483;
        }

        .message {
            margin: 20px 0;
            color: #e74c3c; /* Error color */
            text-align: center;
        }
        
    </style>
</head>
<body>
    <h1>
        <div class="logo">
            <a href="dashboard.php">
                <img src="logo300.png" alt="Logo" width="75" height="85">
            </a>
        </div>
        Applicant Dashboard
    </h1>

    <div class="header-top-left">
        <a href="logout.php" class="dashboard-button">Logout</a>
    </div>
    <div class="header-top-left">
        <a href="policies.html" class="policies-button">Policies</a>
    </div>

    <div class="container">
        <!-- Form Section -->
        <div class="form-container">
            <h2>Apply for a Job</h2>
            <form action="applicant-dashboard.php" method="POST">
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone" placeholder="Phone" required>

                <select name="position" required>
                    <option value="">Select Position</option>
                    <?php while ($job_title = $job_titles_result->fetch_assoc()) : ?>
                        <option value="<?php echo htmlspecialchars($job_title['job_title']); ?>">
                            <?php echo htmlspecialchars($job_title['job_title']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <button type="submit" name="add_applicant">Apply</button>
            </form>
        </div>

        <!-- Job Postings Section -->
        <div class="job-postings-container">
            <h2>Job Postings</h2>
            <ul>
                <?php while ($job = $job_result->fetch_assoc()) : ?>
                    <li>
                        <strong><?php echo htmlspecialchars($job['job_title']); ?></strong> <br>
                        <?php echo htmlspecialchars($job['description']); ?> <br>
                        <em style="font-size: 0.9rem;">Posted Date: <?php echo htmlspecialchars($job['posted_date']); ?></em>
                    </li>
                    <hr>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

    <center><h2>My Applications</h2></center>
    <div class="container">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Position</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['position_applied']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <?php //include '../includes/footer.php'; ?>
</body>
</html>
