<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>
<head>
  <title> Games! </title>
  <meta charset='utf-8' />
  <meta name='Author' content='Joseph Frost, Katie Lee, Marc Colin, Jacelynn Duranceau' />
  <meta name='generator' content='VS Code' />
  <link rel='shortcut icon' href='' />
  <style>
    a { text-decoration: none; }
    a:hover { text-decoration: underline; }
  </style>
</head>

<body>
<h1>Welcome to the Game Hub!</h1>
<p>You are now logged in!</p>

<?php
echo $_SESSION['user_id'];
echo "<br>";
echo $_SESSION['username'];
?>
</body>
</html>

