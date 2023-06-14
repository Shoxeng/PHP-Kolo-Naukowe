<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'admin'){
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
			<h1>Wybierz nowego opiekuna do grup</h1>
			<form action="_removeuzytkownik2.php">
				<input type="hidden" name="keyword" value=<?echo $_GET['keyword']?> id="keyword">
				<input type="hidden" name="keyword2" value=<?echo $_GET['keyword2']?> id="keyword2">
				<select name="IDg" id="IDg" required>
				<?php
				$stmt = $con->prepare("SELECT IDopiekun, imie, nazwisko FROM opiekun where IDopiekun != ?");
				$stmt->bind_param('i',$_GET['keyword2']);
				$stmt->execute();
				$stmt->bind_result($IDo,$imie, $nazwisko);
				while($stmt->fetch()){
					if($role == 'admin'){
						echo "<option value = ".$IDo.">".$nazwisko." ".$imie."</option>";
					}
				}
				$stmt->close();
				?>
				</select>
				<input type="submit" value="Zmień opiekuna">
			</form>
		</div>
	</body>
</html>