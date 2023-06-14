<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Edytuj konkurs</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"/>
		<link rel="stylesheet" href="/style.css"/>
	</head>
	<body>
		<?php
			if(!empty($_GET['err'])){
				$err = $_GET["err"];
				if($err == "inc_pass"){
					echo "<script>";
					echo "alert('Podano niepoprawne hasło')";
					echo "</script>";
				}
				if($err == "inc_new_pass"){
					echo "<script>";
					echo "alert('Nowe podane hasło nie powtarza się')";
					echo "</script>";
				}
				if($err == "empty_fields"){
					echo "<script>";
					echo "alert('Wypełnij wszystkie pola')";
					echo "</script>";
				}
			}
			$keyword = $_GET["keyword"];
		?>
		<div class="login">
			<h1>Edytuj konkurs</h1>
			<form action="_editkonkurs.php" method="post">
				<input type="text" name="name" placeholder="Przedmiot" id="name" required>
				<input type='hidden' name= "keyword" value = <?echo $keyword?>>
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
						echo "<option value = ".$ID.">".$nazwa."</option>";
					}
				}
				$stmt->close();
				?>
				</select>
				
				<input type="submit" value="Edytuj konkurs">
			</form>
		</div>
	</body>
</html>