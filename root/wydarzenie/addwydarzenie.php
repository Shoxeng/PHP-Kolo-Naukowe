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
		<title>Stwórz nowe wydarzenie</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"/>
		<link rel="stylesheet" href="/style.css"/>
	</head>
	<body>
		<?php
			if(!empty($_GET['err'])){
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
			<h1>Stwórz nowe wydarzenie</h1>
			<form action="_addwydarzenie.php" method="post" enctype="multipart/form-data">
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
				<input type="text" name="nazwa" placeholder="nazwa" id="nazwa" required>
				<textarea name="opis" placeholder="opis" id="opis"></textarea>
				<input type="date" name="date" id="date" required>
				<input type="time" name="hour" id="hour" required>
				<!<input type="file" name="image" id="image">
				</select>
				
				<input type="submit" value="Stwórz nowe wydarzenie">
			</form>
		</div>
	</body>
</html>