<?php 
// Start the session
session_start();

// Yoink imports
require_once(__DIR__.'/../constants.php');
require_once(__DIR__.'/../dbLoginFunct.php');

// ---------- Signup Validation and Session Setting ------------------
    if (signup($_POST['username'], $_POST['password'])) {
        $_SESSION["user_id"] = getUserID($_POST['username']);
        $_SESSION["username"] = $_POST['username'];
        header('Location: ../../gamehub.php');
    }
    else {
        $_SESSION["user_id"] = FAILED;
        $_SESSION["username"] = "fail_signup";
        header('Location: ../../signup.php');
    }
// ---------- End Signup Validation and Session Setting --------------

?>



