<?php
// Start the session
session_start();

// Yoink imports
require_once('./scripts/dbConnect.php');
require_once('./scripts/dbLoginFunct.php');

$dbh = ConnectDB();




// -----------Unnecessary Testing Text. DELETE LATER------------------
echo "Welcome, " . $_POST["username"] . ". <br />";
echo "Session ID is: '" . htmlspecialchars(session_id()) . "' <br />";
echo "<p>";
echo $_POST['username'];
echo "<br>";
echo $_POST['password'];
echo "</p>";
// -------------------- End Test Text --------------------------------




// ---------- Login Validation and Session Setting -------------------
if (login($dbh, $_POST['username'], $_POST['password'])) {
    echo "<h4>Login Succeeded!</h4>";
    $_SESSION["user_id"] = getUserID($dbh, $_POST['username']);
    $_SESSION["username"] = $_POST['username'];
    header('Location: gamehub.php');
}
else {
    echo "<h4>Login Failed. Incorrect Username or Password.</h4>";
    $_SESSION["user_id"] = -1;
    $_SESSION["username"] = "fail_login";
    header('Location: login.php');
}
// ---------- End Login Validation and Session Setting ---------------
?>




<!---------------- Session Test Text -------------------------------->
<h3>
Here's the session information:
</h3>

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
<!------------- End Session Test Text ------------------------------->