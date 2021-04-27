<?php 
    session_start();

    require_once(__DIR__.'/scripts/dbConnect.php');
    require_once(__DIR__.'/scripts/decoder.php');
?>

<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>
<head>
<title>Games!</title>
  <meta charset='utf-8' />
  <meta name='Author' content='Joseph Frost, Katie Lee, Marc Colin, Jacelynn Duranceau' />
  <meta name='generator' content='VS Code' />
  <link rel='shortcut icon' href='' />
</head>
<body>

    <h1>Get Ready for Your High Velocity Gaming Experience</h1>
    
    <?php 
        echo '<br><p>game_id: </p>';
        echo $_SESSION['game_id'];
        echo '<br><p>user_id: </p>';
        echo $_SESSION['user_id'];
        echo '<br><p>username: </p>';
        echo $_SESSION['username']; 

        $gameID = $_SESSION['game_id'];
        $private = dbSelect("SELECT is_private FROM games WHERE games_id = '$gameID';");
        $private_decoded = decodeSelectFirstResult($private)['is_private'];

        echo "<p>Game is private: "; 
        echo $private_decoded;
        echo "</p>";
    ?>

    <!-- Only clickable for the host -->
    <button>Start</button>

    <!-- People can join this -->
    <button>Leave</button>
    
</body>
</html>