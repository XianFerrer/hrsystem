<?php
session_start();

// Redirect if not an admin
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}

require_once '../includes/DBConnection.php';
$db = new DBConnection();
$conn = $db->connect();

// Define valid statuses
$valid_statuses = ['passed', 'failed'];

// Handle status change via GET request
if (isset($_GET['status']) && isset($_GET['applicant_id'])) {
    $applicant_id = (int)$_GET['applicant_id']; // Cast applicant_id to integer
    $new_status = $_GET['status'];

    // Validate status
    if (in_array($new_status, $valid_statuses)) {
        // Prepare the SQL statement to update the applicant's status
        $query = "UPDATE applicants SET status = ? WHERE id = ? AND status = 'pending'";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        // Bind the parameters and execute
        $stmt->bind_param('si', $new_status, $applicant_id);
        
        if ($stmt->execute()) {
            // Status updated successfully
            if ($new_status == 'passed') {
                // Perform additional actions when the applicant passes
                
                // Example: Fetch the applicant's data
                $applicant_query = "SELECT email, name, position_applied FROM applicants WHERE id = ?";
                $applicant_stmt = $conn->prepare($applicant_query);
                $applicant_stmt->bind_param('i', $applicant_id);
                $applicant_stmt->execute();
                $applicant_result = $applicant_stmt->get_result();
                $applicant_data = $applicant_result->fetch_assoc();
        
                if ($applicant_data) {
                    $applicant_email = $applicant_data['email'];
                    $applicant_name = $applicant_data['name'];
                    $applicant_position = $applicant_data['position_applied'];
                    
                    // Create username from the applicant
                    $username = strtolower(str_replace(' ', '_', $applicant_name)); // e.g., john_doe
                    $raw_password = $applicant_name . '12345'; // The password is name + 12345
                    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT); // Hash the password
        
                    // Insert a new employee account into the employee table
                    $employee_query = "INSERT INTO employee (username, password, email, created_at) VALUES (?, ?, ?, NOW())";
                    $employee_stmt = $conn->prepare($employee_query);
                    if ($employee_stmt === false) {
                        die('Prepare failed: ' . $conn->error);
                    }
                    $employee_stmt->bind_param('sss', $username, $hashed_password, $applicant_email);
                    
                    if ($employee_stmt->execute()) {
                        // Insert data into the employees table
                        $employees_query = "INSERT INTO employees (name, email, position, status) VALUES (?, ?, ?, 'passed')";
                        $employees_stmt = $conn->prepare($employees_query);
                        if ($employees_stmt === false) {
                            die('Prepare failed: ' . $conn->error);
                        }
                        $employees_stmt->bind_param('sss', $applicant_name, $applicant_email, $applicant_position);
                        
                        if ($employees_stmt->execute()) {
                          
                           
                        } else {
                            echo "<script>alert('Error adding to employees table: " . $employees_stmt->error . "');</script>";
                        }
                    } else {
                        echo "<script>alert('Error creating employee account: " . $employee_stmt->error . "');</script>";
                    }
                }
            }
        } else {
            // Handle error if update fails
            echo "<script>alert('Error updating status: " . $stmt->error . "');</script>";
        }
    } else {
        // Invalid status provided
        echo "<script>alert('Invalid status provided!');</script>";
    }
}

// Query to select all applicants with pending status
$query = "SELECT * FROM applicants WHERE status = 'pending'";
$result = $conn->query($query);
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Applicant Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
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
        h2{
            text-align: center;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .form-container h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
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
            text-align: center;
        }

        table th {
            background-color: #007bff;
            color: white;
            text-align: center;
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
        Applicant Management
    </h1>

    <div class="header-top-left">
        <a href="../dashboard.php" class="dashboard-button">Dashboard</a>
    </div>
    <div class="header-top-left">
        <a href="policies.html" class="policies-button">Policies</a>
    </div>

    <div class="container">
       

        <h2>All Applicants</h2>
        <table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Position</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td><?php echo htmlspecialchars($row['position_applied']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td>
                <!-- Passed Button -->
                <a href="applicant-management.php?status=passed&applicant_id=<?php echo $row['id']; ?>" class="btn btn-success" style="margin-right: 5px;">
                    ✔ Passed
                </a>
                <!-- Failed Button -->
                <a href="applicant-management.php?status=failed&applicant_id=<?php echo $row['id']; ?>" class="btn btn-danger">
                    ✘ Failed
                </a>
    
            </td>
        </tr>
    <?php endwhile; ?>
</table>



    </div>

    <?php //include '../includes/footer.php'; ?>
</body>
