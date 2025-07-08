<?php
// team-details.php

// Check if the user is not logged in and redirect to login page
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
// Database connection
require_once "db.php";

$team_name = $_GET['name'];
// Fetch team data from the database
$statement = $pdo->prepare("SELECT * FROM team WHERE name = ?");
$statement->execute([$team_name]);
$team = $statement->fetch();
// Check if the team exists
if (!$team) {
    header("Location: dashboard.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addPlayer']) ) {
    $player_name = $_POST['player_name'];
    $statment2 = $pdo->prepare("INSERT INTO player(player_name,team_name) VALUES (?,?)");
    $statment2->execute([$player_name,$team_name]);
}
// Fetch players data for the team from the database
$stmt = $pdo->prepare("SELECT * FROM player WHERE team_name = ?");
$stmt->execute([$team_name]);
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);

$count=0;
foreach ($players as $player) {
    if ($team_name == $player['team_name']) {
        $count++;
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Team Details</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h2><?php echo $team_name ?></h2>
        </header>
        <main>
            <table>
            <tr>
                <td>Team Name:</td>
                <td><?php echo $team['name']; ?></td>
            </tr>
            <tr>
                <td>Skill:</td>
                <td><?php echo $team['skill_team']; ?></td>
            </tr>
            <tr>
                <td>Game Day:</td>
                <td><?php echo $team['game_day']; ?></td>
            </tr>
            <tr>
                <td>Players:</td>
                <td><?php 
                $statment=$pdo->query("SELECT * FROM player");
                $players=$statment->fetchAll(PDO::FETCH_ASSOC);
                foreach ($players as $player) {
                    if ($team_name==$player['team_name']) {
                         echo $player['player_name'];
                         echo "<br>";
                    }
                } ?></td>
            </tr>
        </table>
        <?php if ($count ==9):?>
            <p id=fullteam>
                The team is full, you can't add more
            </p>
            <?php elseif($count <9): ?>
                <br><br>
            <form action="team-details.php?name=<?php echo $team['name']; ?>" method="post">
            <p>
                <Label>Add Player:</Label>
                <input type="text" name="player_name" placeholder="Player Name" required>
                <button type="submit" name="addPlayer">Add</button>
            </p>  
        </form>
            <?php endif; ?>
        <p>
            <a href="edit-team.php?name=<?php echo $team['name']; ?>">Edit</a>
            </p>
            <p>
            <a href="edit-team.php">Delete</a>
            </p>
        <br>
        </main>
        <footer>
            <a href="dashboard.php">Back to Dashboard</a>
            <br>
            <a href="logout.php">Logout</a>
        </footer>
    </div>
</body>
</html>