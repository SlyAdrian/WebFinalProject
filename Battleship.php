<html>
    <head>
        <link rel="stylesheet" type="text/css" href="styles.css">
		<meta charset="utf-8">
		<title>S2 Battleship !</title> 
    </head>
    <header class = "header">
    <div class = content>
      <img src="/images/LogoBTSH.jpg" width = 215px class = "logo">
      <nav>
        <ul>
          <li><a href = "index.php">
            Go Back
          </a></li>
          <li>  
            <form action="Battleship.php" method="POST">
              <input type = "submit" name = "ApplyBtn" value = "Apply">
              <?php 
                include('form.php');
              ?>
          </form>
          </li>
          <li>
            <form action="Battleship.php" method="POST">
              <input type = "submit" name = "LeaveBtn" value = "Leave">
            </form>
          </li> 
        </ul>
      </nav>
    </div>
  </header>

    <body class = "bodyBTSH">
        <div>
            <FONT size="5">
            <p>Battleship is a strategy type guessing game for two players. It is played on ruled grids on which each player's fleet of ships are marked. The locations of the fleets are concealed from the other player. 
                Players alternate turns calling "shots" at the other player's ships, and the objective of the game is to destroy the opposing player's fleet. </p>
                <img src="/images/BattleshipEx.png" class = "center">
        </div>
        <div>
            <h2><b>Task</b></h2>
            <p>Your task is to implement web-based Battleship game.</p>
            <p><b>How we imagine the application ?</b></p>
            <p>1. Player 1 enters on our game page. It clicks button "Create game" and receives a game ID (for example mO1C4RbNWeR) or link 
                to the game (for example battleship.herokuapp.com/mO1C4RbNWeR) from the server.</p>
            <p>2. Player 1 sends the link to the game to Player 2 (using their favourite communication channel like discord or messenger) and the game can be started. </p>
            <p>3. During game initialisation the server needs to randomly place the ships on the players' boards. 
                We assume that the server randomly selects from a list of predefined layouts.</p>
            <p>4. The game itself can be implemented using basic form (buttons represent fields on the boards).</p>
            <p>5. The logic of the game is controlled by server. This means that after clicking a wrong button server responds with an error. </p>
            <p>6. In the most simple version of the game players need to refresh the web page to see if something changed in the game status. 
                For keeping game status you should use database. </p>
            <p>7. In more advanced game version you should use REST services with Vue.js on the frontend</p>
        </div>
        </FONT>
    </body>
    
</html>