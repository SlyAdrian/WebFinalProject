
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
      $sql = "SELECT * FROM students WHERE name = '$name' AND surname ='$surname' AND subject = 5";
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
      $infoSent = "5" . ";" . "$name" . ";" . "$surname" . ";" . "$arrayIdsDisposable[0]"; 
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
    $sql = "INSERT INTO 'students' (id, name, surname, subject, team) VALUES ('$arrayIdsDisposable[0]', '$name', '$surname', '5', '$arrayTeamNumber[1]')";
    $ret = $db->query($sql);
  }

  // Recovery of different teams. 
  $sql = "SELECT DISTINCT team FROM students where subject == 5";
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
		<title>S5 Project Assignment App !</title> 
  </head>

  <header class = "header">
    <?php 
      echo "Hello ";
      echo "$name";
    ?>
    <div class = content>
      <img src="/images/LogoPA.jpg" width = 85px class = "logo">
      <nav>
        <ul>
          <li><a href = "index.php">
            Go Back
          </a></li>
          <?php
            if($counterV == 0 && sizeof($arrayTeams)<5){
              echo "<li>  
                      <form action='ProjectsAssignment.php' method='POST'>
                        <input type = 'submit' name = 'ApplyBtn' value = 'Apply'>
                      </form>
                    </li>";
            }
          ?>
          <?php
            if($counterA == 1){
              echo "<li>
                      <form action='ProjectsAssignment.php' method='POST'>
                        <input type = 'submit' name = 'LeaveBtn' value = 'Leave'>
                      </form>
                    </li> ";
            }
          ?>

        </ul>
      </nav>
    </div>
  </header>

  <body class = "bodyPA">
    <div>
    <div>
      <FONT size="5">
        <p>The idea is simple. Currently you are expected to choose a project. You will do this by using the best website in the world system by entering the names of your team members. 
        Can you think of another application for supporting this process? </p>
        <img src="/images/PAEx.jpg" class ="center">
      </div>
          <h2><b>Task</b></h2>
          <p>Your task is to implement an application supporting assignments of the topics between students' groups.</p>
          <p><b>How we imagine the application ?</b></p>
          <p>1. Users enters a page. He enters his name and surname. He can see a list of available topics with the number of available team slots in the given topic.</p>  
          <p> For instance:</p>
          <p class = "textCenter">Topic 1 (3 available team slots)</p> 
          <p class = "textCenter">Topic 2 (1 available team slot)</p> 
          <p class = "textCenter">Topic 3 (0 available team slots)</p>  
          <p>2. The maximum number of team slots per topic is set in the configuration file.</p>
          <p>3. User can click on the topic (using a link or button) and he is redirected to the description of the topic and where he can:</p>  
          <p>Apply for the given topic</p> 
          <p>Go back to the list of topics</p> 
          <p>Leave the topic if he had previously applied for it</p>  
          <p>4. If the user applies for the topic he can add the names of its team members </p>
          <p>5. The team members can also apply for the topic on their own - in the topic details they can see the list of teams and they can join a team (however the maximum size of the team is 3!).</p>
          <p>6. Everything is controlled by server. This means that if the user clicks on the button to apply for the topic and some other user did it meanwhile (was faster) the server responds with an error if the limit is exceeded. </p>
          <p>7. Everything should be kept in database.</p>
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
                $sql = "SELECT * FROM students where subject = 5 AND team = $team";
                $ret = $db->query($sql);
                $counter = 0;
                while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                  echo $row['name'] . " " . $row['surname'] . "<br>" ;
                  $counter++;
                }
                // If the number of team members is under 3 then you can join the team.
                if($counter <3 && $counterV==0) {
                  echo "<br>";
                  echo "<form action='ProjectsAssignment.php' method='POST'>
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