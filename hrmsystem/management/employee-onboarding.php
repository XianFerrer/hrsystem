<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}

require_once '../includes/DBConnection.php';
$db = new DBConnection();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $status = $_POST['status'];

    $query = "INSERT INTO employees (name, email, position, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssss', $name, $email, $position, $status);
    $stmt->execute();
}

$query = "SELECT * FROM employees";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Onboarding</title>
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

        form input:focus, form select:focus {
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
        .dashboard-button {
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

        .dashboard-button:hover {
         background-color: #132483;
        }

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
         right: 210px;
         z-index: 1000;
    
        }
        .policies-button:hover {
    background-color: #132483;
}
    </style>
</head>
<body>
    <h1><insert>
    <div class="logo">
    <a href="dashboard.php">
        <img src="logo300.png" alt="Logo" width= "75" height="85">
    </a>
    </div>Employee Onboarding</h1>

    <div class="header-top-left">
    <a href="../dashboard.php" class="dashboard-button">Dashboard</a>
    </div>
    <div class="header-top-left">
        <a href="policies.html"class="policies-button">Policies</a>
    </div>

    <div class="container">
        <div class="form-container">
            <h2>Add New Employee</h2>
            <form action="employee-onboarding.php" method="POST">
                <input type="text" name="name" placeholder="Employee Name" required>
                <input type="email" name="email" placeholder="Employee Email" required>
                <input type="text" name="position" placeholder="Position" required>
                <select name="status" required>
                    <option value="onboard">Onboard</option>
                    <option value="failed">Fired</option>
                </select>
                <button type="submit">Add Employee</button>
            </form>
        </div>

        <h2>All Employees</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Position</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['position']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
    
    <?php //include '../includes/footer.php'; ?>
</body>
</html>
