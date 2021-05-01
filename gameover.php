<?php 
session_start();

require_once(__DIR__.'/scripts/dbGetters.php');

$character = $_SESSION['character'];

$wins = getWins($_SESSION['user_id']);
$losses = getLosses($_SESSION['user_id']);
$ties = getTies($_SESSION['user_id']);

$game_stats = getGameWinner($_SESSION['user_id']);
$x_won = $game_stats['x_won'];
$is_tie = $game_stats['is_tie'];

?>

<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>
<head>
    <title>Games!</title>
    <meta charset='utf-8' />
    <meta name='Author' content='Joseph Frost, Katie Lee, Marc Colin, Jacelynn Duranceau' />
    <meta name='generator' content='VS Code' />
    <link rel='shortcut icon' href='' />
    <link rel="stylesheet" href="./css/base.css">
</head>

<body>
    <h1>Game Results:</h1>

    <?php 
    if ($is_tie) {
        // tie game
        echo "<h5> You both lose and suck cause you tied. </h5>";
    }
    else {
        if(($character == 'X' and $x_won) or ($character == 'O' and !$x_won)) {
            // you did win bruh
            echo "<h5> You a mother fucking winner. </h5>";
        }
        else {
            // you suck
            echo "<h5> You lost, at tic-tac-toe.... come on man </h5>";
        }
    }
    //show their stats
    echo  "<table>";
        echo  "<tr>";
            echo  "<th>Wins</th>";
            echo  "<th>Losses</th>";
            echo  "<th>Ties</th>";
            echo  "<th>W/L Ratio</th>";
        echo "</tr>";
        echo  "<tr>"; 
            echo  "<td>";
                echo $wins;
            echo "</td>";
            echo  "<td>";
                echo $losses;
            echo "</td>";
            echo  "<td>";
                echo $ties;
            echo "</td>";
            echo  "<td>";
                if($losses != 0) {
                    echo round($wins/$losses, 2);
                }
                else {
                    echo $wins;
                }
            echo "</td>";
        echo "</tr>";
    echo "</table>";
    
    echo "<form method='post' action='./gamehub.php'>";
    echo "<button type='submit'>Return to Gamehub</button></form>";

    ?>
</body>
</html>