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
    
    $_SESSION["game_id"] = findGameNoID($_SESSION["user_id"]); //from dbGameSetupFunct.php
    // Check if user is already in a game or not.
    // If they are already in a game, redirect them to that game.
    if ($_SESSION["game_id"] != FAILED) { //from dbGameSetupFunct.php
        // The user is already in a game, so redirect them to that game rather
        // than loading the game hub.
        if(getIsStarted($_SESSION["game_id"]) == 0) { // The game has not started, redirect to game lobby
            header('Location: gamelobby.php');
        }
        else { // The game has started, redirect to the game board if the game hasn't ended
            if(getIsEnded($_SESSION["game_id"]) == 0) {
                $game_info = getGameInfo($_SESSION["game_id"]); //from dbGetters.php
                $player1 = $game_info['player1']; //player1 according to db (game creator)
                $player2 = null;
                //player2 according to db. Check if null because player2 can be 
                // null if only 1 player is currently in the game lobby
                if (isset($game_info['player2'])) {
                    $player2 = $game_info['player2']; 
                }
                else {
                    $player2 = IS_DEFAULT;
                }

                if ($_SESSION['user_id'] ==  $player1) {
                    $_SESSION['character'] = 'X';
                }
                elseif ($_SESSION['user_id'] != $player1) {
                    $_SESSION['character'] = 'O';
                }
                header('Location: tic-tac-toe.php');
            }
        }
    }
    else {
        // If you make it to this point, you aren't in a game so proceed and set
        // the game id back to default
        $_SESSION["game_id"] = IS_DEFAULT;
    }

?>

<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>
<head>
    <title>Tic-Tac-Toe | Game Hub</title>
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
    <table class="center ghTable2">
        <tr>
            <td style="text-align:left; width:30%;">
                <form action="./scripts/forms/processLogout.php" method="post">
                    <input type="submit" value="Logout" class="button2">
                </form>
            </td>
            <td style="text-align:center; width:40%;">
                <h1 class='centerText'>Welcome to the Game Hub!</h1>
            </td>
            <td style="text-align:right; width:30%;">
                <form action="top_players.php">
                    <input type="submit" value="See Top Players Here!" class="button2">
                </form>
            </td>
        </tr>
    </table>

    <!-- Join Game Fail Message -->
    <?php
        if ($_SESSION["join_test"] == FAILED) {
            $_SESSION["join_test"] = IS_DEFAULT;
            echo "<p style='color: red; text-align: center'>Game Full. Join another game!</p>";
        }

        if ($_SESSION['FAILED_CREATE_GAME'] == FAILED_CREATE_GAME) {
            $_SESSION['FAILED_CREATE_GAME'] = IS_DEFAULT;
            echo "<p style='color: red; text-align: center'>Could not create game. Try again!</p>";
        }

        if ($_SESSION["password_fail"] == FAILED) {
            $_SESSION["password_fail"] = IS_DEFAULT;
            echo "<p style='color: red; text-align: center'>Incorrect password. Try again!</p>";
        }

        if ($_SESSION["game_fail"] == FAILED) {
            $_SESSION["game_fail"] = IS_DEFAULT;
            echo "<p style='color: red; text-align: center'>Game does not exist. Please choose another game.</p>";
        }
    ?>
    
    <table class="center ghTable2">
        <tr>
            <td style="width: 50%; text-align:left;">
                 <!-- Create Game Button -->
                <form action="./scripts/forms/processCreateGame.php" method="post">
                    <input type="checkbox" class="checkBox" id="is_private" name="is_private">
                    <label for="is_private">Private</label>
                    <input type="password" id="game_password" name="game_password" style="display:none" class="userInput" placeholder="Create game password...">
                    <input type="submit" value="Create Game" class="button2">
                </form>
                <script>
                    let private = document.getElementById('is_private');
                    let game_p = document.getElementById('game_password');
                    private.onclick = function() {
                        if (private.checked) {
                            game_p.required = true;
                            game_p.style.display = 'inline';
                        }
                        else {
                            game_p.required = false;
                            game_p.style.display = 'none';
                        }
                    };
                </script>
            </td>
            
            <!-- Find Game Button -->
            <td style="width: 50%; text-align:right;">
                <form action="./scripts/forms/processFindGame.php" method="post">
                    <input type="text" name="searchGame" id="searchGame" placeholder="Search game ID..." class="userInput" required>
                    <button type="submit" id="submitBtn" class="button2 disabled" disabled>Find Game</button>
                </form>
                <script>
                    $('#searchGame').on('keyup', function() {
                        let value = $('#searchGame').val();
                        let re = /^[0-9]+$/; // Only accept numeric input for Game Id
                        if (!value.match(re)) {
                            $('#submitBtn').addClass('disabled');
                            $('#submitBtn').attr("disabled", "disabled");
                        }
                        else {
                            $('#submitBtn').removeClass('disabled');
                            $('#submitBtn').attr("disabled", false);
                        }
                    });
                </script>
            </td>
        </tr>
    </table>

    <!-- Games List Table -->

    <table class="center ghTable">
    <tr>
    <th>Game ID</th> <th>Public?</th> <th>Players</th> <th>User Who Created</th> <th>Date Created</th> <th></th>
    </tr>
    <?php 
        $count = 0;

        // Games List Format:
        // Game ID   Public/Private   Players (1/2)   User Who Created   Date Created   Join Button
        $playerID = $_SESSION['user_id'];
        $results = findAllGames(); //from dbGameSetupFunct.php
        $count = count($results);
        if ($count == 0) {
            echo "<tr></tr>"; // added a new line
            echo "<tr><td colspan='6' class='centerText'>No Games Currently Being Played.
                  </td></tr>";
        }
        else {
            for ($i = 0; $i < $count; $i++) {
                $game = decodeSelectResults($results, $i); //from decoder.php
                $gameID = $game['games_id'];
                $private = $game['is_private'];
                $player_name = getUsername($game['player1']); //from dbGetters.php
    
                echo "<tr>";
                echo "<td class='tableTd'>"; print_r($gameID); echo "</td>";
    
                if ($private == 1) {
                    echo "<td class='tableTd'>No</td>";
                }
                else {
                    echo "<td class='tableTd'>Yes</td>";
                }
    
                if ($game['player2'] == null) {
                    echo "<td class='tableTd'>1/2</td>";
                }
                else {
                    echo "<td class='tableTd'>2/2</td>";
                }
    
                echo "<td class='tableTd'>"; print_r($player_name); echo "</td>";
                echo "<td class='tableTd'>"; print_r($game['date_created']); echo "</td>";
                echo "<td class='tableTd'><form method='post' action='./scripts/forms/processGHJoin.php'><input hidden name='gameid' value='$gameID'>";
                if ($private) {
                    echo "<input type='password' name='game_password' class='userInput' placeholder='Enter game password...'>";
                }
                echo "<button type='submit' class='joinBtn button'>Join</button>";
                echo "</form></td></tr>";
            }
        }
    ?>

    </table>
    <!-- End Games List Table -->
</body>
</html>