<html>
    <head></head>
    <body>
        <?php
           if(isset($_POST['ApplyBtn'])) {
            $applyBtn = $_POST['ApplyBtn'];
            echo "<br>";
            echo "Do you want to complete your mates names ?";
            echo "<br>";
            echo "<br>";
            echo "<form action='form.php' method='POST'>
                    <input type = 'submit' class = 'navbar' name = 'Yes' value = 'Yes'>
                    <input type = 'submit' class = 'navbar' name = 'No' value = 'No'>
                 </form>";
          }
          if(isset($_POST['Yes'])) {
            echo "<br>";
            echo "How many of them ?";
            echo "<br>";
            echo "<form action='form.php' method='POST'>
                    <input type = 'submit' class = 'navbar' name = 'One' value = '1'>
                    <input type = 'submit' class = 'navbar' name = 'Two' value = '2'>
                  </form>";
          }

          if(isset($_POST['One'])){
            $name = $surname = "";
            echo "<br>";
            echo "Enter your mate's name :";
            echo "<br>";
            echo"<form action='form.php' method='post'>
                    Student's Name : <input type = 'text' name = 'name' placeholder = 'Please Enter your name' value='$name'>
                    Student's Surname : <input type ='text' name = 'surname' placeholder = 'Please Enter your surname' value='$surname'>
                    <input type = 'submit' name = 'name1' value = 'Submit'>
                 </form>";
          }
          
          if(isset($_POST['Two'])) {
            $name1 = $surname1 = $name2 = $surname2 = "";
            echo "<br>";
            echo "Enter your mates' name :";
            echo "<br>";
            echo"<form action='form.php' method='post'>
                    Student's 1 Name : <input type = 'text' name = 'name' placeholder = 'Please Enter your name' value='$name1'>
                    Student's 1 Surname : <input type ='text' name = 'surname' placeholder = 'Please Enter your surname' value='$surname1'>
                    <br>
                    Student's 2 Name : <input type = 'text' name = 'name' placeholder = 'Please Enter your name' value='$name2'>
                    Student's 2 Surname : <input type ='text' name = 'surname' placeholder = 'Please Enter your surname' value='$surname2'>
                    <br>
                    <input type = 'submit' name = 'names' value = 'Submit'>
                 </form>";
          }
        ?>
    </body>
</html>