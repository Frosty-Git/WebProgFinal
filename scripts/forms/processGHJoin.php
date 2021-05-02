<?php
// Start the session
session_start();

require_once(__DIR__.'/../constants.php');
require_once(__DIR__.'/../dbGameSetupFunct.php');

// PHP is dumb and you can't do this without the global keyword inside
// the function...
$user_id = $_SESSION['user_id'];
$gameID = $_POST['gameid'];
$password = $_POST['game_password'];

function process_join() {
    // Apparently you need to use this global keyword to be able to 
    // use. Those global variables declared outside this function.
    global $user_id, $gameID;
    
    if (joinGame($gameID, $user_id)) { //from dbGameSetupFunct.php
        $_SESSION['join_test'] = SUCCESS;
        $_SESSION['game_id'] = $gameID;
        header('Location: ../../gamelobby.php');
    }
    else {
        $_SESSION['join_test'] = FAILED;
        header('Location: ../../gamehub.php');
    }
}

if (checkGamePrivate($gameID)) { //from dbGameSetupFunct.php
    if (checkGamePassword($gameID, $password)) { //from dbGameSetupFunct.php
        process_join(); 
    }
    else {
        $_SESSION['password_fail'] = FAILED;
        header('Location: ../../gamehub.php');
    }
}
else {
    process_join(); 
}

?>