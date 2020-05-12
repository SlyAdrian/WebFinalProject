
<?php
	if(isset($_POST['name']) && isset($_POST['surname'])) {
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		/* 		$name = strtoupper($_POST['name']);
		$surname = strtoupper($_POST['surname']); */
		$value = $name . ";" . $surname;
		setcookie("Cookie", $value);
	}
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<meta charset="utf-8">
		<title>Subjects Assignment</title>
	</head>

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

		$numberSlots = 5;

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
				<input type ="text" id = "Surname" name = "surname" placeholder = "Please Enter your surname" value="<?=$surname?>" required>

				<input type = "submit" class = "btnIdx" name = "submit1" value = "Submit">
			</form>

			<ul class = "subjects">
				<li class = "subjects"><a href="TicTacToe.php">
					S1 : Tic Tac Toe Game (
					<?php 
						$sql = "SELECT COUNT(DISTINCT team) FROM students where subject == 1";
						$ret = $db->query($sql);
						while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
							$res = $numberSlots - $row['COUNT(DISTINCT team)'];
							echo "$res";	
						}
					?>
					 available team slots )
				</a></li>
				<li class = "subjects"><a href="Battleship.php">
					S2 : Battleship Game (
					<?php 
						$sql = "SELECT COUNT(DISTINCT team) FROM students where subject == 2";
						$ret = $db->query($sql);
						while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
							$res = $numberSlots - $row['COUNT(DISTINCT team)'];
							echo "$res";	
						}
					?>
					 available team slots )
				</a></li>
				<li class = "subjects"><a href="WheelOfFortune.php">
					S3 : Wheel Of Fortune Game (
					<?php 
						$sql = "SELECT COUNT(DISTINCT team) FROM students where subject == 3";
						$ret = $db->query($sql);
						while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
							$res = $numberSlots - $row['COUNT(DISTINCT team)'];
							echo "$res";	
						}
					?>
					 available team slots )
				</a></li>
				<li class = "subjects"><a href="EfreiMessenger.php">
					S4 : Efrei Messenger App (
					<?php 
						$sql = "SELECT COUNT(DISTINCT team) FROM students where subject == 4";
						$ret = $db->query($sql);
						while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
							$res = $numberSlots - $row['COUNT(DISTINCT team)'];
							echo "$res";	
						}
					?>
					 available team slots )
				</a></li>
				<li class = "subjects"><a href="ProjectsAssignment.php">
					S5 : Projects Assignment App (
					<?php 
						$sql = "SELECT COUNT(DISTINCT team) FROM students where subject == 5";
						$ret = $db->query($sql);
						while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
							$res = $numberSlots - $row['COUNT(DISTINCT team)'];
							echo "$res";	
						}
					?>
					 available team slots )
				</a></li>							
			</ul>
			<?php 

				$db->close();
			?>
		</div>

<!-- 		<h1>Subjects Assignment App</h1>
		<p>The aim of this app is to allow you to choose effictiently the topic you want to carry out.</p>
		<br>
		<form action="index.php" method="POST">
			Student's Name : <input type = "text" name = "name" placeholder = "Please Enter your name" value="<?=$name?>">
			Student's Surname : <input type ="text" name = "surname" placeholder = "Please Enter your surname" value="<?=$surname?>">
			<input type = "submit" name = "submit1" value = "Submit">
		</form> -->

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