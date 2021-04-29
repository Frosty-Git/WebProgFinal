<?php 
    session_start();

    // This script is for when player 1 starts the game. It will set 
    // the game to is_started in the db and redirect player 1 to the 
    // tic-tac-toe page.

    // Check if user is not logged in, redirect to login page.
    require_once(__DIR__.'/../checkLogIn.php');

    // Yoink imports.
    require_once(__DIR__.'/../dbGameSetupFunct.php');

    if(startGame($_SESSION['game_id'], $_SESSION['user_id'])) { //from dbGameSetupFunct.php
        // Redirect player 1 to the tic tac toe board after the game is started.
        header('Location: ../../tic-tac-toe.php');
    }
    else {
        header('Location: ../../gamelobby.php');
    }
?>