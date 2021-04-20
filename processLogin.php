<?php
// process.php

session_start();

require_once('./scripts/dbConnect.php');
require_once('./scripts/dbLoginFunct.php');
$dbh = ConnectDB();




echo "Welcome, " . $_POST["username"] . ". <br />";
echo "Session ID is: '" . htmlspecialchars(session_id()) . "' <br />";

echo "<p>";
echo $_POST['username'];
echo "<br>";
echo $_POST['password'];
echo "</p>";
echo "<br>";
if (login($dbh, $_POST['username'], $_POST['password'])) {
    echo "<h4>Login Succeeded!</h4>";
    $_SESSION["user_id"] = getUserID($dbh, $_POST['username']);
    $_SESSION["username"] = $_POST['username'];
}
else {
    echo "<h4>Login Failed. Incorrect Username or Password.</h4>";
}

?>

<p>
Here's the session information:
</p>
<p>
    Here's the SID:
    <?php echo session_id(); ?> <br />
    Here's the raw session info:
    <pre>
        <?php print_r($_SESSION); ?>
    </pre>
</p>



<p>
This session started at:
<?php
echo date('Y m d H:i:s', $_SESSION['time']);
?>
</p>

<p>
Here's the SID:
<?php echo session_id(); ?> <br />
Here's the raw session info:
<pre>
<?php print_r($_SESSION); ?>
</pre>
</p>
