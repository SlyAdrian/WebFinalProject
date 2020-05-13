
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
      $sql = "SELECT * FROM students WHERE name = '$name' AND surname ='$surname' AND subject = 4";
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
      $infoSent = "4" . ";" . "$name" . ";" . "$surname" . ";" . "$counterTotalMembers"; 
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
    $sql = "INSERT INTO 'students' (id, name, surname, subject, team) VALUES ('$counterTotalMembers', '$name', '$surname', '4', '$arrayTeamNumber[1]')";
    $ret = $db->query($sql);
  }

  // Recovery of different teams. 
  $sql = "SELECT DISTINCT team FROM students where subject == 4";
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
		<title>S4 Efrei Messenger !</title> 
  </head>

  <header class = "header">
    <div class = content>
      <img src="/images/LogoEM.png" width = 85px class = "logo">
      <nav>
        <ul>
          <li><a href = "index.php">
            Go Back
          </a></li>
          <?php
            if($counterV == 0 && sizeof($arrayTeams)<5){
              echo "<li>  
                      <form action='EfreiMessenger.php' method='POST'>
                        <input type = 'submit' name = 'ApplyBtn' value = 'Apply'>
                      </form>
                    </li>";
            }
          ?>
          <?php
            if($counterA == 1){
              echo "<li>
                      <form action='EfreiMessenger.php' method='POST'>
                        <input type = 'submit' name = 'LeaveBtn' value = 'Leave'>
                      </form>
                    </li> ";
            }
          ?>

        </ul>
      </nav>
    </div>
  </header>

  <body class = "bodyEM">
    <div>
    <div>
      <FONT size="5">
        <p>Efrei Messenger is a free app that combines the voice chat aspects of services like Skype and Teamspeak with the text chat aspects 
          of Internet Relay Chat and various instant messaging services like messenger. </p>
        <img src="/images/EMEx.jpg" class ="center">
      </div>
        <div>
          <h2><b>Task</b></h2>
          <p>Your task is to implement a simple team messenger application.</p>
          <p><b>How we imagine the application ?</b></p>
          <p>1. User enters the main page of our messenger application and he gives his nickname. </p>
          <p>2. After this, the user can see a list of active channels with the number of members already chatting in the given channel.</p>  
          <p> For instance:</p> 
          <p class = "textCenter">Channel 1 (5 members)</p> 
          <p class = "textCenter">Channel 2 (2 members)</p> 
          <p class = "textCenter">Happy channel! (7 members)</p>  

          <p>3. User can enter one of the channels or he can create his own channel after providing the channel name.</p>
          <p>4. After joining the specific channel the user should see a list of channel members and the history of the channel discussion, similar to the TeamSpeak app.</p>
          <p>5. User can join the discussion or leave the channel.</p>
          <p>6. Then he can join another channel or create new one.</p>
          <p>7. The logic of the application is controlled by server. All chats and channels are stored in the database. </p>
          <p>8. In the most simple version of the application users need to refresh the page to see new messages and members in the channel.</p>
          <p>9. In more advanced game version you should use REST services with Vue.js on the frontend.</p>
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
                $sql = "SELECT * FROM students where subject = 4 AND team = $team";
                $ret = $db->query($sql);
                $counter = 0;
                while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                  echo $row['name'] . " " . $row['surname'] . "<br>" ;
                  $counter++;
                }
                // If the number of team members is under 3 then you can join the team.
                if($counter <3 && $counterV==0) {
                  echo "<br>";
                  echo "<form action='EfreiMessenger.php' method='POST'>
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