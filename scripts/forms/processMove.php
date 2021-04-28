<?php
// Start the session
session_start();

require_once('../dbGameFunct.php');

$location = $_POST['location'];
$is_x = $_SESSION['character'] == 'X' ? 1 : 0;
$playerID = $_SESSION['user_id'];
$gameID = $_SESSION['game_id'];


$answer = makeMove($playerID, $gameID, $location, $is_x);
if ($answer == 'Winner') {
    header();
}
elseif ($answer == 'Tie') {
    header();
}
else {
    if (waitForMove($gameID, $playerID)) {
        echo getEncodedBoard($gameID);
    }
}
?>