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
    echo $_COOKIE["Cookie"];
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
      $sql = "SELECT * FROM students WHERE name = '$name' AND surname ='$surname' AND subject = 2";
      $ret = $db->query($sql);
      $counterA = 0;

      while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
        $counterA++;
      }
    }

    if(isset($_POST['LeaveBtn']) && $counterA == 1){
      $sql = "SELECT id FROM students WHERE name = '$name' AND surname = '$surname'";
      $ret = $db->query($sql);
      while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
        $id = $row['id'];
      }

      setcookie('id', $id, time()+60*60);
      $sql = "DELETE FROM students WHERE name = '$name' AND surname = '$surname'";
      $ret = $db->query($sql);
    }

    // We determine the number of members.
    $counterTotalMembers = 0;
    // if someone has recently been added we try to keep its id.
    // So if he tries to apply again we keep the same id.
    if(isset($_COOKIE['id'])) {
      $counterTotalMembers = $_COOKIE['id'];

    } else {
      $sql = "SELECT COUNT(*) FROM students";
      $ret = $db->query($sql);
      while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
        $counterTotalMembers = $row['COUNT(*)'] +1 ;
      }
    }

    if(isset($_POST['ApplyBtn'])){
      // Definition of the cookie as subject_number
      $infoSent = "2" . ";" . "$name" . ";" . "$surname" . ";" . "$counterTotalMembers"; 
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
    $sql = "INSERT INTO 'students' (id, name, surname, subject, team) VALUES ('$counterTotalMembers', '$name', '$surname', '2', '$arrayTeamNumber[1]')";
    $ret = $db->query($sql);
  }

  // Recovery of different teams. 
  $sql = "SELECT DISTINCT team FROM students where subject == 2";
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
          <?php
            if($counterV == 0 && sizeof($arrayTeams)<5){
              echo "<li>  
                      <form action='Battleship.php' method='POST'>
                        <input type = 'submit' name = 'ApplyBtn' value = 'Apply'>
                      </form>
                    </li>";
            }
          ?>
          <?php
            if($counterA == 1){
              echo "<li>
                      <form action='Battleship.php' method='POST'>
                        <input type = 'submit' name = 'LeaveBtn' value = 'Leave'>
                      </form>
                    </li> ";
            }
          ?>

        </ul>
      </nav>
    </div>
  </header>

  <body class = "bodyBTSH">
    <div>
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

    <div>
      <h2>Team that have already applied for this subject : </h3>
        <?php 
            // We diplay all the teams taking care of the maximum number of members which is free.
            echo "<ul>";
              foreach ($arrayTeams as $team) {
                echo "<li>";
                echo "<h3> Team $team </h3>";
                $sql = "SELECT * FROM students where subject = 2 AND team = $team";
                $ret = $db->query($sql);
                $counter = 0;
                while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                  echo $row['name'] . " " . $row['surname'] . "<br>" ;
                  $counter++;
                }
                // If the number of team members is under 3 then you can join the team.
                if($counter <3 && $counterV==0) {
                  echo "<br>";
                  echo "<form action='Battleship.php' method='POST'>
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