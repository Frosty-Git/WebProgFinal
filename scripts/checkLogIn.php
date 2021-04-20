<?php
    // Check if user is not logged in, redirect to login page.
    if (!(isset($_SESSION['user_id']))) {
        header('Location: login.php');
    }
?>