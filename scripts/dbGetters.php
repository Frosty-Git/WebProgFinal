<?php 
    require_once("dbConnect.php");
    require_once("decoder.php");
    require_once("constants.php");
    
    // -------------------Player Table Getters------------------------

    // Get the Username from the Player table using a playerID.
    function getUsername($playerID) {
        try {
            $player_query = "SELECT username FROM player WHERE player_id='$playerID'";
            $player_data = dbSelect($player_query); // from dbConnect.php
            if (empty($player_data)) {
                return FAILED; //from constants.php
            }
            $index = 0;
            $player_data_array = decodeSelectResults($player_data, $index); //from decoder.php
            return $player_data_array['username'];
        }
        catch(PDOException $e)
        {
            die ('PDO error in getUsername()": ' . $e->getMessage() );
        }
    }

    
    // Get the Password from the Player table using a Username.
    function getPassword($username) {
        try {
            $player_query = "SELECT password FROM player WHERE username='$username'";
            $player_data = dbSelect($player_query); // from dbConnect.php
            if (empty($player_data)) {
                return FAILED; //from constants.php
            }
            $index = 0;
            $player_data_array = decodeSelectResults($player_data, $index); //from decoder.php
            return $player_data_array['password'];
        }
        catch(PDOException $e)
        {
            die ('PDO error in getUsername()": ' . $e->getMessage() );
        }
    }


    // Gets the number of wins a player has from the Player table using their ID
    function getWins($playerID) {
        try {
            $query_result = dbSelect("SELECT wins FROM player WHERE player_id = '$playerID';"); // from dbConnect.php
            if (empty($query_result)) {
                return FAILED; //from constants.php
            }
            $result_decoded = decodeSelectFirstResult($query_result)['wins']; //from decoder.php
            return $result_decoded;
        }
        catch(PDOException $e)
        {
            die ('PDO error in getWins()": ' . $e->getMessage() );
        }
    }


    // Gets the number of losses a player has from the Player table using their ID
    function getLosses($playerID) {
        try {
            $query_result = dbSelect("SELECT losses FROM player WHERE player_id = '$playerID';"); // from dbConnect.php
            if (empty($query_result)) {
                return FAILED; //from constants.php
            }
            $result_decoded = decodeSelectFirstResult($query_result)['losses']; //from decoder.php
            return $result_decoded;
        }
        catch(PDOException $e)
        {
            die ('PDO error in getLosses()": ' . $e->getMessage() );
        }
    }


    // Gets the number of ties a player has from the Player table using their ID
    function getTies($playerID) {
        try {
            $query_result = dbSelect("SELECT ties FROM player WHERE player_id = '$playerID';"); // from dbConnect.php
            if (empty($query_result)) {
                return FAILED; //from constants.php
            }
            $result_decoded = decodeSelectFirstResult($query_result)['ties']; //from decoder.php
            return $result_decoded;
        }
        catch(PDOException $e)
        {
            die ('PDO error in getTies()": ' . $e->getMessage() );
        }
    }

    // ----------------End Player Table Getters-----------------------



    // ------------------Games Table Getters--------------------------

    // Get whether or not the game is private from the Games table.
    function getIsPrivate($gameID) {
        try {
            $query_result = dbSelect("SELECT is_private FROM games WHERE games_id = '$gameID';"); // from dbConnect.php
            if (empty($query_result)) {
                return FAILED; //from constants.php
            }
            $result_decoded = decodeSelectFirstResult($query_result)['is_private']; //from decoder.php
            return $result_decoded;
        }
        catch(PDOException $e)
        {
            die ('PDO error in getIsPrivate()": ' . $e->getMessage() );
        }
    }
    

    // Get whether or not the game is started from the Games table.
    function getIsStarted($gameID) {
        try {
            $query_result = dbSelect("SELECT is_started FROM games WHERE games_id = '$gameID';"); // from dbConnect.php
            if (empty($query_result)) {
                return FAILED; //from constants.php
            }
            $result_decoded = decodeSelectFirstResult($query_result)['is_started']; //from decoder.php
            return $result_decoded;
        }
        catch(PDOException $e)
        {
            die ('PDO error in getIsStarted()": ' . $e->getMessage() );
        }
    }


    // Get whether or not the game has ended from the Games table.
    function getIsEnded($gameID) {
        try {
            $query_result = dbSelect("SELECT game_ended FROM games WHERE games_id = '$gameID';"); // from dbConnect.php
            if (empty($query_result)) {
                return FAILED; //from constants.php
            }
            $result_decoded = decodeSelectFirstResult($query_result)['game_ended']; //from decoder.php
            return $result_decoded;
        }
        catch(PDOException $e)
        {
            die ('PDO error in getIsStarted()": ' . $e->getMessage() );
        }
    }
    

    // Get Player1.
    function getPlayer1($gameID) {
        try {
            $query_result = dbSelect("SELECT player1 FROM games WHERE games_id = '$gameID';"); // from dbConnect.php
            if (empty($query_result)) {
                return FAILED; //from constants.php
            }
            $result_decoded = decodeSelectFirstResult($query_result)['player1']; //from decoder.php
            return $result_decoded;
        }
        catch(PDOException $e)
        {
            die ('PDO error in getPlayer1()": ' . $e->getMessage() );
        }
    }


    // Get Player2.
    // Note: player2 will be null if there is only one player 
    //       currently in the game.
    function getPlayer2($gameID) {
        try {
            $query_result = dbSelect("SELECT player2 FROM games WHERE games_id = '$gameID';"); // from dbConnect.php
            if (empty($query_result)) {
                return FAILED; //from constants.php
            }
            $result_decoded = decodeSelectFirstResult($query_result)['player2']; //from decoder.php
            return $result_decoded;
        }
        catch(PDOException $e)
        {
            die ('PDO error in getPlayer2()": ' . $e->getMessage() );
        }
    }


    // Gets the active player of the game (whose turn it is)
    function getActivePlayer($gameID) {
        try {
            $query_result = dbSelect("SELECT active_player FROM games WHERE games_id = '$gameID';"); // from dbConnect.php
            if (empty($query_result)) {
                return FAILED; //from constants.php
            }
            $result_decoded = decodeSelectFirstResult($query_result)['active_player']; //from decoder.php
            return $result_decoded;
        }
        catch(PDOException $e)
        {
            die ('PDO error in getActivePlayer()": ' . $e->getMessage() );
        }
    }


    // Get the game's password.
    function getGamePassword($gameID) {
        try {
            $query_result = dbSelect("SELECT password FROM games WHERE games_id = '$gameID';"); // from dbConnect.php
            if (empty($query_result)) {
                return FAILED; //from constants.php
            }
            $result_decoded = decodeSelectFirstResult($query_result)['password']; //from decoder.php
            return $result_decoded;
        }
        catch(PDOException $e)
        {
            die ('PDO error in getGamePassword()": ' . $e->getMessage() );
        }
    }


    // Gets both players in the game. Returns them as an array. 
    // Index 0 is player1. Index 1 is player2.
    // Note: player2 will be null if there is only one player
    //       currently in the game.
    function getPlayers($gameID) {
        try {
            $query_result = dbSelect("SELECT player1, player2 FROM games WHERE games_id = '$gameID';"); // from dbConnect.php
            if (empty($query_result)) {
                return FAILED; //from constants.php
            }
            $result_decoded = decodeSelectFirstResult($query_result); //from decoder.php
            $player1 = $result_decoded['player1'];
            $player2 = $result_decoded['player2'];
            $players = [$player1, $player2];
            return $players;
        }
        catch(PDOException $e)
        {
            die ('PDO error in getPlayers()": ' . $e->getMessage() );
        }
    }


    // Given the game ID and a single player ID, it will get the other player
    // that is not the param playerID 
    function getOtherPlayer($gameID, $playerID) {
        try {
            $players = getPlayers($gameID);
            if ($playerID == $players[0]) {
                return $players[1];
            }
            return $players[0];
        }
        catch (PDOException $e){
            die ('PDO error in getOtherPlayer()": ' . $e->getMessage() );
        }
    }


    // Gets the last game of the player ID passed in
    // Specifically, it will get the game ID (games_id), who won (x_won), and if it's a tie (is_tie)
    function getGameWinner($playerID) {
        try {
            $query = "CALL findLastGame('$playerID')";
            $game = dbSelect($query);
            $game_stats = decodeSelectFirstResult($game);

            return $game_stats;
        }
        catch (PDOException $e){
            die ('PDO error in getGameWinner()": ' . $e->getMessage() );
        }
    }


    // Gets the top 10 players for the top_players.php
    // Will get the top 10 players who have the most wins
    function getTopPlayerInfo() {
        try {
            $query = "CALL getTopPlayerInfo()";
            $players = dbSelect($query);

            return $players;
        }
        catch (PDOException $e){
            die ('PDO error in getGameWinner()": ' . $e->getMessage() );
        }
    }


    // Gets all the information for a game (all columns in the Games table)
    // Will be returned as an array.
    function getGameInfo($gameID) {
        try {
            $query_result = dbSelect("SELECT * FROM games WHERE games_id = '$gameID';"); // from dbConnect.php
            if (empty($query_result)) {
                return FAILED; //from constants.php
            }
            $result_decoded = decodeSelectFirstResult($query_result); //from decoder.php
            return $result_decoded;
        }
        catch(PDOException $e)
        {
            die ('PDO error in getGameInfo()": ' . $e->getMessage() );
        }
    }
    // ----------------End Games Table Getters------------------------
?>