<html>
  <head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <meta charset="utf-8">
    <title>S3 Wheel Of Fortune !</title> 
  </head>
  <header class = "header">
    <div class = content>
      <img src="/images/LogoWOF.jpg" width = 105px class = "logo">
      <nav>
        <ul>
          <li><a href = "index.php">
            Go Back
          </a></li>
          <li>  
            <form action="WheelOfFortune.php" method="POST">
              <input type = "submit" name = "ApplyBtn" value = "Apply">
              <?php 
                include('form.php');
              ?>
          </form>
          </li>
          <li>
            <form action="WheelOfFortune.php" method="POST">
              <input type = "submit" name = "LeaveBtn" value = "Leave">
            </form>
          </li>
        </ul>
      </nav>
    </div>
  </header>
  <body class = "bodyWOF">
    <div>
      <FONT size="5">
      <p>The concept of the game is to solve word puzzles. The game is turn-based. In each turn the player can either guess the puzzle or select a letter to check if it exist in the puzzle. 
        The winner is this player who first guesses the puzzle or gives the letter that uncovers all letters in the puzzle. </p>
      <img src="/images/WOFEx.jpg" class ="center">
    </div>
      <div>
      <h2><b>Task</b></h2>
      <p>Your task is to implement web-based Wheel Of fortune game.</p>
      <p><b>How we imagine the application ?</b></p>
      <p>1. Player 1 enters on our game page. It clicks button "Create game" and receives a game ID (for example mO1C4RbNWeR) 
        or link to the game (for example battleship.herokuapp.com/mO1C4RbNWeR) from the server. </p>
      <p>2. Player 1 sends the link to the game to Player 2 (using their favourite communication channel like discord or messenger) and the game can be started. </p>
      <p>3. The server stores the word puzzles in the database and randomly selects which one to show the players. The server also randomly selects the order of the players.</p>
      <p>4. Each player can either guess the whole puzzle or suggest a letter in the puzzle. For each guessed puzzle or letter the user gain points 
        (1 point for letter, x points for the puzzle where x is the uncovered number of letters). </p>
      <p>5. The amount puzzles is the number of players + 1. After all of them are solved the game finishes and the high score is presented (based on gained points) </p>
      <p>6. The logic of the game is controlled by server. This means that after clicking a wrong button server responds with an error.  </p>
      <p>7. In the most simple version of the game players need to refresh the web page to see if something changed in the game status. For keeping game status you should use database.</p>
      <p>8  . In more advanced game version you should use REST services with Vue.js on the frontend</p>
    </div>
    </FONT>       
  </body>
</html>