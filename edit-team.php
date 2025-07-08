<?php
// edit-team.php

// Check if the user is not logged in and redirect to login page
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Database connection
require_once "db.php";

$name = $_GET['name'];

// Fetch team data from the database
$stmt = $pdo->prepare("SELECT * FROM team WHERE name = ?");
$stmt->execute([$name]);
$team = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the team exists
if (!$team) {
    header("Location: dashboard.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

// Process the update team form submission
if (isset($_POST['update'])) {
    $newname = $_POST['name'];
    $skill = $_POST['skill'];
    $gameDay = $_POST['game_day'];
    $statement = $pdo->prepare("SELECT * FROM team WHERE name = ? ");
    $statement->execute([$newname]);
    $team = $statement->fetch();
    if(!$team ||  $newname==$name){
    // Update the team information in the database
    $stmt = $pdo->prepare("UPDATE team SET name = ?, skill_team = ?, game_day = ? WHERE name = ?");
    $stmt->execute([$newname, $skill, $gameDay, $name]);

    // Redirect to the team details page after successful update
    header("Location: team-details.php?name=" . $newname);
    exit();
    }
    else {
        $error="Team Name is Invalid, Try again!";
    }
}
// Process the delete team form submission
else if (isset($_POST['delete'])) {
    $statement = $pdo->prepare("SELECT * FROM team WHERE name = ? ");
    $statement->execute([$name]);
    $team = $statement->fetch();
    if($team){
    // Delete the team from the database
    $stmt = $pdo->prepare("DELETE FROM team WHERE name = ?");
    $stmt->execute([$name]);

    // Redirect to the team details page after successful update
    header("Location: dashboard.php");
    exit();
    }
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Football Team Management - Edit Team</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <header>
           <h2>Edit Team</h2> 
        </header>
        <main>
            <form action="edit-team.php?name=<?php echo $name; ?>" method="POST">
                <input type="text" name="name" placeholder="Team Name" value="<?php echo $team['name']; ?>" required>
                <input type="number" name="skill" placeholder="Skill (1-5)" min="1" max="5" value="<?php echo $team['skill_team']; ?>" required>
                <input type="text" name="game_day" placeholder="Game Day" value="<?php echo $team['game_day']; ?>" required>
                <button type="submit" name="update">Update Team</button>
          </form>
          <form action="edit-team.php?name=<?php echo $name; ?>" method="POST">
          <button type="submit" name="delete">Delete</button>
          </form>
            <p id=fonttype>
                <strong class="error" ><?php echo isset($error) ? $error : ""; ?></strong>
            </p>
            <br>
        </main>
        <footer>
            <a href="team-details.php?name=<?php echo $name; ?>">Back to Team Details</a>
            <br>
            <a href="dashboard.php">Back to Dashboard</a>
            <br>
            <a href="logout.php">Logout</a>
        </footer>
    </div>
</body>
</html>
