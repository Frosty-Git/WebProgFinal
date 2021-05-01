<?php
    session_start();

    // Check if user is not logged in, redirect to login page.
    // require_once('./scripts/checkLogIn.php');

    // Yoink Imports
    require_once(__DIR__.'/scripts/constants.php');
    require_once(__DIR__.'/scripts/dbGameSetupFunct.php');
    require_once(__DIR__.'/scripts/dbGetters.php');
    
    // // Check if user is already in a game or not.
    // if ($_SESSION["game_id"] == IS_DEFAULT) {
    //     // Set the game id to the user's currently in progress game id. If there
    //     // is no such game, then this value will be FAILED (-1)
         
    //                             //from dbGameSetupFunct.php
    // }


    $_SESSION["password_fail"] = IS_DEFAULT; // If you made it here, the password was correct
    $_SESSION["game_id"] = findGameNoID($_SESSION["user_id"]);
    // If they are already in a game, redirect them to that game's board.
    if ($_SESSION["game_id"] != IS_DEFAULT && $_SESSION["game_id"] != FAILED) {
        // The user is already in a game, so redirect them to that game rather
        // than loading the game lobby.
        if(getIsStarted($_SESSION["game_id"]) != 0) { //from dbGetters.php
            if(getIsEnded($_SESSION["game_id"]) == 0) {
                header('Location: tic-tac-toe.php');
            }
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



    // Set Game Lobby Info Variables
    $gameID = $_SESSION['game_id'];
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $private = getIsPrivate($gameID); //from dbGetters.php
    $players = getPlayers($gameID); //from dbGetters.php
    $user_is_player1 = false;
    $player1 = $players[0]; //player1 according to db (game creator)
    $player2 = null;
    //player2 according to db. Check if null because player2 can be 
    // null if only 1 player is currently in the game lobby
    if (isset($players[1])) {
        $player2 = $players[1]; 
    }
    else {
        $player2 = IS_DEFAULT;
    }
    // Determine if the user is player1 or player2
    if ($user_id == $player1) {
        $user_is_player1 = true;
    }

    if ($_SESSION['user_id'] ==  $player1) {
        $_SESSION['character'] = 'X';
        $_SESSION['active'] = true;
    }
    elseif ($_SESSION['user_id'] != $player1) {
        $_SESSION['character'] = 'O';
        $_SESSION['active'] = false;
    }


    //--------------Session Info Prints --- DELETE LATER--------------
    echo '<p>game_id: ';
    echo $gameID;
    echo "</p>";
    echo '<p>user_id: ';
    echo $user_id;
    echo "</p>";
    echo '<p>username: ';
    echo $username; 
    echo "</p>";
    echo "<p>Game is private: "; 
    echo $private;
    echo "</p>";
    echo "<p>Player1 ID: "; 
    echo $player1;
    echo "</p>";
    echo "<p>Player2 ID: "; 
    echo $player2;
    echo "</p>";
    echo "<p>Players[0] ID: "; 
    echo $players[0];
    echo "</p>";
    echo "<p>Players[1] ID: "; 
    echo $players[1];
    echo "</p>";
    //---------- End Session Info Prints -----------------------------

?>

<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>
<head>
<title>Tic-Tac-Toe | Game Lobby</title>
  <meta charset='utf-8' />
  <meta name='Author' content='Joseph Frost, Katie Lee, Marc Colin, Jacelynn Duranceau' />
  <meta name='generator' content='VS Code' />
  <link rel='shortcut icon' href='#' />
  <link rel="stylesheet" href="./css/base.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
		  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
		  crossorigin="anonymous"></script>
</head>
<body>

    <h1 class="centerText">Get Ready for Your High Velocity Gaming Experience</h1>
    
    <?php 
        echo '<div class="centerDiv">
            <h3>'; echo getUsername($player1); echo ' VS '; 
            echo '<span id="player2name">';
        if($player2 > 0) {
              echo getUsername($player2);
        }
        else {
              echo 'Player 2';
        }
        echo '</span>';
        echo '</h3></div>';
        if ($user_is_player1) {
            // Start Button: Only clickable for the host. Starts the game.
            echo '<div class="centerDiv"><form action="./scripts/forms/processStartGame.php">
                      <input type="submit" value="Start Game" class="button2">
                  </form>';

            // End Game Button: For Host, ends game.
            echo '<form action="./scripts/forms/processCancelGame.php">
                      <input type="submit" value="Cancel Game" class="button2">
                  </form>';
            // Kick Player 2 button: For Host, kicks second player from game
            echo '<form action="./scripts/forms/processKickPlayer2.php">
                      <input type="submit" value="Kick Player 2" class="button2">
                  </form>
                  </div>';

            // header("Refresh:5");
        }
        else {
            echo '<div class="centerDiv"><p>Waiting for host to start the game.</p>';
            // Leave Button: For player2, makes them leave the game.
            echo '<form action="./scripts/forms/processLeaveGame.php">
                      <input type="submit" value="Leave Game" class="button2">
                  </form>
                  </div>';
            // header("Refresh:5");
        }
        
        // If the user is player2, then they need to be checking the 
        // db to see if player1 has started the game, or if player1 
        // has ended the game. This needs to be async so that player2 
        // can still choose to click the leave game button if 
        // they wish.
        // Note: when the game is ended, player2's game_id needs to be 
        //       set to default before sending them back to game lobby
        // Player2 also needs to be checking if they have been kicked.

        // Player 1: Check player 2 join <-> player 2 leave (can switch)
        // Player 2: Check cancel game, start game, if been kicked

    ?>    
<script>
    $(document).ready(function() {
        lobby_update();
    });

    function lobby_update() {
        $.get("./scripts/forms/lobbyRefresh.php", function(data) {
            console.log(data);
            if (data == -1) { // 1 Means the game has started, go to the board
                window.location = "tic-tac-toe.php";
            }
            else if (data == -2) { // The game was canceled so go back to gamehub
                window.location = "gamehub.php";
            }
            else {
                $('#player2name').html(data);
                window.setTimeout(lobby_update, 1000);
            }

        });
    }
</script>



</body>
</html>