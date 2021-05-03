<?php 
    session_start();

    // This script is for when player 1 presses the End Game button.
    // It will delete the game from the db and send player 1 to the 
    // Game Hub page.

    // Check if user is not logged in, redirect to login page.
    require_once(__DIR__.'/../checkLogIn.php');

    // Yoink imports.
    require_once(__DIR__.'/../dbGameSetupFunct.php');
    require_once(__DIR__.'/../dbGetters.php');

    if (getIsStarted($_SESSION['game_id']) != 1 || getIsEnded($_SESSION['game_id']) != 0) {
        kickPlayer2($_SESSION['game_id'], $_SESSION['user_id']); 
                //from dbGameSetupFunct.php
    }
    header('Location: ../../gamelobby.php'); // Reload the page to see player 2 is gone
?>