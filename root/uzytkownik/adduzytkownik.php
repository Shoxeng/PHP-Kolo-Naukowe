<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'admin'){
	header('Location: ../homepage.php?keyword=no_acc');
	exit();
}

?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Tworzenie nowego użytkownika</title>
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
				if($err == "ex_us"){
					echo "<script>";
					echo "alert('Nazwa użytkownika już istnieje')";
					echo "</script>";
				}
				if($err == "ex_em"){
					echo "<script>";
					echo "alert('Email już istnieje w systemie')";
					echo "</script>";
				}
			}
		?>
		<div class="login">
			<h1>Stwórz nowego użytkownika</h1>
			<form action="_adduzytkownik.php" method="post">
				<select name="urole" placeholder="urole" id="urole" required>
				<option disabled selected value> -- Rola tworzonego użytkownika -- </option>
				<option value="czlonek">Członek</option>
				<option value="opiekun">Opiekun</option>
				<option value="admin">Admin</option>
				<option value="admin + opiekun">Admin + Opiekun</option>
				</select>
				<input type="submit" value="Przejdź dalej">
			</form>
		</div>
	</body>
</html>