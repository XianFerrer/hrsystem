if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Policies</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        
        .header {
            background-color: #007bff;
            padding: 20px;
            image-orientation: none;
            text-align: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .sidebar {
            width: 0; /* Remove sidebar width */
            background-color: transparent; /* Remove gray background */
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            box-shadow: none;
        }

        .content {
            margin: 80px 20px 20px 20px; /* Adjust margin for header and padding */
            padding: 20px;
        }

        .dashboard-header {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            text-align: center; /* Center-align header */
        }

        .dashboard-items {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center; /* Center-align items */
        }

        .dashboard-item {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex: 1 1 calc(30% - 20px);
            max-width: calc(30% - 20px);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .dashboard-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .dashboard-item h3 {
            margin-bottom: 10px;
            font-size: 1.5rem;
            color: #007bff;
        }

        .dashboard-item a {
            text-decoration: none;
            color: #007bff;
            font-size: 1.1rem;
        }

        .dashboard-item a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    
</body>
</html>