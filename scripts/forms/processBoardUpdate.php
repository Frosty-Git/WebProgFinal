<?php
session_start();

require_once(__DIR__.'/../dbGameFunct.php');
require_once(__DIR__.'/../dbGetters.php');


$board = getEncodedBoard($_SESSION['game_id']); //returns board in json format
echo $board;
?>