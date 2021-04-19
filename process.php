<?php
// process.php

session_start();

echo "Sorry, " . $_POST["name"] . ". <br />";
echo "We're out of " . $_POST["icecream"] . " ice cream.<br />";

echo "Session ID is: '" . htmlspecialchars(session_id()) . "' <br />";

?>

<p>
Here's the session information:
</p>

<dl>
   <dt> favcolor: </dt>
       <dd> <?php echo $_SESSION['favcolor']; ?> </dd>
   <dt> animal: </dt>
       <dd> <?php echo $_SESSION['animal']; ?> </dd>
</dl>

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
