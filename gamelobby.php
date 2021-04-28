<?php 
    session_start();

    require_once(__DIR__.'/scripts/dbGameSetupFunct.php');
    require_once(__DIR__.'/scripts/dbGetters.php');
?>

<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>
<head>
<title>Games!</title>
  <meta charset='utf-8' />
  <meta name='Author' content='Joseph Frost, Katie Lee, Marc Colin, Jacelynn Duranceau' />
  <meta name='generator' content='VS Code' />
  <link rel='shortcut icon' href='' />
</head>
<body>

    <h1>Get Ready for Your High Velocity Gaming Experience</h1>
    
    <!-- Display Game Lobby Info 
         Also, determine which curent session player is player1 and 
         which is player2 -->
    <?php 
        $gameID = $_SESSION['game_id'];
        $user_id = $_SESSION['user_id'];
        $username = $_SESSION['username'];
        $private = getIsPrivate($gameID); //from dbGetters.php
        $players = getPlayers($gameID); //from dbGetters.php
        $player1 = $players[0]; //player1 according to db (game creator)
        $player2 = $players[1]; //player2 according to db
                                //null if only 1 player in game
        

        echo '<p>game_id: ';
        echo "</p>";
        echo $gameID;
        echo '<p>user_id: ';
        echo "</p>";
        echo $user_id;
        echo '<p>username: ';
        echo "</p>";
        echo $username; 
        echo "<p>Game is private: "; 
        echo $private;
        echo "</p>";
        echo "<p>Player1 ID: "; 
        echo $player1;
        echo "</p>";
        echo "<p>Player2 ID: "; 
        echo $player2;
        echo "</p>";
    ?>

    <!-- Only clickable for the host -->
    <button>Start</button>

    <!-- People can join this -->
    <button>Leave</button>
    
</body>
</html>