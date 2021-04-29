<?php 
    session_start();

    // Check if user is not logged in, redirect to login page.
    require_once(__DIR__.'/../checkLogIn.php');

    require_once(__DIR__.'/../dbGameSetupFunct.php');
    require_once(__DIR__.'/../constants.php');

    leaveGame($_SESSION['game_id'], $_SESSION['user_id']); 
                //from dbGameSetupFunct.php
    $_SESSION['game_id'] = IS_DEFAULT;

    // Redirect player 1 to Game Hub after the game is deleted.
    header('Location: ../../gamehub.php');
?>