<?php
  // Afficher un cookie
  class MyDB extends SQLite3 {
    function __construct() {
      $this->open('sqlite.db');
    }
  }
    
  $db = new MyDB();
  if(!$db) {
  echo $db->lastErrorMsg();
  exit();
  }
  
  if(isset($_COOKIE["Cookie"]))
  {
    $ns = explode(";", $_COOKIE["Cookie"]); 
    $name = $ns[0];
    $surname = $ns[1];

    // We check if the User logged has already a team and a subject.
    $sql = "SELECT * FROM students WHERE name = '$name' AND surname ='$surname'";
    $ret = $db->query($sql);
    $counterV = 0;

    while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
      $counterV++;
    }

    //If the name is already registered in the database, we check if it corresponds to this particular one.
    if($counterV >0) {
      $sql = "SELECT * FROM students WHERE name = '$name' AND surname ='$surname' AND subject = 3";
      $ret = $db->query($sql);
      $counterA = 0;

      while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
        $counterA++;
      }
    }

    /////////////
    if(isset($_POST['LeaveBtn']) && $counterA == 1){
      $sql = "SELECT id FROM students WHERE name = '$name' AND surname = '$surname'";
      $ret = $db->query($sql);
      while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
        $id = $row['id'];
      }
      $sql = "DELETE FROM students WHERE name = '$name' AND surname = '$surname'";
      $ret = $db->query($sql);
    }

    // We determine the number of members.
    $counterTotalMembers = 0;
    $sql = "SELECT COUNT(*) FROM students";
    $ret = $db->query($sql);
    while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
      $counterTotalMembers = $row['COUNT(*)'] +1 ;
    }
    // Recovery of different ids. 
    $sql = "SELECT DISTINCT id FROM students";
    $ret = $db->query($sql);
    $allIds = [];

    while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
        array_push($allIds, $row['id']);
    }

    $arrayIdsDisposable = [];
    for ($k=1; $k <=$counterTotalMembers; $k++) {
        if(!in_array($k, $allIds)){
            array_push($arrayIdsDisposable, $k);
        }
    }
    array_push($arrayIdsDisposable, $counterTotalMembers);    
    /////////////

    if(isset($_POST['ApplyBtn'])){
      // Definition of the cookie as subject_number
      $infoSent = "3" . ";" . "$name" . ";" . "$surname" . ";" . "$arrayIdsDisposable[0]"; 
      setcookie('subject', $infoSent);
      // Redirection to form.php page
      echo "<meta http-equiv='Refresh' content='0; url=form.php' />";
    }
  }

  // If the join button has been clicked, we add the member to the corresponding team.
  if(isset($_POST['join']) && $counterV == 0) {
    $teamNumber = $_POST['join'];
    $arrayTeamNumber = [];
    $arrayTeamNumber = explode('-',$teamNumber);
    $sql = "INSERT INTO 'students' (id, name, surname, subject, team) VALUES ('$arrayIdsDisposable[0]', '$name', '$surname', '3', '$arrayTeamNumber[1]')";
    $ret = $db->query($sql);
  }

  // Recovery of different teams. 
  $sql = "SELECT DISTINCT team FROM students where subject == 3";
  $ret = $db->query($sql);
  $arrayTeams = [];

  while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
    array_push($arrayTeams, $row['team']);
  }
?>

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="styles.css">
		<meta charset="utf-8">
		<title>S3 Wheel Of Fortune !</title> 
  </head>

  <header class = "header">
    <?php 
      echo "Hello ";
      echo "$name";
    ?>
    <div class = content>
      <img src="/images/LogoWOF.jpg" width = 215px class = "logo">
      <nav>
        <ul>
          <li><a href = "index.php">
            Go Back
          </a></li>
          <?php
            if($counterV == 0 && sizeof($arrayTeams)<5){
              echo "<li>  
                      <form action='WheelOfFortune.php' method='POST'>
                        <input type = 'submit' name = 'ApplyBtn' value = 'Apply'>
                      </form>
                    </li>";
            }
          ?>
          <?php
            if($counterA == 1){
              echo "<li>
                      <form action='WheelOfFortune.php' method='POST'>
                        <input type = 'submit' name = 'LeaveBtn' value = 'Leave'>
                      </form>
                    </li> ";
            }
          ?>

        </ul>
      </nav>
    </div>
  </header>

  <body class = "bodyWOF">
    <div>
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

    <div>
      <h2>Team that have already applied for this subject : </h3>
        <?php 
            // We diplay all the teams taking care of the maximum number of members which is free.
            echo "<ul>";
              foreach ($arrayTeams as $team) {
                echo "<li>";
                echo "<h3> Team $team </h3>";
                $sql = "SELECT * FROM students where subject = 3 AND team = $team";
                $ret = $db->query($sql);
                $counter = 0;
                while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                  echo $row['name'] . " " . $row['surname'] . "<br>" ;
                  $counter++;
                }
                // If the number of team members is under 3 then you can join the team.
                if($counter <3 && $counterV==0) {
                  echo "<br>";
                  echo "<form action='WheelOfFortune.php' method='POST'>
                          <input type = 'submit' name = 'join' value = \"Join-$team\">
                        </form>";
                }
                echo "</li>";              
              }
            echo "</ul>";
            
            if($counterA > 0) {
              echo "You have already assigned this subject";
            } else if($counterV >0) {
              echo "You could not join any project because you already have assigned for a project";
            }
				?>
    </div>
  </body>
</html>