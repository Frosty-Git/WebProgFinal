<?php
// Start the session
session_start();

require_once('./scripts/sessionSetup.php');

// Yoink imports
require_once('./scripts/constants.php');
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
</head>
<body>
    <div class="centerDiv">
    <h1><span style="color: #FC4A1A">Tic</span><span style="color: #4ABDAC">-</span><span style="color: #FC4A1A">Tac</span><span style="color: #4ABDAC">-</span><span style="color: #FC4A1A">Toe</span></h1>
    <form enctype="multipart/form-data" action='./scripts/forms/processSignup.php' method='post'>
        <fieldset class="fSet">
        <legend class="fLegend">Sign Up</legend>
        <table>
            <tr>
                <td>Username:</td>
                <td> <input name='username' type='text' class="userInput" required/> </td>
            </tr>
            <tr>
                <td>Password:</td>
                <td> <input name='password' type='password' class="userInput" required/> </td>
            </tr>
            <!-- <tr>
                <td>Picture:</td>
                <td> <input name="picture" type="file"> </td>
            </tr> -->
        </table>
        </fieldset>
        <p>
            <input type='submit' value="Sign Up" class="button"/>
        </p>
    </form>
    </div>

    <?php
    if ($_SESSION["user_id"] == FAILED) {
        echo "<p style='color: red;'>Username taken... 
            Please try again.</p>";
    }
    ?>

</body>
</html>