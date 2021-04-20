<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
require_once('./scripts/dbConnect.php');
require_once('./scripts/dbLoginFunct.php');
$dbh = ConnectDB();

echo "<form action='./processLogin.php' method='post'>
    <fieldset>
    <legend>Login</legend>
    <table>
        <tr>
            <td> Type in your username: </td>
            <td> <input name='username' type='text' /> </td>
        </tr>
        <tr>
            <td> Type in your password: </td>
            <td> <input name='password' type='password' /> </td>
        </tr>
    </table>
    </fieldset>
    <p>
        <input type='submit' />
    </p>
    </form>";

// if (isset($_POST['submit']))
// {
//     echo "<p>";
//     echo $_POST['username'];
//     echo $_POST['password'];
//     echo "</p>";
//     if (login($dbh, $_POST['username'], $_POST['password'])) {
//         $_SESSION["user_id"] = getUserID($dbh, $_POST['username']);
//         $_SESSION["username"] = $_POST['username'];
//         header('Location: gamehub.php');
//     }
//     //bad login
// }
?>
</body>
</html>