<?php
    // Start the session
    session_start();

    // Check if user is not logged in, redirect to login page.
    require_once('./scripts/checkLogIn.php');

    // Yoink Imports
    require_once('./scripts/constants.php');
    require_once('./scripts/decoder.php');
    require_once('./scripts/dbGameSetupFunct.php');
    require_once('./scripts/dbGetters.php');

    if ($_SESSION["game_id"] == IS_DEFAULT) {
        // Set the game id to the user's currently in progress game id. If there
        // is no such game, then this value will be FAILED (-1)
        $_SESSION["game_id"] = findGameNoID($_SESSION["user_id"]);
    }
    
    // Check if user is already in a game or not.
    // If they are already in a game, redirect them to that game.
    if ($_SESSION["game_id"] != FAILED) { //from dbGameSetupFunct.php
        // The user is already in a game, so redirect them to that game rather
        // than loading the game hub.
        if(getIsStarted($_SESSION["game_id"]) == 0) { // The game has not started, redirect to game lobby
            header('Location: gamelobby.php');
        }
        else { // The game has started, redirect to the game board
            header('Location: tic-tac-toe.php');
        }
    }

    // If you make it to this point, you aren't in a game so proceed and set
    // the game id back to default
    $_SESSION["game_id"] = IS_DEFAULT;
?>

<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>
<head>
    <title>Games!</title>
    <meta charset='utf-8' />
    <meta name='Author' content='Joseph Frost, Katie Lee, Marc Colin, Jacelynn Duranceau' />
    <meta name='generator' content='VS Code' />
    <link rel='shortcut icon' href='' />
</head>

<body>
    <h1>Welcome to the Game Hub!</h1>

    <!-- Join Game Fail Message -->
    <?php
        if ($_SESSION["join_test"] == FAILED) {
            echo "<p style='color: red;'>Game Full or this is your game. Join another game sucka.</p>";
        }

        if ($_SESSION['FAILED_CREATE_GAME'] == FAILED_CREATE_GAME) {
            echo "<p style='color: red;'>Could not create game. Try again!</p>";
        }
    ?>

    <!-- Logout -->
    <form action="./scripts/forms/processLogout.php" method="post">
        <input type="submit" value="Logout">
    </form>

    <!-- Create Game Button -->
    <div>
        <form action="./scripts/forms/processCreateGame.php" method="post">
            <input type="checkbox" id="is_private" name="is_private">
            <label for="is_private">Private</label>
            <input type="text" id="game_password" name="game_password" style="display:none">
            <input type="submit" value="Create Game">
        </form>
    </div>
    <script>
        let private = document.getElementById('is_private');
        let game_p = document.getElementById('game_password');
        private.onclick = function() {
            if (private.checked) {
                console.log("Is Private Checked.");
                game_p.required = true;
                game_p.style.display = 'block';
            }
            else {
                game_p.required = false;
                game_p.style.display = 'none';
            }
        };
    </script>

    <!-- Find Game Button -->
    <form action="./scripts/forms/processFindGame.php" method="post">
    <input type="text" name="searchGame" placeholder="Search game ID...">
    <button type="submit">Find Game</button>
    </form>

    <!-- Games List Table -->
    <table>
    <tr>
    <th>Game ID</th> <th>Public?</th> <th>Players</th> <th>User Who Created</th> <th>Date Created</th>
    </tr>
    <?php 
        // Games List Format:
        // Game ID   Public/Private   Players (1/2)   User Who Created   Date Created   Join Button
        $playerID = $_SESSION['user_id'];
        $results = findAllGames(); //from dbGameSetupFunct.php
        for ($i = 0; $i < count($results); $i++) {
            $game = decodeSelectResults($results, $i); //from decoder.php
            $gameID = $game['games_id'];
            $private = $game['is_private'];
            $player_name = getUsername($game['player1']); //from dbGetters.php

            echo "<tr>";
            echo "<td>"; print_r($gameID); echo "</td>";

            if ($private == 1) {
                echo "<td>No</td>";
            }
            else {
                echo "<td>Yes</td>";
            }

            if ($game['player2'] == null) {
                echo "<td>1/2</td>";
            }
            else {
                echo "<td>2/2</td>";
            }

            echo "<td>"; print_r($player_name); echo "</td>";
            echo "<td>"; print_r($game['date_created']); echo "</td>";
            echo "<form method='post' action='./scripts/forms/processGHJoin.php'><input hidden name='gameid' value='$gameID'>";
            echo "<td><button type='submit' class='joinBtn'>Join</button></td></form>";
            echo "</tr>";
        }
    ?>

    </table>
    <!-- End Games List Table -->

    <?php
    echo $_SESSION['user_id'];
    echo "<br>";
    echo $_SESSION['username'];
    ?>
</body>
</html>