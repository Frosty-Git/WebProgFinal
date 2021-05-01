<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <title>Tic-Tac-Toe | Home</title>
  <meta charset="utf-8" />
  <meta name="Author" content="Joseph Frost, Katie Lee, Marc Colin, Jacelynn Duranceau" />
  <meta name="generator" content="VS Code" />
  <link rel="shortcut icon" href="#" />
  <link rel="stylesheet" href="./css/base.css">
</head>

<body>
<div class="centerDiv">
  <h1><span style="color: #FC4A1A">Tic</span><span style="color: #4ABDAC">-</span><span style="color: #FC4A1A">Tac</span><span style="color: #4ABDAC">-</span><span style="color: #FC4A1A">Toe</span></h1>
    <form action="login.php" class="inlineForm">
      <input type="submit" value="Login Here!" class="button2">
    </form>
    <form action="signup.php" class="inlineForm">
      <input type="submit" value="Sign Up Here!" class="button">
    </form>
    <form action="top_players.php" class="inlineForm">
      <input type="submit" value="See Top Players Here!" class="button2">
    </form>
  <!-- <a href="login.php" class="nostyle"><button class="button2">Login Here!</button></a>&nbsp;
  <a href="signup.php" class="nostyle"><button class="button">Sign Up Here!</button></a>&nbsp;
  <a href="top_players.php" class="nostyle"><button class="button2">See Top Players Here!</button></a> -->
  <p></p> 
  <!-- ^ Wanted a gap between the footer but a line break wouldn't do it -->
</div>





<?php
// require_once('./scripts/dbGameSetupFunct.php');


// $playerID = 8;
// $gameID = 25;

// $update_query = "UPDATE games SET player2 = '$playerID' WHERE games_id = '$gameID';";
// dbQuery($update_query);

?>







  <footer style="border-top: 1px solid #FC4A1A">
  <a href="http://elvis.rowan.edu/~frostj16/" 
    title="Joe's Home Page">
    Joe
  </a>, 
  <a href="http://elvis.rowan.edu/~leekat32/" 
    title="Katie's Home Page">
    Katie
  </a>, 
  <a href="http://elvis.rowan.edu/~colinm36/" 
    title="Marc's Home Page">
    Marc
  </a>& 
  <a href="http://elvis.rowan.edu/~duranceaj3/" 
    title="Jacelynn's Home Page">
    Jacelynn
  </a>

  <span style="float: right;">
  <a href="http://validator.w3.org/check/referer">HTML5</a> /
  <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">
      CSS3 </a>
  </span>
  </footer>

</body>
</html>
