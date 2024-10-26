<?php

if (!isset($_SESSION['./sidebar/sidebar_admin.php'])){
session_start();
session_destroy();
header("Location: login.php");
exit();
}
?>

