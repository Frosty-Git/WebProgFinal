<?php
// Start the session
session_start();

require_once(__DIR__.'/../constants.php');
require_once(__DIR__.'/../dbGameSetupFunct.php');

$player_id = $_SESSION['user_id'];
$gameID = $_POST['gameid'];
$password = $_POST['game_password'];

function process_join() {
    if (joinGame($gameID, $player_id)) {
        $_SESSION['join_test'] = SUCCESS;
        $_SESSION['game_id'] = $gameID;
        header('Location: ../../gamelobby.php');
    }
    else {
        $_SESSION['join_test'] = FAILED;
        header('Location: ../../gamehub.php');
    }
}

if (checkGamePrivate($gameID)) {
    if (checkGamePassword($gameID, $password)) {
        process_join();
    }
}
else {
    process_join();
}

?>