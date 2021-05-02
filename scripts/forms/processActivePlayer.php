<?php
    session_start();

    require_once(__DIR__.'/../dbGetters.php');

    // Checks if the game has ended 
    if (getIsEnded($_SESSION['game_id'])) {
        $endgame = 2;
        echo $endgame; // will redirect to gameover.php
    }
    else {
        // gets the player ID of the active player
        $activePlayer = getActivePlayer($_SESSION['game_id']); 

        // Checks if the active player is the current user or not
        $_SESSION['active'] = ($activePlayer == $_SESSION['user_id']); 
        echo $_SESSION['active'];
    }
?>