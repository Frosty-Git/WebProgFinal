<?php
// Start the session
session_start();

// Yoink imports
require_once('./scripts/constants.php');

// Need to do this otherwise all session stuff gets reset to 0
// and the errors will not show up
if ($_SESSION['user_id'] != FAILED) { 
    require_once('./scripts/sessionSetup.php');
}
?>

<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>
<head>
    <title>Tic-Tac-Toe | Sign Up</title>
    <meta charset='utf-8' />
    <meta name='Author' content='Joseph Frost, Katie Lee, Marc Colin, Jacelynn Duranceau' />
    <meta name='generator' content='VS Code' />
    <link rel='shortcut icon' href='#' />
    <link rel="stylesheet" href="./css/base.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
		  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
		  crossorigin="anonymous"></script>
</head>
<body>
    <div class="centerDiv">
    <h1><span style="color: #FC4A1A">Tic</span><span style="color: #4ABDAC">-</span><span style="color: #FC4A1A">Tac</span><span style="color: #4ABDAC">-</span><span style="color: #FC4A1A">Toe</span></h1>

    <?php
        if ($_SESSION["username"] == 1) {
            echo "<p style='color: red;' class='centerText'>Username taken... 
                Please try again.</p>";
        }
        else if ($_SESSION['username'] == 2) {
            echo "<p style='color: red;' class='centerText'>Password is too short (must be at least 7 characters).
                Please try again.</p>";
        }
        else if ($_SESSION['username'] == 3) {
            echo "<p style='color: red;' class='centerText'>Passwords do not match.
                Please try again.</p>";
        }
    ?>

    <form enctype="multipart/form-data" action='./scripts/forms/processSignup.php' method='post'>
        <fieldset class="fSet">
        <legend class="fLegend">Sign Up</legend>
        <table>
            <tr>
                <th>Username:</th>
                <td> <input id='username' name='username' type='text' class="userInput" placeholder="Must be 3+ characters..." required/> </td>
            </tr>
            <tr>
                <th>Password:</th>
                <td> <input id='password1' name='password1' type='password' class="userInput" placeholder="Must be 7+ characters..." required/> </td>
            </tr>
            <tr>
                <th>Confirm Password:</th>
                <td> <input id='password2' name='password2' type='password' class="userInput" required/> </td>
            </tr>
        </table>
        </fieldset>
        <p>
            <input id='submitBtn' type='submit' value="Sign Up" class="button disabled" disabled/>
        </p>
    </form>
    </div>

    <script>
        $('#username').on('keyup', function() {
            var length = $('#username').val().length;
            let value = $('#username').val();
            let re = /^[A-Za-z0-9\-\_]+$/; // Username can contain letters, numbers, _, and -
            let re2 = /[A-Za-z0-9]+/; // Username must have at least one letter or number
            if (length < 3 || !value.match(re) || !value.match(re2)) {
                $('#submitBtn').addClass('disabled');
                $('#submitBtn').attr("disabled", "disabled");
            }
            else {
                $('#submitBtn').removeClass('disabled');
                $('#submitBtn').attr("disabled", false);
            }
        });
    </script>

</body>
</html>