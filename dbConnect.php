<?php 

  function ConnectDB() {

    /*** mysql server info ***/
    $hostname = 'elvis.rowan.edu';
    $username = 'colinm36';
    $password = '1Nicepenguin!';
    $dbname   = 'colinm36';

    try {
        $dbh = new PDO("mysql:host=$hostname;dbname=$dbname",
                      $username, $password);
    } catch(PDOException $e) {
        die ('PDO error in "ConnectDB()": ' . $e->getMessage() );
    }

    return $dbh;
  }

?> 