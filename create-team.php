<?php
// create-team.php

// Check if the user is not logged in and redirect to login page
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Database connection
require_once "db.php";

// when click on the create team submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $skill_team = $_POST['skill_team'];
    $game_day = $_POST['game_day'];
    $email=$_SESSION['email'];
    $statement = $pdo->prepare("SELECT * FROM team WHERE name = ?");
    $statement->execute([$name]);
    $team = $statement->fetch();
    if(!$team){
            // Insert the new team into tabel team in database
       $stmt = $pdo->prepare("INSERT INTO team (name, skill_team, game_day, email) VALUES (?, ?, ?, ?)");
       $stmt->execute([$name, $skill_team, $game_day, $email]);

       //Redirect to the dashboard page after successful team creation
       header("Location: dashboard.php");
       exit();
    }else {
        $error="Team Name is Invalid, Try again!";
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New Team</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <div class="container">
        <header>
            <h2>Create New Team</h2>
        </header>
        <main>
            <form action="create-team.php" method="POST">
                <fieldset>
                    <input type="text" name="name" placeholder="Team Name" required>
                    <input type="number" name="skill_team" placeholder="Skill (1-5)" min="1" max="5" required>
                    <input type="text" name="game_day" placeholder="Game Day"  required>
                    <button type="submit">Create Team</button>
                </fieldset>
            </form>
            <p id=fonttype>
                <strong class="error" ><?php echo isset($error) ? $error : ""; ?></strong>
            </p>
        <br>
        <a href="dashboard.php">Back to Dashboard</a>
        <br>
    </main>
    <footer>
        <a href="logout.php">Logout</a>
    </footer>
    </div>
</body>
</html>
