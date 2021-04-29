<?php
    require_once('constants.php');

    // Check if user is not logged in, redirect to login page.
    if (!(isset($_SESSION['user_id'])) or ($_SESSION['user_id'] == IS_DEFAULT)) {
        header('Location: login.php');
    }
?>