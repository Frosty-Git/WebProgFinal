<?php
session_start();

require_once('./scripts/dbGetters.php');
require_once('./scripts/decoder.php');

$top_players = getTopPlayerInfo();

?>

<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>
<head>
    <title>Tic-Tac-Toe | Top Players</title>
    <meta charset='utf-8' />
    <meta name='Author' content='Joseph Frost, Katie Lee, Marc Colin, Jacelynn Duranceau' />
    <meta name='generator' content='VS Code' />
    <link rel='shortcut icon' href='#' />
    <link rel="stylesheet" href="./css/base.css">
</head>

<body>

<?php
    echo  '<h1 class="centerText">Top <span style="color: #FC4A1A">Tic</span><span style="color: #4ABDAC">-</span><span style="color: #FC4A1A">Tac</span><span style="color: #4ABDAC">-</span><span style="color: #FC4A1A">Toe</span> Players:</h1>';
    echo  "<table class='center goTable'>";
    echo  "<tr>";
        echo  "<th>Rank</th>";
        echo  "<th>Username</th>";
        echo  "<th>Wins</th>";
        echo  "<th>Losses</th>";
        echo  "<th>Ties</th>";
        echo  "<th>W/L Ratio</th>";
    echo "</tr>";
    for ($i = 0; $i < count($top_players); $i++){
        $player = decodeSelectResults($top_players, $i); //from decoder.php
        // echo "<tr><td>"; echo $player; echo "</td></tr>";
        $username = $player['username'];
        $wins = $player['wins'];
        $losses = $player['losses'];
        $ties = $player['ties'];
        echo  "<tr>"; 
            echo  "<td class='tableTd'>";
                $rank = $i;
                echo $rank + 1;
            echo "</td>";
            echo  "<td class='tableTd'>";
                echo $username;
            echo "</td>";
            echo  "<td class='tableTd'>";
                echo $wins;
            echo "</td>";
            echo  "<td class='tableTd'>";
                echo $losses;
            echo "</td>";
            echo  "<td class='tableTd'>";
                echo $ties;
            echo "</td>";
            echo  "<td class='tableTd'>";
                if($losses != 0) {
                    echo round($wins/$losses, 2);
                }
                else {
                    echo $wins;
                }
            echo "</td>";
        echo "</tr>";
    }
    echo "</table><br>";
?>


    <?php
    if($_SESSION['user_id'] > 0) { // User is logged in
        echo '<div class="centerDiv">
                <form action="gamehub.php">
                    <input type="submit" value="Return to Game Hub" class="button">
                </form>
            </div>';
    }
    else { // User is not logged in and is a ghost
        echo '<div class="centerDiv">
                <form action="login.php" class="inlineForm">
                    <input class="button2" type="submit" value="Login">
                </form>
                <form action="signup.php" class="inlineForm">
                    <input class="button" type="submit" value="Sign Up">
                </form>
            </div>';
    }
    ?>
</body>
</html>