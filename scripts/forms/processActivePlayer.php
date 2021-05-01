<?php
    session_start();

    require_once(__DIR__.'/../dbGetters.php');

    if (getIsEnded($_SESSION['game_id'])) {
        header('Location: ../../gameover.php');
        // $endgame = 2;
        // echo $endgame;
    }
    else {
        $activePlayer = getActivePlayer($_SESSION['game_id']);
        $_SESSION['active'] = ($activePlayer == $_SESSION['user_id']);
        echo $_SESSION['active'];
    }
?>