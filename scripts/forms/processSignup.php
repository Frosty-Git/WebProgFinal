<?php 
// Start the session
session_start();

// Yoink imports
require_once('../constants.php');
require_once('../dbLoginFunct.php');

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





// if (login( $_POST['username'], $_POST['password'])) {
//     echo "<h4>Login Succeeded!</h4>";
//     $_SESSION["user_id"] = getUserID($_POST['username']);
//     $_SESSION["username"] = $_POST['username'];
//     header('Location: gamehub.php');
// }
// else {
//     echo "<h4>Login Failed. Incorrect Username or Password.</h4>";
//     $_SESSION["user_id"] = FAILED_LOGIN;
//     $_SESSION["username"] = "fail_login";
//     header('Location: login.php');
// }
?>



