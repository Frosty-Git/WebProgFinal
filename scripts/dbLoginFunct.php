<?php 
    require_once('decoder.php');
    require_once("dbConnect.php");

    function login($username, $password) {
        try {
            if (validateUser($username, $password)) {
                return true;
            }
            return false;
        }
        catch (PDOException $e) {
            die ('PDO error in login()": ' . $e->getMessage() );
        }
    }

    function signup($username, $password) {
        try {
            // If the username is already in the database
            if (validateUsername($username)) {
               return false;
            }
            else {
                $player_creation = "INSERT INTO player (username, password, date_created) VALUES ('$username', '$password', now())";
                dbQuery($player_creation);
                return true;
            }
        }
        catch (PDOException $e) {
            die ('PDO error in login()": ' . $e->getMessage() );
        }
    }
    
    // Check if the username is inside the database.
    // Return true if it is.
    function validateUsername($username) {
        try {
            $player_query = "SELECT username FROM player WHERE username='$username'";
            $player_data = dbSelect($player_query);
            
            if(empty($player_data)) {
                return false;
            }
            return true;
        }
        catch(PDOException $e)
        {
            die ('PDO error in validateUsername()": ' . $e->getMessage() );
        }
        
    }

    // Check if the username and password are inside the database.
    // Return true if it is.
    function validateUser($username, $password) {
        try {
            $player_query = "SELECT username, password FROM player WHERE username='$username' AND password='$password'";
            $player_data = dbSelect($player_query);
            
            if(empty($player_data)) {
                return false;
            }
            return true;
        }
        catch(PDOException $e)
        {
            die ('PDO error in validatePassword()": ' . $e->getMessage() );
        }
    }

    function getUserID($username) {
        try {
            $player_query = "SELECT player_id FROM player WHERE username='$username'";
            $player_data = dbSelect($player_query);
            $index = 0;
            $player_data_array = decodeSelectResults($player_data, $index);
            return $player_data_array['player_id'];
        }
        catch(PDOException $e)
        {
            die ('PDO error in getUserID()": ' . $e->getMessage() );
        }
    }

?>