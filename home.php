<?php
// home.php

// Check if the user is not logged in and redirect to login page
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Football Team Management</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome to the Football Team Management Application</h2>
        <p>Logged in as: <?php echo $_SESSION['email']; ?></p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
