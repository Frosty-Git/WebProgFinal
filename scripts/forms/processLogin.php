<?php
// Start the session
session_start();

// Yoink imports
require_once('./scripts/constants.php');
require_once('./scripts/dbLoginFunct.php');

// ---------- Login Validation and Session Setting -------------------
if (login($_POST['username'], $_POST['password'])) {
    echo "<h4>Login Succeeded!</h4>";
    $_SESSION["user_id"] = getUserID($_POST['username']);
    echo "<p>got user</p>";
    $_SESSION["username"] = $_POST['username'];
    echo "<p>time to go to gamehub!</p>";
    header('Location: gamehub.php');
}
else {
    echo "<h4>Login Failed. Incorrect Username or Password.</h4>";
    $_SESSION["user_id"] = FAILED;
    $_SESSION["username"] = "fail_login";
    header('Location: login.php');
}
// ---------- End Login Validation and Session Setting ---------------
?>