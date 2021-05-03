<?php 
session_start();

require_once(__DIR__.'/scripts/dbGetters.php');
require_once(__DIR__.'/scripts/dbGameFunct.php');

$character = $_SESSION['character'];

$wins = getWins($_SESSION['user_id']);
$losses = getLosses($_SESSION['user_id']);
$ties = getTies($_SESSION['user_id']);

$game_stats = getGameWinner($_SESSION['user_id']);
$x_won = $game_stats['x_won'];
$is_tie = $game_stats['is_tie'];
$games_id = $game_stats['games_id'];

$board = getBoard($games_id); // Gets the last game's board state

?>

<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>
<head>
    <title>Tic-Tac-Toe | Game Over</title>
    <meta charset='utf-8' />
    <meta name='Author' content='Joseph Frost, Katie Lee, Marc Colin, Jacelynn Duranceau' />
    <meta name='generator' content='VS Code' />
    <link rel='shortcut icon' href='#' />
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/tic-tac-toe.css">
</head>

<body>
    <h1 class='centerText'>Game Results:</h1>

    <?php 
    if ($is_tie) {
        // tie game
        echo "<h5 class='centerText'> Looks like no one won. ¯\_(ツ)_/¯ </h5>";
    }
    else {
        if(($character == 'X' and $x_won) or ($character == 'O' and !$x_won)) {
            // you did win bruh
            echo "<h5 class='centerText'> Congrats, you are the victor!（‐＾▽＾‐）</h5>";
        }
        else {
            // you suck
            echo "<h5 class='centerText'> You lost, at tic-tac-toe . . . come on man. (╥_╥)</h5>";
        }
    }

    echo '<div class="container-out">
        <div class="container-in">
        <div class="table-container">';
    echo "<h5 class='centerText'>Final Game Board: </h5>";
    echo '<table class="centerDiv">';

    echo "<tr>";
    echo "<td><div class='box disabled' id='a1'>"; echo $board['a1']; echo "</div></td>";
    echo "<td><div class='box disabled' id='a2'>"; echo $board['a2']; echo "</div></td>";
    echo "<td><div class='box disabled' id='a3'>"; echo $board['a3']; echo "</div></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td><div class='box disabled' id='b1'>"; echo $board['b1']; echo "</div></td>";
    echo "<td><div class='box disabled' id='b2'>"; echo $board['b2']; echo "</div></td>";
    echo "<td><div class='box disabled' id='b3'>"; echo $board['b3']; echo "</div></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td><div class='box disabled' id='c1'>"; echo $board['c1']; echo "</div></td>";
    echo "<td><div class='box disabled' id='c2'>"; echo $board['c2']; echo "</div></td>";
    echo "<td><div class='box disabled' id='c3'>"; echo $board['c3']; echo "</div></td>";
    echo "</tr>";
    echo "</table>";

    echo '</div>
        </div>
        </div><br>';


    //show their stats
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
    echo "<button type='submit' class='button'>Return to Game Hub</button>";
    echo "</form></div>";

    ?>
</body>
</html>