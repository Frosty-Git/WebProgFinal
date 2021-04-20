<?php 
    function makeMove($dbh, $playerID, $gameID, $location, $is_x) {
        try {
            if (validateMove($dbh, $gameID, $location)) {
                $move_creation = "INSERT INTO moves ( location, is_x, player_id, game_id ) 
                                    VALUES ('$location', '$is_x', '$playerID', '$gameID')";
                $update_game_date = "UPDATE games SET date_updated = now() WHERE games_id = '$gameID';";
                dbQuery($dbh, $move_creation);
                dbQuery($dbh, $update_game_date);
                editBoard($dbh, $gameID, $location, $is_x);
                if (checkForWinner($dbh, $gameID, $is_x)) {
                    $update_game = "UPDATE games SET game_ended = 1 WHERE games_id = '$gameID';";
                    dbQuery($dbh, $update_game);
                    return "YOU WON! Congrats";
                }
                return "Move successful! Great job, you son of a bitch";            
            }
            else {
                return "You failed to make a mover loser.";
            }
        }
        catch (PDOException $e){
            die ('PDO error in makeMove()": ' . $e->getMessage() );
        }
    }


    function validateMove($dbh, $gameID, $location) {
        try {
            $select_query = "SELECT location FROM moves WHERE game_id = '$gameID' AND location = '$location';";
            $data = dbSelect($dbh, $select_query);
            if(empty($data)) {
                return true;
            }
            return false;
        }
        catch (PDOException $e) {
            die ('PDO error in validateMove()": ' . $e->getMessage() );
        }
    }

    // The function for player 2 to wait for a move to happen
    function waitForMove($dbh, $gameID, $playerID) {
        try {
            $query = "SELECT moves_id FROM moves WHERE game_id='$gameID' ORDER BY moves_id DESC LIMIT 1;";
            $last_move = dbSelect($dbh, $query)[0];
            $waiting = true;

            while ($waiting) {
                sleep(1);
                $query = "SELECT moves_id FROM moves WHERE game_id='$gameID' AND moves_id>'$last_move';";
                $result = dbSelect($dbh, $query);
                if (!empty($result)) {
                    $waiting = false;
                    // Switch the active player.
                    return "Switched active player.";
                }
            }
        }
        catch (PDOException $e) {
            die ('PDO error in waitForMove()": ' . $e->getMessage() );
        }
    }
    
    // Checks to see if a player has won.
    // params: dbh = the database
    //         gameID = the game's id
    //         is_x = If the player being checked is X or O
    // return: true if the player being checked for won. false if not.
    function checkForWinner($dbh, $gameID, $is_x) {
        try {
            $letter = $is_x ? 'X' : 'O';
            $board = getBoard($dbh, $gameID);
            $found_winner = false;
            
            $a1 = $board["a1"];
            $a2 = $board["a2"];
            $a3 = $board["a3"];
            $b1 = $board["b1"];
            $b2 = $board["b2"];
            $b3 = $board["b3"];
            $c1 = $board["c1"];
            $c2 = $board["c2"];
            $c3 = $board["c3"];

            // 3 Horizontal Checks
            // a1, a2, a3
            if ($a1 == $letter and $a2 == $letter and $a3 == $letter) {
                $found_winner = true;
            }
            // b1, b2, b3
            elseif ($b1 == $letter and $b2 == $letter and $b3 == $letter) {
                $found_winner = true;
            }
            // c1, c2, c3
            elseif ($c1 == $letter and $c2 == $letter and $c3 == $letter) {
                $found_winner = true;
            }
            
            // 3 Vertical Checks
            // a1, b1, c1
            elseif ($a1 == $letter and $b1 == $letter and $c1 == $letter) {
                $found_winner = true;
            }
            // a2, b2, c2
            elseif ($a2 == $letter and $b2 == $letter and $c2 == $letter) {
                $found_winner = true;
            }
            // a3, b3, c3
            elseif ($a3 == $letter and $b3 == $letter and $c3 == $letter) {
                $found_winner = true;
            }
            
            // 2 Diagonal Checks
            // a1, b2, c3
            elseif ($a1 == $letter and $b2 == $letter and $a3 == $letter) {
                $found_winner = true;
            }
            // a3, b2, c1
            elseif ($a3 == $letter and $b2 == $letter and $c1 == $letter) {
                $found_winner = true;
            }
            return $found_winner;
        }
        catch (PDOException $e) {
            die ('PDO error in checkForWinner()": ' . $e->getMessage() );
        }
        
    }

    function endGame($dbh) {

    }

    function editBoard($dbh, $gameID, $location, $is_x) {
        try {
            $update_query = null;
            if($is_x) {
                $update_query = "UPDATE board SET $location = 'X' WHERE game_id = '$gameID';";
            }
            else {
                $update_query = "UPDATE board SET $location = 'O' WHERE game_id = '$gameID';";
            }
            dbQuery($dbh, $update_query);
        }
        catch (PDOException $e) {
            die ('PDO error in drawBoard()": ' . $e->getMessage() );
        }
    }

    function drawBoard($dbh) {

    }

    function getBoard($dbh, $gameID) {
        // Ensures order of the board (in case * doesn't)
        $query = "SELECT a1, a2, a3, b1, b2, b3, c1, c2, c3 FROM board WHERE game_id = '$gameID';";
        $board = dbSelect($dbh, $query);
        return json_decode(json_encode($board[0]),true);
    }

?>