<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'admin' && $role !='opiekun'){
	header('Location: ../homepage.php?keyword=no_acc');
	exit();
}

if(!isset($_POST['keyword'],$_POST['keyword2'])){
	header('Location: ../grupa/grupy.php');
	exit();
}
$keyword = $_POST["keyword"];
$keyword2 = $_POST["keyword2"];
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Edytowanie zajęć</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"/>
		<link rel="stylesheet" href="/style.css"/>
	</head>
	<body>
		<?php
			if(!empty($_GET["err"])){
				$err = $_GET["err"];
				if($err == "inc_pass"){
					echo "<script>";
					echo "alert('Podano niepoprawne hasło')";
					echo "</script>";
				}
				if($err == "empty_fields"){
					echo "<script>";
					echo "alert('Wypełnij wszystkie pola')";
					echo "</script>";
				}
			}
		?>
		<div class="login">
			<h1>Edytowanie zajęć</h1>
			<form action="_editzajecia.php" method="post">
				<input type = "hidden" name = "keyword" id="keyword" value = <?echo $keyword?>>
				<input type = "hidden" name = "keyword2" id="keyword2" value = <?echo $keyword2?>>
				<select name="dzien" placeholder="dzien" id="dzien" required>
				<option disabled selected value> -- Dzień tygodnia -- </option>
				<option value="Poniedziałek">Poniedziałek</option>
				<option value="Wtorek">Wtorek</option>
				<option value="Środa">Środa</option>
				<option value="Czwartek">Czwartek</option>
				<option value="Piątek">Piątek</option>
				</select>
				<input type="time" name="Hour" id="Hour" required>
				<input type="submit" value="Edytuj zajęcia">
			</form>
		</div>
	</body>
</html>