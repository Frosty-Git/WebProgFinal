<?php
    session_start();

    require_once(__DIR__.'/../constants.php');

    $_SESSION['game_id'] = IS_DEFAULT;
    $_SESSION['join_test'] = IS_DEFAULT;

    header('Location: ../../gamehub.php');
?>