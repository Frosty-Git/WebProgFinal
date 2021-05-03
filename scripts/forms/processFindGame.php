<?php
session_start();

require_once(__DIR__.'/../constants.php');
require_once(__DIR__.'/../dbGameSetupFunct.php');

$player_id = $_SESSION['user_id'];
$gameID = $_POST['searchGame'];


if (findGame($gameID)) { // Check if game exists
    if(getIsPrivate($gameID)) {
        $_SESSION['game_id'] = $gameID;
        header('Location: ../../gamepassword.php');
    }
    else if(joinGame($gameID, $player_id)) {
        $_SESSION['join_test'] = SUCCESS;
        $_SESSION['game_id'] = $gameID;
        $_SESSION['game_fail'] = SUCCESS;
        header('Location: ../../gamelobby.php');
    }
    else {
        $_SESSION['join_test'] = FAILED;
        header('Location: ../../gamehub.php');
    }
}
else {
    $_SESSION['game_fail'] = FAILED;
    header('Location: ../../gamehub.php');
}

?>