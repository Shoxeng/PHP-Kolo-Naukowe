<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'opiekun' && $role != 'admin'){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Stwórz nowy konkurs</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"/>
		<link rel="stylesheet" href="/style.css"/>
	</head>
	<body>
		<?php
			if(isset($_GET["err"])){
				$keyword = $_GET["err"];
				if($keyword == "inc_pass"){
					echo "<script>";
					echo "alert('Podano niepoprawne hasło')";
					echo "</script>";
				}
				if($keyword == "inc_new_pass"){
					echo "<script>";
					echo "alert('Nowe podane hasło nie powtarza się')";
					echo "</script>";
				}
				if($keyword == "empty_fields"){
					echo "<script>";
					echo "alert('Wypełnij wszystkie pola')";
					echo "</script>";
				}
			}
		?>
		<div class="login">
			<h1>Stwórz nowy konkurs</h1>
			<form action="_addkonkurs.php" method="post">
				<input type="text" name="name" placeholder="Przedmiot" id="name" required>
				<input type="date" name="date" placeholder="date" id="date" required>
				<input type="time" name="time" placeholder="time" id="time" required>
				<textarea name="opis" placeholder="Opis" id="opis" required></textarea>
				<select name="IDg" id="IDg" required>
				<?php
				$stmt = $con->prepare("SELECT IDgrupa, ID, nazwa FROM grupa left join (opiekun natural left join accounts) on grupa.IDopiekun = opiekun.IDopiekun");
				$stmt->execute();
				$stmt->bind_result($IDg,$ID, $nazwa);
				while($stmt->fetch()){
					if($ID == $_SESSION['id'] or $role == 'admin'){
						echo "<option value = ".$IDg.">".$nazwa."</option>";
					}
				}
				$stmt->close();
				?>
				</select>
				
				<input type="submit" value="Stwórz nowy konkurs">
			</form>
		</div>
	</body>
</html>