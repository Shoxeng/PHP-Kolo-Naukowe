<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'admin'){
	header('Location: ../homepage.php?keyword=no_acc');
	exit();
}

if(!isset($_POST['urole'])){
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
				if($err == "inc_new_pass"){
					echo "<script>";
					echo "alert('Podane hasła nie powtarzają się')";
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
			
				<?php 
				if($_POST['urole'] == 'admin'){
					echo '<form action="_adduzytkownik_admin.php" method="post">';
					echo' <input type="text" name="username" placeholder="username" id="username" required>';
					echo' <input type="text" name="email" placeholder="email" id="email" required>';
					echo' <input type="password" name="password" placeholder="password" id="password" required>';
					echo' <input type="password" name="repeatpassword" placeholder="repeat password" id="repeatpassword" required>';
					echo '<input type="submit" value="Dodaj nowego użytkownika">';
					echo '</form>';
				}
				else if($_POST['urole'] == 'admin + opiekun'){
					echo '<form action="_adduzytkownik_adminop.php" method="post">';
					echo' <input type="text" name="imie" placeholder="imie" id="imie" required>';
					echo' <input type="text" name="nazwisko" placeholder="nazwisko" id="nazwisko" required>';
					echo' <input type="text" name="username" placeholder="username" id="username" required>';
					echo' <input type="text" name="email" placeholder="email" id="email" required>';
					echo' <input type="password" name="password" placeholder="password" id="password" required>';
					echo' <input type="password" name="repeatpassword" placeholder="repeat password" id="repeatpassword" required>';
					echo '<input type="submit" value="Dodaj nowego użytkownika">';
					echo '</form>';
				}
				else if($_POST['urole'] == 'opiekun'){
					echo '<form action="_adduzytkownik_opiekun.php" method="post">';
					echo' <input type="text" name="imie" placeholder="imie" id="imie" required>';
					echo' <input type="text" name="nazwisko" placeholder="nazwisko" id="nazwisko" required>';
					echo' <input type="text" name="username" placeholder="username" id="username" required>';
					echo' <input type="text" name="email" placeholder="email" id="email" required>';
					echo' <input type="password" name="password" placeholder="password" id="password" required>';
					echo' <input type="password" name="repeatpassword" placeholder="repeat password" id="repeatpassword" required>';
					echo '<input type="submit" value="Dodaj nowego użytkownika">';
					echo '</form>';
				}
				else if($_POST['urole'] == 'czlonek'){
					echo '<form action="_adduzytkownik_user.php" method="post">';
					echo' <input type="text" name="imie" placeholder="imie" id="imie" required>';
					echo' <input type="text" name="nazwisko" placeholder="nazwisko" id="nazwisko" required>';
					echo' <input type="text" name="klasa" placeholder="klasa" id="klasa" required>';
					echo' <input type="text" name="username" placeholder="username" id="username" required>';
					echo' <input type="text" name="email" placeholder="email" id="email" required>';
					echo' <input type="password" name="password" placeholder="password" id="password" required>';
					echo' <input type="password" name="repeatpassword" placeholder="repeat password" id="repeatpassword" required>';
					echo '<input type="submit" value="Dodaj nowego użytkownika">';
					echo '</form>';
				}
				else{
					header('Location: ../homepage.php?keyword=no_acc');
					exit();
				}
				
				?>
				
			
		</div>
	</body>
</html>