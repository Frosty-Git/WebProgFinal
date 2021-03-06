<?php 
    session_start();

    require_once(__DIR__.'/scripts/dbGetters.php');
    require_once(__DIR__.'/scripts/dbGameFunct.php');
    
?>


<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>
<head>
<title>Tic-Tac-Toe | Game</title>
  <meta charset='utf-8' />
  <meta name='Author' content='Joseph Frost, Katie Lee, Marc Colin, Jacelynn Duranceau' />
  <meta name='generator' content='VS Code' />
  <link rel='shortcut icon' href='#' />
  <link rel="stylesheet" href="./css/tic-tac-toe.css">
  <link rel="stylesheet" href="./css/base.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
		  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
		  crossorigin="anonymous"></script>
</head>
<body>

<div class="centerDiv">
    <h1><span style="color: #FC4A1A">Tic</span><span style="color: #4ABDAC">-</span><span style="color: #FC4A1A">Tac</span><span style="color: #4ABDAC">-</span><span style="color: #FC4A1A">Toe</span></h1>
</div>

<div class="container-out">
    <div class="container-in">
    <div class="table-container">
        <?php
            echo '<p id="yourturn" style="color:#4ABDAC; font-size: 125%; font-style: oblique;">Your Turn</p>';
            echo '<table class="centerDiv">';


            $board = getBoard($_SESSION['game_id']);

            if ($_SESSION['active']) { // Starting board for active player
                echo "<tr>";
                echo "<td><div class='box' id='a1'>"; echo $board['a1']; echo "</div></td>";
                echo "<td><div class='box' id='a2'>"; echo $board['a2']; echo "</div></td>";
                echo "<td><div class='box' id='a3'>"; echo $board['a3']; echo "</div></td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td><div class='box' id='b1'>"; echo $board['b1']; echo "</div></td>";
                echo "<td><div class='box' id='b2'>"; echo $board['b2']; echo "</div></td>";
                echo "<td><div class='box' id='b3'>"; echo $board['b3']; echo "</div></td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td><div class='box' id='c1'>"; echo $board['c1']; echo "</div></td>";
                echo "<td><div class='box' id='c2'>"; echo $board['c2']; echo "</div></td>";
                echo "<td><div class='box' id='c3'>"; echo $board['c3']; echo "</div></td>";
                echo "</tr>";
            }
            else { // Starting board for inactive player
                echo "<tr>";
                echo "<td><div class='box disabled' id='a1'>"; echo $board['a1']; echo "</div></td>";
                echo "<td><div class='box disabled' id='a2'>"; echo $board['a2']; echo "</div></td>";
                echo "<td><div class='box disabled' id='a3'>"; echo $board['a3']; echo "</div></td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td><div class='box disabled' id='b1'>"; echo $board['b1']; echo "</div></td>";
                echo "<td><div class='box disabled' id='b2'>"; echo $board['b2']; echo "</div></td>";
                echo "<td><div class='box disabled' id='b3'>"; echo $board['b3']; echo "</div></td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td><div class='box disabled' id='c1'>"; echo $board['c1']; echo "</div></td>";
                echo "<td><div class='box disabled' id='c2'>"; echo $board['c2']; echo "</div></td>";
                echo "<td><div class='box disabled' id='c3'>"; echo $board['c3']; echo "</div></td>";
                echo "</tr>";
            }
            
        ?> 

        </table>

        <h2 id="message">Player <span id="winner"></span> Wins</h2>
    </div>
    </div>
</div>

<!-- used to fill in box, check for winner, and switch players -->
<script>
    $(document).ready(function() {
        $('.disabled').attr("disabled", "disabled"); // Sets the board to be disabled if it is not the active user
        update();
    });

    // Gets the board and checks if a person made a move 
    // or the game ended every second.
    // This will recursively get called until the game has ended.
    function update() {
        $.ajax({
            type:"GET",
            url: "./scripts/forms/processBoardUpdate.php", 
            dataType: 'json',
            success: function(res){
                $('#a1').html(res.a1); 
                $('#a2').html(res.a2); 
                $('#a3').html(res.a3); 
                $('#b1').html(res.b1); 
                $('#b2').html(res.b2); 
                $('#b3').html(res.b3); 
                $('#c1').html(res.c1); 
                $('#c2').html(res.c2); 
                $('#c3').html(res.c3);
            }
        });

        $.get("./scripts/forms/processActivePlayer.php", function(data) {
            // 2 is if the game is ended
            if (data == 2) {
                window.location = "gameover.php";
            }
            if ((data == 1) || (data == '')) {
                // 1 is true, you are the active player
                if (data == 1) {
                    $('.disabled').removeClass('disabled');
                    $('.disabled').attr("disabled", false);
                    $('#yourturn').show();
                }

                // '' is false, you are not the active player
                else if (data == '') {
                    $('.box').attr("disabled", "disabled");
                    $('.box').addClass('disabled');
                    $('#yourturn').hide();
                }
                window.setTimeout(update, 1000);
            }
        });
    }
    
    // This is for when a user clicks on a box, it makes a move
    // in the database by giving it the location and the game ID. 
    const boxes = document.getElementsByClassName("box");
    for(let i = 0; i < boxes.length; i++) {
        boxes[i].addEventListener("click", function(){
            let location = boxes[i].id;
            if (boxes[i].innerHTML.trim() == "") {
                $('#yourturn').hide();
                let letter = "<?php echo $_SESSION['character']; ?>";
                boxes[i].innerHTML = letter;
                let gameID = "<?php echo $_SESSION['game_id']; ?>";
                $.ajax({
                    type: 'POST',
                    url: './scripts/forms/processMove.php', 
                    data: {
                        location: location,
                        game_id: gameID,
                    },                  
                });
            }   
        });
    }
</script>


</body>
</html>