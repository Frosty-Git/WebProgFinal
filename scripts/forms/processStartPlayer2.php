
<?php
session_start();

require_once('../dbGameFunct.php');

$gameID = $_SESSION['game_id'];

if (player2Start($gameID, $_SESSION['user_id'])) {
    $_SESSION['active'] = true;
    echo getEncodedBoard($gameID);
}
?>