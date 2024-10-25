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
    $review_text = $_POST['review_text'];
    $score = $_POST['score'];

    $query = "INSERT INTO performance_reviews (employee_id, review_text, score) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isi', $employee_id, $review_text, $score);
    $stmt->execute();
}

$query = "SELECT * FROM performance_reviews";
$result = $conn->query($query);

$query2 = "SELECT id, name FROM employees";
$employees = $conn->query($query2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Performance Management</title>
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

        form select, form textarea, form input[type="number"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
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
    </div>Performance Management</h1>

    <div class="header-top-left">
    <a href="../dashboard.php" class="dashboard-button">Dashboard</a>
    </div>
    <div class="header-top-left">
        <a href="policies.html"class="policies-button">Policies</a>
    </div>

    <div class="container">
        <div class="form-container">
            <h2>Add New Review</h2>
            <form action="performance-management.php" method="POST">
                <select name="employee_id" required>
                    <?php while ($row = $employees->fetch_assoc()) : ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php endwhile; ?>
                </select>
                <textarea name="review_text" placeholder="Review" required></textarea>
                <input type="number" name="score" min="1" max="10" placeholder="Score (1-10)" required>
                <button type="submit">Add Review</button>
            </form>
        </div>

        <h2>All Reviews</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Employee ID</th>
                <th>Review</th>
                <th>Score</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['employee_id']; ?></td>
                    <td><?php echo $row['review_text']; ?></td>
                    <td><?php echo $row['score']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <?php //include '../includes/footer.php'; ?>
</body>
</html>
