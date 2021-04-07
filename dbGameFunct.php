<?php 
    // Remove this later.
    function ListAllPlayers($dbh) {
        try {
            $player_query = "SELECT username FROM player";
            $stmt = $dbh->prepare($player_query);
            $stmt->execute();
            $playerdata = $stmt->fetchAll(PDO::FETCH_OBJ);
            $stmt = null;
            return $playerdata;
        }
        catch(PDOException $e)
        {
            die ('PDO error in ListAllPhones()": ' . $e->getMessage() );
        }
    }

    
    function makeMove($dbh) {
        
    }


    function validateMove($dbh) {
        
    }

    // The function for player 2 to wait for a move to happen
    function waitForMove($dbh) {
        
    }
    
    function endGame($dbh) {

    }

?>