<?php 
    require_once("dbConnect.php");
    require_once("decoder.php");
    require_once("dbGetters.php");
    require_once("dbLoginFunct.php");
    
    // Creates the game
    // params: playerID = player 1's id
    //         is_private = If the game is private or not
    //         password = if the game is private, the password will be set
    //                    if the game is public, the password is an empty string
    function createGame($playerID, $is_private, $password) {
        try { 
            $hashed_password = encodePassword($password);
            $game_creation = "CALL createGame('$playerID', '$is_private', '$hashed_password')";
            dbQuery($game_creation); 
        }
        catch (PDOException $e) {
            die ('PDO error in createGame()": ' . $e->getMessage() );
        }
    }

    // // Is this being used? if not, can we delete?
    // function createBoard($gameID) {
    //     try {
    //         $board_creation = "INSERT INTO board (game_id) VALUES ('$gameID')";
    //         dbQuery($board_creation);
    //         return "You created a game!";
    //     }
    //     catch (PDOException $e) {
    //         die ('PDO error in createBoard()": ' . $e->getMessage() );
    //     }
    // }
    
    // Enter in the game id to join your friend's game.
    function findGame($gameID) {
        try {
            $games_query = "SELECT games_id, player1, date_created FROM games WHERE games_id='$gameID'";
            $game = dbSelect($games_query);
            
            if(empty($game)) {
                return "No game found!";
            }
            return $game;
        }
        catch (PDOException $e) {
            die ('PDO error in findGame()": ' . $e->getMessage() );
        }
    }

    // Finds the game id if you have the player id.
    // Returns the game id of the most recently created open game 
    // which the entered playerID is in if there is one.
    // If the player is not in any open games, then
    // returns -1 (FAILED).
    function findGameNoID($playerID) {
        try {
            $games_query = "CALL findGameNoGameID('$playerID')";
            $game = dbSelect($games_query);
            $gameID = decodeSelectFirstResult($game)['games_id'];
            
            if(empty($game)) {
                return FAILED;
            }
            return $gameID;
        }
        catch (PDOException $e) {
            die ('PDO error in findGame()": ' . $e->getMessage() );
        }
    }

    // Finds all the games that are open to join.
    function findOpenGames() {
        try {
            $games_query = "SELECT games_id, player1, date_created FROM games WHERE is_private=0";
            $games_set = dbSelect($games_query);
            if(empty($games_set)) {
                return "No games are open!";
            }
            return $games_set;
        }
        catch (PDOException $e) {
            die ('PDO error in findOpenGame()": ' . $e->getMessage() );
        }
    }

    //Finds all active games 
    function findAllGames() {
        try {
            $games_query = "SELECT * FROM games WHERE game_ended=0";
            $games_set = dbSelect($games_query);
            if(empty($games_set)) {
                return null;
            }
            return $games_set;
        }
        catch (PDOException $e) {
            die ('PDO error in findOpenGame()": ' . $e->getMessage() );
        }
    }

    // The second player joining the game that they found.
    function joinGame($gameID, $playerID) {
        try {
            // Check if the game is full
            $games_query = "SELECT player1 FROM games WHERE games_id='$gameID' AND player2 IS NULL" ;
            $games_set = dbSelect($games_query);
            $player1_id = decodeSelectFirstResult($games_set)['player1'];
            if(empty($games_set) or $player1_id == $playerID) {
                // You can't join your own game or the game is full
                return false;
            }
            
            // If the game wasn't full, go join the game
            $update_query = "UPDATE games SET player2 = '$playerID' WHERE games_id = '$gameID';";
            dbQuery($update_query);
            return true;
        }
        catch (PDOException $e) {
            die ('PDO error in joinGame()": ' . $e->getMessage() );
        }
    }

    // Checks if the game is private or not (true if private, false if public)
    function checkGamePrivate($gameID) {
        try {
            $games_query = "SELECT is_private FROM games WHERE games_id='$gameID'" ;
            $games_set = dbSelect($games_query);
            $private = decodeSelectFirstResult($games_set)['is_private'];

            $true = 1;
            if($private == $true) {
                return true;
            }
            return false;
        }
        catch (PDOException $e) {
            die ('PDO error in checkGamePrivate()": ' . $e->getMessage() );
        }
    }

    // Checks the password for the private game
    function checkGamePassword($gameID, $password) {
        try {
            $games_query = "SELECT password FROM games WHERE games_id='$gameID'" ;
            $games_set = dbSelect($games_query);
            $gamePassword = decodeSelectFirstResult($games_set)['password'];

            if(password_verify($password, $gamePassword)) {
                return true;
            }
            return false;
        }
        catch (PDOException $e) {
            die ('PDO error in checkGamePassword()": ' . $e->getMessage() );
        }
    }

    // Starts the game by calling stored procedure startGame
    // Can only be used by Player 1
    function startGame($gameID, $player) {
        try {
            // The player cancelling the game must be player 1 (the host)
            $start_query = "CALL startGame('$gameID', '$player');";
            dbQuery($start_query);
            $is_started = getIsStarted($gameID); // from gbGetters.php
            if($is_started == 1) {
                return true;
            }
            else {
                return false;
            }
        }
        catch (PDOException $e) {
            die ('PDO error in startGame()": ' . $e->getMessage() );
        }
    }

    // Deletes the game by calling stored procedure deleteGame
    // Can only be used by Player 1
    function cancelGame($gameID, $player) {
        try {
            // The player cancelling the game must be player 1 (the host)
            $delete_query = "CALL deleteGame('$gameID', '$player');";
            dbQuery($delete_query);
            return "GAME OVER";
        }
        catch (PDOException $e) {
            die ('PDO error in cancelGame()": ' . $e->getMessage() );
        }
    }

    // Sets player 2 back to empty by calling stored procedure leaveGame
    // Can only be used by Player 2
    function leaveGame($gameID, $player) {
        try {
            // The player leaving the game must be player 2
            $leave_query = "CALL leaveGame('$gameID', '$player');";
            dbQuery($leave_query);
            return "LEFT GAME";
        }
        catch (PDOException $e) {
            die ('PDO error in leaveGame()": ' . $e->getMessage() );
        }
    }

    // Kicks player2 out of the game by calling stored procedure kickPlayer2
    // Can only be used by Player 1
    function kickPlayer2($gameID, $player) {
        try {
            // Player 1 kicks player 2. $player must match player 1, and player
            // 2 in this game will be set to null.
            $kick_query = "CALL kickPlayer2('$gameID', '$player');";
            dbQuery($kick_query);
            return "KICKED PLAYER 2";
        }
        catch (PDOException $e) {
            die ('PDO error in kickPlayer2()": ' . $e->getMessage() );
        }
    }
    
?>