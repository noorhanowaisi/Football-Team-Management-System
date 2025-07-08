<?php
// Check if the user is already logged in and redirect to dashboard page
session_start();
if (isset($_SESSION['email'])) {
    header("Location: dashboard.php");
    exit();
}
// Database connection
require_once "db.php";

//when click submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email is already registered
    $statement = $pdo->prepare("SELECT * FROM user WHERE email = ?");
    $statement->execute([$email]);
    $result = $statement->fetch();

    if ($result) {
        if($password ==$result['password']){
            session_start();
             $_SESSION["username"] = $result["username"];
             $_SESSION["email"] = $result["email"];
            
            
        header("Location: dashboard.php");
        }else{
            $error = "The password is not correct";
        }
        
    } else {
        $error ="The email is not valid";

    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet"  href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h2 id=fonttype>Login</h2>
        </header>
        <main>
            <form action="login.php" method="POST">
            <fieldset>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </fieldset>
            </form>
        </main>
        <footer>
            <p id=fonttype>
                <strong class="error" ><?php echo isset($error) ? $error : ""; ?></strong>
            </p>
            <p id=fonttype>Don't have an account? <a href="register.php">Register</a></p>
        </footer>
        
    </div>
</body>
</html>


