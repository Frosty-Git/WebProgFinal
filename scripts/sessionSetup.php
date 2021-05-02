<?php
    session_start();

    require_once("constants.php");

    // Sets default values for all of our session variables.

    $_SESSION["user_id"] = IS_DEFAULT;
    $_SESSION["game_id"] = IS_DEFAULT;
    $_SESSION["username"] = IS_DEFAULT;
    $_SESSION["join_test"] = IS_DEFAULT;
    $_SESSION["FAILED_CREATE_GAME"] = IS_DEFAULT;
    $_SESSION["active"] = IS_DEFAULT;
    $_SESSION["character"] = IS_DEFAULT;
    $_SESSION["password_fail"] = IS_DEFAULT;
    // $_SESSION[""];
    
?>