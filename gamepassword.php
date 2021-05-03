<?php
    // Start the session
    session_start();

    // Check if user is not logged in, redirect to login page.
    require_once('./scripts/checkLogIn.php');

    // Yoink Imports
    require_once('./scripts/constants.php');
    
    $gameID = $_SESSION['game_id'];
?>

<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>
<head>
    <title>Tic-Tac-Toe | Game Password</title>
    <meta charset='utf-8' />
    <meta name='Author' content='Joseph Frost, Katie Lee, Marc Colin, Jacelynn Duranceau' />
    <meta name='generator' content='VS Code' />
    <link rel='shortcut icon' href='#' />
    <link rel="stylesheet" href="./css/base.css">
</head>

<body>

<h1 class="centerText"><span style="color: #FC4A1A">Tic</span><span style="color: #4ABDAC">-</span><span style="color: #FC4A1A">Tac</span><span style="color: #4ABDAC">-</span><span style="color: #FC4A1A">Toe</span></h1>

<?php
    if ($_SESSION["join_test"] == FAILED) {
        echo "<p style='color: red; text-align: center'>Password is incorrect. Try again.</p>";
    }
?>

<div class='centerDiv'>
    <form method='post' action='./scripts/forms/processGamePassword.php'>
        <input type='password' name='game_password' class='userInput' placeholder='Enter game password...'>
        <button type='submit' class='joinBtn button'>Join Game</button>
    </form>
</div>

<br>

<div class='centerDiv'>
    <form method='post' action='./scripts/forms/processReturnToHub.php'>
        <button type='submit' class='button'>Return to Game Hub</button>
    </form>
</div>

</body>
</html>