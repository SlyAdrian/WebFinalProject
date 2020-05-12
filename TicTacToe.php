
<?php
/* // Afficher un cookie
echo $_COOKIE["Cookie"];
 */
// Afficher un cookie
echo $_COOKIE["Cookie"];

?>

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="styles.css">
		<meta charset="utf-8">
		<title>S1 Tic Tac Toe !</title> 
  </head>

  <header class = "header">
    <div class = content>
      <img src="/images/LogoTTT.jpg" width = 215px class = "logo">
      <nav>
        <ul>
          <li><a href = "index.php">
            Go Back
          </a></li>
          <li>  
            <form action="TicTacToe.php" method="POST">
              <input type = "submit" name = "ApplyBtn" value = "Apply">
              <?php 
                include('form.php');
              ?>
          </form>
          </li>
          <li>
            <form action="TicTacToe.php" method="POST">
              <input type = "submit" name = "LeaveBtn" value = "Leave">
            </form>
          </li> 
        </ul>
      </nav>
    </div>
  </header>

  <body class = "bodyTTT">
    <div>
      <Font size="5">
        <p>Tic-tac-toe is a paper-and-pencil game for two players, X and O, who take turns marking the spaces in a 3×3 grid. The player who succeeds in placing three of their marks in a horizontal, vertical, or diagonal row is the winner.</p>
        <p>The following example game is won by the first player, O : </p>
      <br>
      <img src="images/TicTacToeEx.png"/ class = "center">
    </div>
    <div>
      <h2><b>Task</b></h2>
      <p>Your task is to implement web-based Tic Tac Toe game.</p>
      <p><b>How we imagine the application ?</b></p>
      <p>1. Users enters a page. He enters his name and surname. He can see a list of available topics with the number of available team slots in the given topic.</p>
      <p>Example :  </p> 
      <p class = "textCenter">Topic 1 (3 available team slots)</p>
      <p class = "textCenter">Topic 2 (1 available team slot)</p>
      <p class = "textCenter">Topic 3 (0 available team slots)</p>
      
      <p>2. The maximum number of team slots per topic is set in the configuration file</p>
      <p>3. User can click on the topic (using a link or button) and he is redirected to the description of the topic and where he can:</p>
      <p class = "textCenter">I. Apply for the given topic</p>
      <p class = "textCenter">II. Go back to the list of topics</p>
      <p class = "textCenter">II. Leave the topic if he had previously applied for it</p>
      <p>4. If the user applies for the topic he can add the names of its team members</p>
      <p>5. The team members can also apply for the topic on their own - in the topic details,
         they can see the list of teams and they can join a team (however the maximum size of the team is 3!)</p>
      <p>6. Everything is controlled by server. This means that if the user clicks on the button to apply for the topic 
        and some other user did it meanwhile (was faster) the server responds with an error if the limit is exceeded. </p>
      <p>7. Everything should be kept in database.</p>
      <p>8. In more advanced version you should use REST services with Vue.js on the frontend</p>
      </FONT>
    </div>

  </body>
</html>