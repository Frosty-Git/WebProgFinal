<?php 

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


?>