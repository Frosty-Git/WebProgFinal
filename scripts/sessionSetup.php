<?php
    session_start();

    // Sets default values for all of our session variables.

    $_SESSION["user_id"] = 0;
    $_SESSION["game_id"] = 0;
    $_SESSION["username"] = "none";
    $_SESSION["join_test"] = 0;
    $_SESSION["FAILED_CREATE_GAME"] = 0;
    // $_SESSION[""];
    
?>