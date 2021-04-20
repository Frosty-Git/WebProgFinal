<?php
// Start the session
session_start();

// Check if user is not logged in, redirect to login page.
require_once('./scripts/checkLogIn.php');

// Yoink Imports
require_once('./scripts/constants.php');
require_once('./scripts/decoder.php');
require_once('./scripts/dbGameSetupFunct.php');
require_once('./scripts/dbConnect.php');

$dbh = ConnectDB();

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
  <h1>Welcome to the Game Hub!</h1>
  
  <button href="">Create Game</button>
  
  <form method="post">
    <input type="text" name="searchGame">
    <button type="submit">Find Game</button>
  </form>



  <!-- Games List Table -->
  <table>
    <tr>
      <th>Game ID</th> <th>Players</th> <th>User Who Created</th> <th>Date Created</th>
    </tr>
    <?php 
      // Games List Format:
      // Game ID    Players (1/2)   User Who Created   Date Created   Join Button
      
      $results = findAllGames($dbh);
      for ($i = 0; $i < count($results); $i++) {
        $game = decodeSelectResults($results, $i);
        $player_name = getUsername($dbh, $game['player1']);
        echo "<tr>";
        echo "<td>"; print_r($game['games_id']); echo "</td>";
        if ($game['player2'] == null) {
          echo "<td>1/2</td>";
        }
        else {
          echo "<td>2/2</td>";
        }
        echo "<td>"; print_r($player_name); echo "</td>";
        echo "<td>"; print_r($game['date_created']); echo "</td>";
        echo "<td><button>Join</button></td>";
        echo "</tr>";
      }
    
    ?>
  </table>
  <!-- End Games List Table -->
  
  <?php
  echo $_SESSION['user_id'];
  echo "<br>";
  echo $_SESSION['username'];
  ?>
</body>
</html>