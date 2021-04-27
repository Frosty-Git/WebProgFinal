<?php 
    session_start();
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
</head>
<body>

<div class="container-out">
    <div class="container-in">
    <div class="table-container">
        <p>Player <span id="player">X</span> your turn</p>
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
    $(document).ready(function(){
        function checkBox() {
            $(".box").click(function(){
              let selected_box = $(this).val();
              $.ajax({
                  type: 'POST',
                  url: 'script.php', // needs to be made
                  data: {
                      selected_box: selected_box
                  }
                  success: function(data) {
                      alert(data);
                      $("p").text(data);
                  }
              });
          });
        }
        checkBox.done(function(data)){
          // switch players
        }
    });
</script>

</body>
</html>