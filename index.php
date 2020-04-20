<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<meta charset="utf-8">
		<title>Subjects Assignment</title>
	</head>

	<?php
		$name = $surname = "";
		if(isset($_POST['name']) && isset($_POST['surname'])) {
			$name = $_POST['name'];
			$surname = $_POST['surname'];
		}
	?>
	<body class = "bodyIdx">

		<div class="contentIdx">
			<h1 class = "titleIdx">Subjects Assignment App</h1>

			<form action="index.php" method="POST">
				<label for="Name">Name :</label>
				<input type = "text" id = "Name" name = "name" placeholder = "Please Enter your name" value="<?=$name?>" required>

				<label for="Surname">Surname : </label>
				<input type ="text" id = "Surname" name = "surname" placeholder = "Please Enter your surname" value="<?=$surname?>"required>

				<input type = "submit" class = "btnIdx" name = "submit1" value = "Submit">
			</form>

			<ul class = "subjects">
				<li class = "subjects"><a href="TicTacToe.php">
					S1 : Tic Tac Toe Game (x available team slots)
				</a></li>
				<li class = "subjects"><a href="Battleship.php">
					S2 : Battleship Game (x available team slots)
				</a></li>
				<li class = "subjects"><a href="WheelOfFortune.php">
					S3 : Wheel Of Fortune Game (x available team slots)
				</a></li>
				<li class = "subjects"><a href="EfreiMessenger.php">
					S4 : Efrei Messenger App (x available team slots)
				</a></li>
				<li class = "subjects"><a href="ProjectsAssignment.php">
					S5 : Projects Assignment App (x available team slots)
				</a></li>							
			</ul>
		</div>

<!-- 		<h1>Subjects Assignment App</h1>
		<p>The aim of this app is to allow you to choose effictiently the topic you want to carry out.</p>
		<br>
		<form action="index.php" method="POST">
			Student's Name : <input type = "text" name = "name" placeholder = "Please Enter your name" value="<?=$name?>">
			Student's Surname : <input type ="text" name = "surname" placeholder = "Please Enter your surname" value="<?=$surname?>">
			<input type = "submit" name = "submit1" value = "Submit">
		</form> -->

		<?php
			if(isset($_POST['submit1'])) {
				if($name == "" || $surname == "") {
					echo "You haven't filled correctly name and surname fields !";
				} 
			}
		?>
<!-- 		<div class="contentIdx">
			<ul class = "subjects">
				<li class = "subjects"><a href="TicTacToe.php">
					S1 : Tic Tac Toe Game
				</a></li>
				<li class = "subjects"><a href="Battleship.php">
					S2 : Battleship Game
				</a></li>
				<li class = "subjects"><a href="WheelOfFortune.php">
					S3 : Wheel Of Fortune Game
				</a></li>
				<li class = "subjects"><a href="EfreiMessenger.php">
					S4 : Efrei Messenger App
				</a></li>
				<li class = "subjects"><a href="ProjectsAssignment.php">
					S5 : Projects Assignment App
				</a></li>							
			</ul>
		</div> -->

	</body>
</html>