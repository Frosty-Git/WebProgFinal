<?php 
    require_once('decoder.php');
    require_once("dbConnect.php");
    require_once("dbGetters.php");

    // Checks if the input username and password correctly match a 
    // user in the db.
    // Returns true if they are correct.
    // Returns false if they are incorrect.
    function login($username, $password) {
        return verifyPassword($username, $password);
    }

    function signup($username, $password) {
        try {
            // If the username is already in the database
            if (validateUsername($username)) {
               return false;
            }
            else {
                $pwd_hashed = encodePassword($password);
                $player_creation = "INSERT INTO player (username, password, date_created) VALUES ('$username', '$pwd_hashed', now())";
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
            if(empty($player_data)) { // valid to sign up
                // This prevents a user from being able to call the process 
                // signup script by typing it in the url, thus they cannot create
                // infinite empty credential users.
                if(empty($username)) // also check isset and null
                {
                    return true; // as if a user already exists to prevent sign up from occurring
                }
                return false;
            }
            return true; // username is already inside the database
        }
        catch(PDOException $e)
        {
            die ('PDO error in validateUsername()": ' . $e->getMessage() );
        }
        
    }

    // Check if the username and password are inside the database.
    // Return true if it is.
    // --------------------DEPRECATED---------------------------------
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

    // Get's the user's id from the database.
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

    // Uses PHP's hash password function to store a hashed with salt 
    // version of the password to be stored in the database.
    function encodePassword($password) {
        return password_hash($password, PASSWORD_ARGON2ID);
    }

    // Uses PHP's password verification to verify the input password 
    // with the password stored in the database.
    // Returns true if the password is correct.
    // Returns false if the password is incorrect.
    function verifyPassword($username, $password) {
        $result = false;
        $pwd_hashed = getPassword($username);
        if (password_verify($password, $pwd_hashed)) {
            $result = true;
        }
        return $result;
    }

    function confirmPassword($password1, $password2) {
        try {
            if($password1 === $password2) {
                return true; // Passwords match
            }
            return false; // Passwords do not match
        }
        catch(PDOException $e)
        {
            die ('PDO error in validatePassword()": ' . $e->getMessage() );
        }
    }

    // This will be called after confirmPassword is called, so 
    // it only needs one password to check the length
    function checkPasswordLength($password) {
        try {
            if (strlen($password) > 6) {
                return true;
            }
            return false; // Passwords match, but are too short
        }
        catch(PDOException $e)
        {
            die ('PDO error in validatePassword()": ' . $e->getMessage() );
        }
    }

?>