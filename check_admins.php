<?php
// Database connection details
$servername = "localhost"; // or "127.0.0.1"
$username = "root"; // Change this if you have a different MySQL username
$password = "root"; // Your MySQL password (if any)
$dbname = "hrm_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3306); // Ensure the port is correct

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to select all data from the admins table
$sql = "SELECT * FROM admins";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Username: " . $row["username"]. " - password: " . $row["password"]. "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>
