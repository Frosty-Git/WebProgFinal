<?php
session_start();

require_once(__DIR__.'/../constants.php');
require_once(__DIR__.'/../dbGameSetupFunct.php');


if (checkGamePassword($_SESSION['game_id'], $_POST['game_password'])){
    if (joinGame($_SESSION['game_id'], $_SESSION['user_id'])) {
        $_SESSION['join_test'] = SUCCESS;
        header('Location: ../../gamelobby.php');
    }
    else {
        // The game is full
        $_SESSION['join_test'] = FAILED;
        header('Location: ../../gamehub.php'); 
    }
}
else {
    // Password is incorrect
    $_SESSION['join_test'] = FAILED;
    header('Location: ../../gamepassword.php');
}
?>