<html>
<head>

</head>
<body>
    <h1>Application form</h1>
    <?php

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
        if (isset($_COOKIE['subject'])){
            $infoSent = explode(";", $_COOKIE['subject']);
            $subjectNumber = $infoSent[0];
            $name = $infoSent[1];
            $surname = $infoSent[2];

            $sql = "SELECT COUNT(*) FROM students";
            $ret = $db->query($sql);
            while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
              $counterTotalMembers = $row['COUNT(*)'] +1 ;
            }
            echo "<br>";
            echo "Counter of Total members at the begining : ";
            echo $counterTotalMembers;

            // Recovery of different teams. 
            $sql = "SELECT DISTINCT team FROM students where subject == 1";
            $ret = $db->query($sql);
            $arrayTeams = [];

            while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                array_push($arrayTeams, $row['team']);
            }

            $arrayTeamsDisposable = [];
            for ($k=1; $k <=5; $k++) {
                if(!in_array($k, $arrayTeams)){
                    /* echo $k; */
                    array_push($arrayTeamsDisposable, $k);
                }
            }
        }

        if(isset($_POST['No'])) {
            $sql = "INSERT INTO 'students' (id, name, surname, subject, team) VALUES ('$counterTotalMembers', '$name', '$surname', '$subjectNumber', '$arrayTeamsDisposable[0]')";
            $ret = $db->query($sql); 
             echo "<meta http-equiv='Refresh' content='0; url=index.php' />";
        }

        echo "<br>";
        echo "Do you want to complete your mates names ?";
        echo "<br>";
        echo "<br>";
        echo "<form action='form.php' method='POST'>
        <input type = 'submit' class = 'navbar' name = 'Yes' value = 'Yes'>
        <input type = 'submit' class = 'navbar' name = 'No' value = 'No'>
        </form>";

        if(isset($_POST['Yes'])) {
            $sql = "INSERT INTO 'students' (id, name, surname, subject, team) VALUES ('$counterTotalMembers', '$name', '$surname', '$subjectNumber', '$arrayTeamsDisposable[0]')";
            $ret = $db->query($sql);

            echo "<br>";
            echo "How many of them ?";
            echo "<br>";
            echo "<form action='form.php' method='POST'>
                    <input type = 'submit' class = 'navbar' name = 'One' value = '1'>
                    <input type = 'submit' class = 'navbar' name = 'Two' value = '2'>
                    <input type='hidden' name= 'team' value='$arrayTeamsDisposable[0]'>
                  </form>";
        }

        if(isset($_POST['One'])){
            $name1 = $surname1 = "";
            $team = $_POST['team'];
            echo "<br>";
            echo "Enter your mate's name :";
            echo "<br>";
            echo"<form action='form.php' method='post'>
                    Student's Name : <input type = 'text' name = 'name1' placeholder = 'Please Enter your name' value='$name1'>
                    Student's Surname : <input type ='text' name = 'surname1' placeholder = 'Please Enter your surname' value='$surname1'>
                    <input type='hidden' name='team' value='$team'>
                    <input type = 'submit' name = 'submition1' value = 'Submit'>
                 </form>";
            
        }

        if(isset($_POST['submition1'])) {
            $counterTotalMembers++;
            echo "<br>";
            echo "submition 1 entry : ";
            echo $counterTotalMembers;

            if(isset($_POST['name1']) && isset($_POST['surname1'])) {
                $name1 = $_POST['name1'];
                $surname1 = $_POST['surname1'];
                $team = $_POST['team'];
                echo "Should show smth";
                echo $team;
                $sql = "INSERT INTO 'students' (id, name, surname, subject, team) VALUES ('$counterTotalMembers', '$name1', '$surname1', '$subjectNumber', '$team')";
                $ret = $db->query($sql);
            }

            echo "<meta http-equiv='Refresh' content='0; url=index.php' />";
        }

        if(isset($_POST['Two'])) {
            $name1 = $surname1 = $name2 = $surname2 = "";
            $team = $_POST['team'];
            echo "<br>";
            echo "Enter your mates' name :";
            echo "<br>";
            echo"<form action='form.php' method='post'>
                    Student's 1 Name : <input type = 'text' name = 'name1' placeholder = 'Please Enter your name' value='$name1'>
                    Student's 1 Surname : <input type ='text' name = 'surname1' placeholder = 'Please Enter your surname' value='$surname1'>
                    <br>
                    Student's 2 Name : <input type = 'text' name = 'name2' placeholder = 'Please Enter your name' value='$name2'>
                    Student's 2 Surname : <input type ='text' name = 'surname2' placeholder = 'Please Enter your surname' value='$surname2'>
                    <br>
                    <input type='hidden' name= 'team' value='$team'>
                    <input type = 'submit' name = 'submition2' value = 'Submit'>
                  </form>";
        }

        if(isset($_POST['submition2'])) {
            echo "<br>";
            echo "submition 2 entry : ";
            echo $counterTotalMembers;
            if(isset($_POST['name1']) && isset($_POST['surname1'])) {
                $name1 = $_POST['name1'];
                $surname1 = $_POST['surname1'];
                $team = $_POST['team'];
/*                 echo "Should show smth";
                echo $team; */
                $sql = "INSERT INTO 'students' (id, name, surname, subject, team) VALUES ('$counterTotalMembers', '$name1', '$surname1', '$subjectNumber', '$team')";
                $ret = $db->query($sql);
                
                if(isset($_POST['name2']) && isset($_POST['surname2'])) {
                    $counterTotalMembers++;
                    echo "<br>";
                    echo "submition 2 post entry : ";
                    echo $counterTotalMembers;
                    $name2 = $_POST['name2'];
                    $surname2 = $_POST['surname2'];
                    $team = $_POST['team'];
    /*                 echo "Should show smth";
                    echo $team; */
                    $sql = "INSERT INTO 'students' (id, name, surname, subject, team) VALUES ('$counterTotalMembers', '$name2', '$surname2', '$subjectNumber', '$team')";
                    $ret = $db->query($sql);
                }

            }

            echo "<meta http-equiv='Refresh' content='0; url=index.php' />";
        }
    ?>
</body>
</html>