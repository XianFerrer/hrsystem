<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}

require_once '../includes/DBConnection.php';
$db = new DBConnection();
$conn = $db->connect();

// Generating Reports logic would go here. You can pull data based on various filters.
$query = "SELECT * FROM employees"; // This can be customized to suit reporting needs.
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports and Analytics</title>
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
        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }
        .table-container h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
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
</div>Reports and Analytics</h1>

    <div class="header-top-left">
    <a href="../dashboard.php" class="dashboard-button">Dashboard</a>
    </div>
    <div class="header-top-left">
        <a href="policies.html"class="policies-button">Policies</a>
    </div>

    <div class="container">
        <div class="table-container">
            <h2>Employee Overview</h2>
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
    </div>

    <?php //include '../includes/footer.php'; ?>
</body>
</html>
