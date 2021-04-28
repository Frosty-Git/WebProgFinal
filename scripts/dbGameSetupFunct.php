<?php 
    require_once("dbConnect.php");
    require_once("decoder.php");
    
    function createGame($playerID, $is_private, $password) {
        try { 
            // this doesnt work
            $game_creation = "CALL createGame('$playerID', '$is_private', '$password')";
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

    // Finds the game id if you have the player id.
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

    function checkGamePassword($gameID, $password) {
        try {
            $games_query = "SELECT password FROM games WHERE games_id='$gameID'" ;
            $games_set = dbSelect($games_query);
            $gamePassword = decodeSelectFirstResult($games_set)['password'];

            if($password == $gamePassword) {
                return true;
            }
            return false;
        }
        catch (PDOException $e) {
            die ('PDO error in checkGamePassword()": ' . $e->getMessage() );
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
    
?>