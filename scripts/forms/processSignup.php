<?php 
// Start the session
session_start();

// Yoink imports
require_once(__DIR__.'/../constants.php');
require_once(__DIR__.'/../dbLoginFunct.php');

// ---------- Signup Validation and Session Setting ------------------
if (confirmPassword($_POST['password1'], $_POST['password2'])) {
    if (checkPasswordLength($_POST['password1'])) {
        if (signup($_POST['username'], $_POST['password1'])) {
            // User is signed up and ready to play!
            $_SESSION["user_id"] = getUserID($_POST['username']);
            $_SESSION["username"] = $_POST['username'];
            header('Location: ../../gamehub.php');
        }
        else { 
            // Username has already been taken
            $_SESSION["user_id"] = FAILED;
            $_SESSION["username"] = 1;
            header('Location: ../../signup.php');
        }
    }
    else { 
        // Password is too short
        $_SESSION["user_id"] = FAILED;
        $_SESSION["username"] = 2;
        header('Location: ../../signup.php');
    }
}
else { 
    // Passwords do not match
    $_SESSION["user_id"] = FAILED;
    $_SESSION["username"] = 3;
    header('Location: ../../signup.php');
}
    
// ---------- End Signup Validation and Session Setting --------------

?>



