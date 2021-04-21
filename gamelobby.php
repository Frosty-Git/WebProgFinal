<?php 
    session_start();
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
    ?>

    <!-- Only clickable for the host -->
    <button>Start</button>

    <!-- People can join this -->
    <button>Leave</button>

    <!-- Only clickable for the host -->
    <input type="checkbox" id="check">
    <label for="check">Private?</label>
    
</body>
</html>