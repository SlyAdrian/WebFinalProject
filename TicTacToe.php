
<?php
// Afficher un cookie
/* echo $_COOKIE["Cookie"];
 */
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
    $sql = "SELECT * FROM students WHERE name = '$name' AND surname ='$surname' AND subject = 1";
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
 /*    echo "<br>";
    echo $id; */
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
    /* echo $_COOKIE['id']; */
  } else {
    $sql = "SELECT COUNT(*) FROM students";
    $ret = $db->query($sql);
    while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
      $counterTotalMembers = $row['COUNT(*)'] +1 ;
    }
  }

  if(isset($_POST['ApplyBtn'])){
    // Definition of the cookie as subject_number
    $infoSent = "1" . ";" . "$name" . ";" . "$surname" . ";" . "$counterTotalMembers"; 
    setcookie('subject', $infoSent);
    // Redirection to form.php page
    echo "<meta http-equiv='Refresh' content='0; url=form.php' />";
  }
}

/* echo "<br>";
echo $counterV; */

// If the join button has been clicked, we add the member to the corresponding team.
if(isset($_POST['join']) && $counterV == 0) {
  $teamNumber = $_POST['join'];
  $arrayTeamNumber = [];
  $arrayTeamNumber = explode('-',$teamNumber);
  /* echo $counterTotalMembers; */
  /* echo $arrayTeamNumber[1]; */
  $sql = "INSERT INTO 'students' (id, name, surname, subject, team) VALUES ('$counterTotalMembers', '$name', '$surname', '1', '$arrayTeamNumber[1]')";
  $ret = $db->query($sql);
}

// Recovery of different teams. 
$sql = "SELECT DISTINCT team FROM students where subject == 1";
$ret = $db->query($sql);
$arrayTeams = [];

while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
/*               echo $row['team']; */
  array_push($arrayTeams, $row['team']);
/* 							$res = $numberSlots - $row['COUNT(DISTINCT team)'];
  echo "$res";	 */
}
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
          <?php
            if($counterV == 0 && sizeof($arrayTeams)<5){
              echo "<li>  
                      <form action='TicTacToe.php' method='POST'>
                        <input type = 'submit' name = 'ApplyBtn' value = 'Apply'>
                      </form>
                    </li>";
            }
          ?>
          <?php
            if($counterA == 1){
              echo "<li>
                      <form action='TicTacToe.php' method='POST'>
                        <input type = 'submit' name = 'LeaveBtn' value = 'Leave'>
                      </form>
                    </li> ";
            }
          ?>

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

    <div>
      <h2>Team that have already applied for this subject : </h3>
        <?php 
            // We diplay all the teams taking care of the maximum number of members which is free.
            echo "<ul>";
              foreach ($arrayTeams as $team) {
                echo "<li>";
                echo "<h3> Team $team </h3>";
                $sql = "SELECT * FROM students where subject = 1 AND team = $team";
                $ret = $db->query($sql);
                $counter = 0;
                while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                  echo $row['name'] . " " . $row['surname'] . "<br>" ;
                  $counter++;
                }
                // If the number of team members is under 3 then you can join the team.
                if($counter <3 && $counterV==0) {
                  echo "<br>";
                  echo "<form action='TicTacToe.php' method='POST'>
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