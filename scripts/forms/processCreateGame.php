<?php
// Start the session
session_start();

require_once('./scripts/dbGameSetupFunct.php');

$player_id = $_SESSION['user_id'];

createGame($player_id);
findGameNoID($player_id);

?>