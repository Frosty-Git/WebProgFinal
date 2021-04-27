<?php
// Start the session
session_start();

require_once(__DIR__.'/../constants.php');
require_once(__DIR__.'/../dbGameSetupFunct.php');

$player_id = $_SESSION['user_id'];
$true = 1;
$false = 0;

if ($_POST["is_private"]) {
    createGame($player_id, $true, $_POST['game_password']);
}
else {
    $password = '';
    createGame($player_id, $false, $password);
}

$gameID = findGameNoID($player_id);

if ($gameID != FAILED) {
    $_SESSION["game_id"] = $gameID;
    header('Location: ../../gamelobby.php');
}
else {
    $_SESSION['FAILED_CREATE_GAME'] = FAILED_CREATE_GAME;
    header('Location: ../../gamehub.php');
}

?>