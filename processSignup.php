<?php 
// Start the session
session_start();

// Yoink imports
require_once('./scripts/constants.php');
require_once('./scripts/dbConnect.php');
require_once('./scripts/dbLoginFunct.php');

$dbh = ConnectDB();

// ---------- Signup Validation and Session Setting ------------------
    if (signup($dbh, $_POST['username'], $_POST['password'])) {
        $_SESSION["user_id"] = getUserID($dbh, $_POST['username']);
        $_SESSION["username"] = $_POST['username'];
        header('Location: gamehub.php');
    }
    else {
        $_SESSION["user_id"] = FAILED;
        $_SESSION["username"] = "fail_signup";
        header('Location: signup.php');
    }
// ---------- End Signup Validation and Session Setting --------------





// if (login($dbh, $_POST['username'], $_POST['password'])) {
//     echo "<h4>Login Succeeded!</h4>";
//     $_SESSION["user_id"] = getUserID($dbh, $_POST['username']);
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



