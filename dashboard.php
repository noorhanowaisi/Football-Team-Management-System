<?php
// dashboard.php

// Check if the user isn't logged in and redirect to login page
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Database connection
require_once "db.php";

// get teams data from the database
$statement = $pdo->query("SELECT * FROM team");
$teams = $statement->fetchAll(PDO::FETCH_ASSOC);
$statment2=$pdo->query("SELECT * FROM player");
$players=$statment2->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Football Dashboard</title>
    <link rel="stylesheet" type="text/css" href="dashboard.css">
</head>
<body>
        <header>
            <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
        </header>
        <main>
            <table border=1>
            <thead>
                <tr>
                    <th>Team Name</th>
                    <th>Skill</th>
                    <th>Number of Players</th>
                    <th>Game Day</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($teams as $team) { ?>
                    <tr>
                        <td><a href="team-details.php?name=<?php echo $team['name']; ?>"><em><?php echo $team['name']; ?></em></a></td>
                        <td><?php echo $team['skill_team']; ?></td>
                        <td><?php $count=0;
                            $team_name=$team['name'];
                            foreach ($players as $player) {
                                if ($team_name == $player['team_name']) {
                                    $count++;
                                }
                        }echo $count."/9";?></td>
                        <td><?php echo $team['game_day']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            </table>
        </main>
        <footer>
            <a href="create-team.php">Create New Team</a>
            <br>
            <a href="logout.php">Logout</a>
        </footer>
</body>
</html>
