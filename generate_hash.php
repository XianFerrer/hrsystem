<?php
$password = 'admin123'; // The plain text password
$hashed_password = password_hash($password, PASSWORD_DEFAULT); // Generate the hash

echo "Plain Password: " . $password . "<br>";
echo "Hashed Password: " . $hashed_password;
?>