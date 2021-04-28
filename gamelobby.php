<?php
    session_start();

    // Check if user is not logged in, redirect to login page.
    require_once('./scripts/checkLogIn.php');

    // Yoink Imports
    require_once(__DIR__.'/scripts/constants.php');
    require_once(__DIR__.'/scripts/dbGameSetupFunct.php');
    require_once(__DIR__.'/scripts/dbGetters.php');
    
    // Check if user is already in a game or not.
    if ($_SESSION["game_id"] == IS_DEFAULT) {
        // Set the game id to the user's currently in progress game id. If there
        // is no such game, then this value will be FAILED (-1)
        $_SESSION["game_id"] = findGameNoID($_SESSION["user_id"]);
    }

    // If they are already in a game, redirect them to that game's board.
    if ($_SESSION["game_id"] != IS_DEFAULT && $_SESSION["game_id"] != FAILED) { //from dbGameSetupFunct.php
        // The user is already in a game, so redirect them to that game rather
        // than loading the game lobby.
        if(getIsStarted($_SESSION["game_id"]) != 0) {
            header('Location: tic-tac-toe.php');
        }
        // else: the game hasn't started so you are allowed to be in the lobby, proceed
    }
    else { // The user isn't in a game yet, so don't let them access a game 
           // lobby and set the game id back to default
        $_SESSION["game_id"] = IS_DEFAULT;
        header('Location: gamehub.php');
    }

    // If the game is not started and they have a game id, then they 
    // should indeed be on this page. Proceed ;)
    
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