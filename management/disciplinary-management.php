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
  

    $employee_id = $_POST['employee_id'];
    $sanction = $_POST['sanction']; // This should match your form input name

    // Insert into the database
    $query = "INSERT INTO disciplinary_actions (employee_id, action_text) VALUES (?, ?)";
    $stmt = $conn->prepare($query);

    // Correctly bind parameters: 'i' for integer (employee_id) and 's' for string (sanction)
    $stmt->bind_param('is', $employee_id, $sanction);

    // Execute and check for success
    if ($stmt->execute()) {
        echo "<script>alert('Disciplinary action added successfully.');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>"; // Display the error
    }
    
}


// Fetch existing disciplinary actions
$query = "SELECT * FROM disciplinary_actions";
$result = $conn->query($query);

// Fetch employees
$query2 = "SELECT id, name FROM employees";
$employees = $conn->query($query2);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Performance Management</title>
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
            padding: 20px; /* Added padding for better spacing */
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
            display: flex; /* Use flexbox for layout */
            flex-direction: column; /* Arrange items in a column */
        }

        form select, form textarea, form input[type="number"], button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            box-sizing: border-box; /* Include padding in width */
        }

        form select:focus, form textarea:focus, form input[type="number"]:focus {
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
    <h1>
        <div class="logo">
            <a href="dashboard.php">
                <img src="logo300.png" alt="Logo" width="75" height="85">
            </a>
        </div>
        Disciplinary Management
    </h1>
    <div class="header-top-left">
        <a href="../dashboard.php" class="dashboard-button">Dashboard</a>
    </div>
    <div class="header-top-left">
        <a href="policies.html" class="policies-button">Policies</a>
    </div>

    <div class="container">
        <form action="disciplinary-management.php" method="POST">
            <select name="employee_id" required>
                <?php while ($row = $employees->fetch_assoc()) : ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                <?php endwhile; ?>
            </select>
            <select name="sanction" required>
                <option value="">Select Sanction</option>
                <option value="Written Warning">Written Warning</option>
                <option value="Final Warning">Final Warning</option>
                <option value="Suspension">Suspension</option>
                <option value="Dismissal">Dismissal</option>
            </select>
            <button type="submit">Add Disciplinary Action</button>
        </form>

        <h2>Disciplinary Action</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Employee ID</th>
                <th>Sanction</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['employee_id']; ?></td>
                    <td><?php echo $row['action_text']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <?php //include '../includes/footer.php'; ?>
</body>
</html>
