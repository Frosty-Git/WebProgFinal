<?php 
    session_start();

    require_once(__DIR__.'/scripts/dbGetters.php');
    require_once(__DIR__.'/scripts/dbGameFunct.php');

    header('Refresh:5');

    if (getIsEnded($_SESSION['game_id'])) {
        header('Location: gamehub.php');
    }
?>


<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>
<head>
<title>Games!</title>
  <meta charset='utf-8' />
  <meta name='Author' content='Joseph Frost, Katie Lee, Marc Colin, Jacelynn Duranceau' />
  <meta name='generator' content='VS Code' />
  <link rel='shortcut icon' href='' />
  <link rel="stylesheet" href="./css/tic-tac-toe.css">
  <link rel="stylesheet" href="./css/base.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
		  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
		  crossorigin="anonymous"></script>
</head>
<body>



<?php
//--------------Session Info Prints --- DELETE LATER--------------
     echo '<p>game_id: ';
     echo $_SESSION['game_id'];
     echo "</p>";
     echo '<p>user_id: ';
     echo $_SESSION['user_id'];
     echo "</p>";
     echo '<p>username: ';
     echo $_SESSION['username']; 
     echo "</p>";
     echo "<p>Character: "; 
     echo $_SESSION['character'];
     echo "</p>";
     echo "<p>Active: "; 
     echo $_SESSION['active'];
     echo "</p>";

     //---------- End Session Info Prints -----------------------------
?>





<div class="container-out">
    <div class="container-in">
    <div class="table-container">
        <?php
        if($_SESSION['active']) {
            echo '<p id="yourturn">';
            echo $_SESSION['character'];
            echo "'s Turn</p>";
        }
        ?>
        <table align="center">

        <?php

        
            $board = getBoard($_SESSION['game_id']);
            echo "<tr>";
            echo "<td><div class='box' id='a1' value='a1'>"; echo $board['a1']; echo "</div></td>";
            echo "<td><div class='box' id='a2' value='a2'>"; echo $board['a2']; echo "</div></td>";
            echo "<td><div class='box' id='a3' value='a3'>"; echo $board['a3']; echo "</div></td>";
            echo "</tr>";
            
            echo "<tr>";
            echo "<td><div class='box' id='b1' value='b1'>"; echo $board['b1']; echo "</div></td>";
            echo "<td><div class='box' id='b2' value='b2'>"; echo $board['b2']; echo "</div></td>";
            echo "<td><div class='box' id='b3' value='b3'>"; echo $board['b3']; echo "</div></td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td><div class='box' id='c1' value='c1'>"; echo $board['c1']; echo "</div></td>";
            echo "<td><div class='box' id='c2' value='c2'>"; echo $board['c2']; echo "</div></td>";
            echo "<td><div class='box' id='c3' value='c3'>"; echo $board['c3']; echo "</div></td>";
            echo "</tr>";
        ?> 

        </table>

        <h2 id="message">Player <span id="winner"></span> Wins</h2>
    </div>
    </div>
</div>
<?php
        // End Game Button: For Host, ends game.
        echo '<form action="./scripts/forms/processCancelGame.php">
                <input type="submit" value="Cancel Game">
            </form>';
    
?>
<!-- used to fill in box, check for winner, and switch players -->
<script type="text/javascript">
    
    const boxes = document.getElementsByClassName("box");
    for(let i = 0; i < boxes.length; i++) {
        boxes[i].addEventListener("click", function(){
            let location = boxes[i].getAttribute('value');
            if (boxes[i].innerHTML.trim() == "") {
                $('#yourturn').hide();
                let letter = "<?php echo $_SESSION['character']; ?>";
                boxes[i].innerHTML = letter;
                let gameID = "<?php echo $_SESSION['game_id']; ?>";
                $.ajax({
                    type: 'POST',
                    url: './scripts/forms/processMove.php', // needs to be made
                    data: {
                        location: location,
                        game_id: gameID,
                    },                  
                });
            }
            else {
                // pick another box
            }      
        });
    }
</script>

</body>
</html>