<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <title> Games! </title>
  <meta charset="utf-8" />
  <meta name="Author" content="Joseph Frost, Katie Lee, Marc Colin, Jacelynn Duranceau" />
  <meta name="generator" content="VS Code" />
  <link rel="shortcut icon" href="" />
  <style>
    a { text-decoration: none; }
    a:hover { text-decoration: underline; }
  </style>
</head>

<body>
<h1>Hello</h1>
<?php 

  require_once('./dbConnect.php');
  require_once('./dbGameFunct.php');
  require_once('./dbLoginFunct.php');
  $dbh = ConnectDB();

  $playerlist = ListAllPlayers($dbh);

  $counter = 0;
  echo "<ul>\n";
  foreach ( $playerlist as $player ) {
    $counter++;
    echo "    <li> $player->username</li>\n";
  }
  echo "</ul>\n";
  echo "<p> $counter record(s) returned.<p>\n";

  // Debugging
  echo '<pre>'; print_r($playerlist); echo '</pre>';

  $found = signup($dbh, "pizza", "password1");
  echo '<p> signup test:'; print_r($found); echo '</p>';

  $found = login($dbh, "potato", "password");
  echo '<p> login test:'; print_r($found); echo '</p>';

?> 

  <footer style="border-top: 1px solid blue">
  <a href="http://elvis.rowan.edu/~frostj16/" 
    title="Link to my home page">
    Joe, Katie, Marc, Jacelynn
  </a>

  <span style="float: right;">
  <a href="http://validator.w3.org/check/referer">HTML5</a> /
  <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">
      CSS3 </a>
  </span>
  </footer>

</body>
</html>
