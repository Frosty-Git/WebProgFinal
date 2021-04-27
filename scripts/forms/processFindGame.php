<?php
session_start();

require_once(__DIR__.'/../constants.php');
require_once(__DIR__.'/../dbGameSetupFunct.php');

$player_id = $_SESSION['user_id'];
$gameID = $_POST['searchGame'];

if(joinGame($gameID, $player_id)) {
    $_SESSION['join_test'] = SUCCESS;
    $_SESSION['game_id'] = $gameID;
    header('Location: ../../gamelobby.php');
}
else {
    $_SESSION['join_test'] = FAILED;
    header('Location: ../../gamehub.php');
}

?>