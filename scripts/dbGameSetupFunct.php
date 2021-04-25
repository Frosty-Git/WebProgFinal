<?php 
    require_once("dbConnect.php");
    
    function createGame($playerID) {
        try { 
            // this doesnt work
            $game_creation = "CALL createGame('$playerID')";
            dbQuery($game_creation);
            
        }
        catch (PDOException $e) {
            die ('PDO error in createGame()": ' . $e->getMessage() );
        }
    }

    function createBoard($gameID) {
        try {
            $board_creation = "INSERT INTO board (game_id) VALUES ('$gameID')";
            dbQuery($board_creation);
            return "You created a game!";
        }
        catch (PDOException $e) {
            die ('PDO error in createBoard()": ' . $e->getMessage() );
        }
    }

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

    // The second playing joining the game that they found.
    function joinGame($gameID, $playerID) {
        try {
            // Check if the game is full
            $games_query = "SELECT games_id FROM games WHERE games_id='$gameID' AND player2 IS NULL" ;
            $games_set = dbSelect($games_query);
            if(empty($games_set)) {
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

    function startGame($gameID) {
        
    }

    function cancelGame($gameID) {
        try {
            $delete_query = "CALL deleteGame('$gameID');";
            dbQuery($delete_query);
            return "GAME OVER";
        }
        catch (PDOException $e) {
            die ('PDO error in cancelGame()": ' . $e->getMessage() );
        }
    }

    function getUsername($playerID) {
        try {
            $player_query = "SELECT username FROM player WHERE player_id='$playerID'";
            $player_data = dbSelect($player_query);
            $index = 0;
            $player_data_array = decodeSelectResults($player_data, $index);
            return $player_data_array['username'];
        }
        catch(PDOException $e)
        {
            die ('PDO error in getUserID()": ' . $e->getMessage() );
        }
    }
    
?>