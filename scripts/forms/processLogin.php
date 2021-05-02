<?php
// Start the session
session_start();

// Yoink imports
require_once(__DIR__.'/../constants.php');
require_once(__DIR__.'/../dbLoginFunct.php');

// ---------- Login Validation and Session Setting -------------------
if (login($_POST['username'], $_POST['password'])) {
    $_SESSION["user_id"] = getUserID($_POST['username']);
    $_SESSION["username"] = $_POST['username'];
    header('Location: ../../gamehub.php');
}
else {
    $_SESSION["user_id"] = FAILED;
    $_SESSION["username"] = "fail_login";
    header('Location: ../../login.php');
}
// ---------- End Login Validation and Session Setting ---------------
?>