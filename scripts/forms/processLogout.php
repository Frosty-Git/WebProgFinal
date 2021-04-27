<?php
    session_start();

    // KILL SESSION
    if(session_destroy()) {
        header('Location: ../../home.php');
    }
    else {
        header('Location: ../../gamehub.php');
    }
?>