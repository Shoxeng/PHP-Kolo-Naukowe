<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Stwórz nową grupe</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"/>
		<link rel="stylesheet" href="/style.css"/>
	</head>
	<body>
		<?php
			if(!empty($_GET)){
				$keyword = $_GET["keyword"];
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
			<h1>Stwórz nową grupe</h1>
			<form action="_addgrupa.php" method="post">
				<input type="text" name="name" placeholder="nazwa" id="name" required>
				<select name="IDo" id="IDo" required>
				<?php
				$stmt = $con->prepare("SELECT IDopiekun, concat(nazwisko,' ', imie) FROM opiekun");
				$stmt->execute();
				$stmt->bind_result($ID, $nazwa);
				while($stmt->fetch()){
					echo "<option value = ".$ID.">".$nazwa."</option>";
				}
				$stmt->close();
				?>
				</select>
				
				<input type="submit" value="Stwórz nową grupe">
			</form>
		</div>
	</body>
</html>