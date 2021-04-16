<?php 
    
    function createGame($dbh, $playerID) {
        try { 
            // this doesnt work
            $game_creation = "INSERT INTO games (player1, date_created, date_updated ) VALUES ('$playerID', now(), now())";
            dbQuery($dbh, $game_creation);
            
        }
        catch (PDOException $e) {
            die ('PDO error in createGame()": ' . $e->getMessage() );
        }
    }

    function createBoard($dbh, $gameID) {
        try {
            $board_creation = "INSERT INTO board (game_id) VALUES ('$gameID')";
            dbQuery($dbh, $board_creation);
            return "You created a game!";
        }
        catch (PDOException $e) {
            die ('PDO error in createBoard()": ' . $e->getMessage() );
        }
    }

    // Enter in the game id to join your friend's game.
    function findGame($dbh, $gameID) {
        try {
            $games_query = "SELECT games_id, player1, date_created FROM games WHERE games_id='$gameID'";
            $game = dbSelect($dbh, $games_query);

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
    function findOpenGame($dbh) {
        try {
            $games_query = "SELECT games_id, player1, date_created FROM games WHERE is_private=0";
            $games_set = dbSelect($dbh, $games_query);
            if(empty($games_set)) {
                return "No games are open!";
            }
            return $games_set;
        }
        catch (PDOException $e) {
            die ('PDO error in findOpenGame()": ' . $e->getMessage() );
        }
    }

    // The second playing joining the game that they found.
    function joinGame($dbh, $gameID, $playerID) {
        try {
            // Check if the game is full
            $games_query = "SELECT games_id FROM games WHERE games_id='$gameID' AND player2 IS NULL" ;
            $games_set = dbSelect($dbh, $games_query);
            if(empty($games_set)) {
                return "This game is full!";
            }
            $update_query = "UPDATE games SET player2 = '$playerID' WHERE games_id = '$gameID';";
            dbQuery($dbh, $update_query);
            return "You joined the game!";
        }
        catch (PDOException $e) {
            die ('PDO error in joinGame()": ' . $e->getMessage() );
        }
    }

    function startGame($dbh, $gameID) {
        
    }

    function cancelGame($dbh, $gameID) {
        try {
            $delete_query = "DELETE FROM games WHERE games_id = '$gameID';";
            dbQuery($dbh, $update_query);
            return "GAME OVER";
        }
        catch (PDOException $e) {
            die ('PDO error in cancelGame()": ' . $e->getMessage() );
        }
    }
?>