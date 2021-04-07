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
            die ('PDO error in ListAllPlayers()": ' . $e->getMessage() );
        }
    }

    function login($dbh) {

    }

    function signup($dbh) {

    }
    
    // Check if the username is inside the database.
    // Return true if it is.
    function validateUsername($dbh) {

    }

    // Check if the password is inside the database.
    // Return true if it is.
    function validatePassword($dbh, $username) {

    }

?>