<?php 
    require_once("dbConnect.php");
    require_once("decoder.php");
    require_once("contants.php");
    
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
            die ('PDO error in getPlayer1()": ' . $e->getMessage() );
        }
    }

    // ----------------End Games Table Getters------------------------



    // ------------------Board Table Getters--------------------------

    // ----------------End Board Table Getters------------------------


    
    // ------------------Moves Table Getters--------------------------

    // ----------------End Moves Table Getters------------------------

?>