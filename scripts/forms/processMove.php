<?php
// Start the session
session_start();

require_once(__DIR__.'/../dbGameFunct.php');

$location = $_POST['location'];
$is_x = $_SESSION['character'] == 'X' ? 1 : 0;
$playerID = $_SESSION['user_id'];
$gameID = $_POST['game_id'];


$answer = makeMove($playerID, $gameID, $location, $is_x);
if ($answer) {
    header('Location: ../../gamehub.php');
}
else {
    wait fo
    $_SESSION['active'] = false;
}
?>