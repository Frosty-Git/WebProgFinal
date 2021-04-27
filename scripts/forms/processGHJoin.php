<?php
// Start the session
session_start();

require_once('../constants.php');
require_once('../dbGameSetupFunct.php');

$player_id = $_SESSION['user_id'];

if (joinGame($_POST['gameid'], $player_id)) {
    $_SESSION['join_test'] = SUCCESS;
    $_SESSION['game_id'] = $_POST['gameid'];
    header('Location: ../../gamelobby.php');
}
else {
    $_SESSION['join_test'] = FAILED;
    header('Location: ../../gamehub.php');
}

?>