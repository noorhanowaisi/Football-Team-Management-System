<?php
// register.php (Registration Logic)

// Check if the user is already logged in and redirect to dashboard page
session_start();
if (isset($_SESSION['email'])) {
    header("Location: dashboard.php");
    exit();
}

// Database connection
require_once "db.php";

// Process the registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Perform form validation
    $errors = [];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "All fields are required.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check if the username or email already exists in the database
    $statement = $pdo->prepare("SELECT * FROM user WHERE email = ?");
        $statement->execute([$email]);
        $result = $statement->fetch();


    if ($result) {
        $errors[] = "Email already exists.";
    }

    if (empty($errors)) {
        // Insert the new user into the database
        $stmt = $pdo->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        
        // Redirect to the login page after successful registration
        header("Location: succefulRegister.html");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Football Team Management - Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h2>Register</h2>
        </header>
        <main>
            <form action="register.php" method="POST">
            <fieldset>
                 <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit">Register</button>
            </fieldset>
            </form>
            <?php if (!empty($errors)) { ?>
            <div class="error">
                <?php foreach ($errors as $error) { ?>
                    <p><?php echo $error; ?></p>
                <?php } ?>
            </div>
           <?php } ?>
         </main>
         <footer>
            <p>Already have an account? <a href="login.php">Login</a></p>
         </footer>
    </div>
</body>
</html>

