<?php 
    session_start();

    require_once('./scripts/dbGetters.php');
    $gameID = $_SESSION['game_id'];
    $player1 = getPlayer1($gameID);
    $player2 = getPlayer2($gameID);
    if ($_SESSION['user_id'] ==  $player1) {
        $_SESSION['character'] = 'X';
    }
    elseif ($_SESSION['user_id'] == $player2) {
        $_SESSION['character'] = 'O';
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
		  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
		  crossorigin="anonymous"></script>
</head>
<body>

<div class="container-out">
    <div class="container-in">
    <div class="table-container">
        <p id="yourturn">Your turn</p>
        <table align="center">
        <tr>
            <td><div class="box" id="a1" value="a1"></div></td>
            <td><div class="box" id="a2" value="a2"></div></td>
            <td><div class="box" id="a3" value="a3"></div></td>
        </tr>
        <tr>
            <td><div class="box" id="b1" value="b1"></div></td>
            <td><div class="box" id="b2" value="b2"></div></td>
            <td><div class="box" id="b3" value="b3"></div></td>
        </tr>
        <tr>
            <td><div class="box" id="c1" value="c1"></div></td>
            <td><div class="box" id="c2" value="c2"></div></td>
            <td><div class="box" id="c3" value="c3"></div></td>
        </tr>
        </table>

        <h2 id="message">Player <span id="winner"></span> Wins</h2>
    </div>
    </div>
</div>

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
                $.ajax({
                    type: 'POST',
                    url: './scripts/forms/processMove.php', // needs to be made
                    async: false,
                    data: {
                        location: location,
                    },
                    success: function(json) {
                        $('#a1').html(json['a1']);
                        $('#a2').html(json['a2']);
                        $('#a3').html(json['a3']);
                        $('#b1').html(json['b1']);
                        $('#b2').html(json['b2']);
                        $('#b3').html(json['b3']);
                        $('#c1').html(json['c1']);
                        $('#c2').html(json['c2']);
                        $('#c3').html(json['c3']);
                        $('#yourturn').show();
                    }
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