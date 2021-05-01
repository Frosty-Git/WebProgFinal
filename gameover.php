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
    <center><h1>Game Results:</h1></center>

    <?php 
    if ($is_tie) {
        // tie game
        echo "<center><h5> Looks like no one won. ¯\_(ツ)_/¯ </h5></center>";
    }
    else {
        if(($character == 'X' and $x_won) or ($character == 'O' and !$x_won)) {
            // you did win bruh
            echo "<center><h5> Congrats, you are the victor!（‐＾▽＾‐）</h5></center>";
        }
        else {
            // you suck
            echo "<center><h5> You lost, at tic-tac-toe . . . come on man. (╥_╥)</h5></center>";
        }
    }
    //show their stats
        // echo  "<center><h5>My Statistics:</h5></center>";
        echo  "<table class='center goTable'>";
        echo  "<tr>";
            echo  "<th>Wins</th>";
            echo  "<th>Losses</th>";
            echo  "<th>Ties</th>";
            echo  "<th>W/L Ratio</th>";
        echo "</tr>";
        echo  "<tr>"; 
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
    echo "</table><br>";
    
    echo "<div class='centerDiv'>";
    echo "<form method='post' action='./gamehub.php'>";
    echo "<button type='submit' class='button'>Return to Gamehub</button>";
    echo "</form></div>";

    ?>
</body>
</html>