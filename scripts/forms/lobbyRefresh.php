<?php
    session_start();

    require_once(__DIR__.'/../constants.php');
    require_once(__DIR__.'/../dbGameSetupFunct.php');
    require_once(__DIR__.'/../dbGetters.php');

    $_SESSION["game_id"] = findGameNoID($_SESSION["user_id"]);
    // If they are already in a game, redirect them to that game's board.
    if ($_SESSION["game_id"] != IS_DEFAULT && $_SESSION["game_id"] != FAILED) {
        // The user is already in a game, so redirect them to that game rather
        // than loading the game lobby.
        if(getIsStarted($_SESSION["game_id"]) != 0) { //from dbGetters.php
            if(getIsEnded($_SESSION["game_id"]) == 0) {
                // The game has started but not ended, so go to the tic-tac-toe board
                // for your game in progress
                $gameInProgress = -1;
                echo $gameInProgress;
            }
            // Else, Game is ended, check for this
        }
        else {
            // You should be in the game lobby since the game hasn't started
            $players = getPlayers($_SESSION['game_id']);
            $player1 = $players[0];
            if (isset($players[1])) {
                $player2 = $players[1]; 
                
                if ($_SESSION['user_id'] ==  $player1) {
                    $_SESSION['character'] = 'X';
                    $_SESSION['active'] = true;
                }
                elseif ($_SESSION['user_id'] != $player1) {
                    $_SESSION['character'] = 'O';
                    $_SESSION['active'] = false;
                }
                // The game isn't in progress yet, so return the second player
                $player2Name = getUsername($player2);
                echo $player2Name;
            }
            else {
                echo "Player 2";
            }
        }
    }
    else { // The user isn't in a game yet, so don't let them access a game 
        // lobby and set the game id back to default
        $_SESSION["game_id"] = IS_DEFAULT;
        // You should be at the game hub since the game doesn't exist anymore
        $gameEnded = -2;
        echo $gameEnded;
    }

?>