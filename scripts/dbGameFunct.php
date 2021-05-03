<?php

    require_once("dbConnect.php");
    require_once("dbGetters.php");

    // When a player clicks on a box, it will make a move in the game. 
    //  If move is valid, the move will be created in the moves table and update 
    //  the games table on the date and active player.
    //  It will check for if there is a winner and if there is a full board (tie) - returns true
    //  If the move is not valid or the game has not ended - return false
    function makeMove($playerID, $gameID, $location, $is_x) {
        try {
            if (validateMove($gameID, $location)) {
                $move_creation = "INSERT INTO moves ( location, is_x, player_id, game_id ) 
                                    VALUES ('$location', '$is_x', '$playerID', '$gameID')";
                $otherPlayer = getOtherPlayer($gameID, $playerID);
                $update_game = "UPDATE games SET date_updated = now(), active_player = '$otherPlayer' WHERE games_id = '$gameID';";
                dbQuery($move_creation);
                dbQuery($update_game);
                editBoard($gameID, $location, $is_x);
                if (checkForWinner($gameID, $is_x)) {
                    $is_tie = 0;
                    $update_game = "CALL endGame('$playerID','$gameID','$is_x', '$is_tie')";
                    dbQuery($update_game);
                    return true;
                }
                // Check for a full board and if the other player has won to
                // determine a tie.
                elseif (checkFullBoard($gameID) and !(checkForWinner($gameID, !$is_x))) {
                    $is_tie = 1;
                    $update_game = "CALL endGame('$playerID','$gameID','$is_x', '$is_tie')";
                    dbQuery($update_game);
                    return true;
                }
                return false;      
            }
            else {
                return false;
            }
        }
        catch (PDOException $e){
            die ('PDO error in makeMove()": ' . $e->getMessage() );
        }
    }

    // Checks if the location of the move is empty in the board 
    function validateMove($gameID, $location) {
        try {
            $select_query = "SELECT location FROM moves WHERE game_id = '$gameID' AND location = '$location';";
            $data = dbSelect($select_query);
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
    // DO WE STILL NEED THIS?
    function waitForMove($gameID, $playerID) {
        try {
            $query = "SELECT moves_id FROM moves WHERE game_id='$gameID' ORDER BY moves_id DESC LIMIT 1;";
            $last_move = dbSelect($query)[0];
            $waiting = true;

            while ($waiting) {
                sleep(1);
                $query = "SELECT moves_id FROM moves WHERE game_id='$gameID' AND moves_id>'$last_move';";
                $result = dbSelect($query);
                if (!empty($result)) {
                    $waiting = false;
                    // Switch the active player.
                    return true;
                }
            }
        }
        catch (PDOException $e) {
            die ('PDO error in waitForMove()": ' . $e->getMessage() );
        }
    }


    // CHECK PROCESS START PLAYER 2
    // DO WE STILL NEED THIS?
    function player2Start($gameID, $playerID) {
        try {
            $query = "SELECT moves_id FROM moves WHERE game_id='$gameID';";
            $result = dbSelect($query);
            if (!empty($result)) {
                // Switch the active player.
                return true;
            }
            //player2Start($gameID, $playerID);
            return false;
        }
        catch (PDOException $e) {
            die ('PDO error in waitForMove()": ' . $e->getMessage() );
        }
    }

    
    // Checks to see if a player has won.
    // params: gameID = the game's id
    //         is_x = If the player being checked is X or O
    // return: true if the player being checked for won. false if not.
    function checkForWinner($gameID, $is_x) {
        try {
            $letter = $is_x ? 'X' : 'O';
            $board = getBoard($gameID);
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

            //3 Horizontal Checks
            //a1, a2, a3
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
            elseif ($a1 == $letter and $b2 == $letter and $c3 == $letter) {
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

    // Checks if the board has been filled and all the places
    // in the board has a letter in it.
    function checkFullBoard($gameID) {
        try {
            $board = getBoard($gameID);
            $empty = ""; // The empty space symbol on our board
            $result = false;

            $a1 = $board["a1"];
            $a2 = $board["a2"];
            $a3 = $board["a3"];
            $b1 = $board["b1"];
            $b2 = $board["b2"];
            $b3 = $board["b3"];
            $c1 = $board["c1"];
            $c2 = $board["c2"];
            $c3 = $board["c3"];

            if( ($a1 != $empty and $a2 != $empty and $a3 != $empty and
                 $b1 != $empty and $b2 != $empty and $b3 != $empty and
                 $c1 != $empty and $c2 != $empty and $c3 != $empty)) {
                $result = true;
            }

            return $result;
        } 
        catch (PDOException $e) {
            die ('PDO error in checkFullBoard()": ' . $e->getMessage() );
        }
    }

    // --------- CAN WE GET RID OF THESE?? --------
    function checkForTie($gameID) {

    }

    // the pretty pretty thing for makemove's if else shenanigans
    function checkEndGame() {

    }
    
    function endGame($gameID) {

    }

    function drawBoard() {

    }
    // --------------------------------------------


    // Updates the board in the database with the letter of the player at the
    // location of the move. 
    function editBoard($gameID, $location, $is_x) {
        try {
            $update_query = null;
            if($is_x) {
                $update_query = "UPDATE board SET $location = 'X' WHERE game_id = '$gameID';";
            }
            else {
                $update_query = "UPDATE board SET $location = 'O' WHERE game_id = '$gameID';";
            }
            dbQuery($update_query);
        }
        catch (PDOException $e) {
            die ('PDO error in drawBoard()": ' . $e->getMessage() );
        }
    }

    // Returns the whole board as an array
    function getBoard($gameID) {
        // Ensures order of the board (in case * doesn't)
        $query = "SELECT a1, a2, a3, b1, b2, b3, c1, c2, c3 FROM board WHERE game_id = '$gameID';";
        $board = dbSelect($query);
        return json_decode(json_encode($board[0]),true);
    }

    // DO WE STILL NEED THIS? 
    function getEncodedBoard($gameID) {
        // Ensures order of the board (in case * doesn't)
        $query = "SELECT a1, a2, a3, b1, b2, b3, c1, c2, c3 FROM board WHERE game_id = '$gameID';";
        $board = dbSelect($query);
        return json_encode($board[0]);
    }

?>