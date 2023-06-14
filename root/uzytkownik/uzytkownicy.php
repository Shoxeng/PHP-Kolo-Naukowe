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
		<title>Użytkownicy</title>
		<link href="/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<?php include $path."/navmenu.php" ?>
			</div>
		</nav>
		<div class="content">
			<h2>Użytkownicy</h2>
			<div>
			<form action = "uzytkownicy.php">
						Wyszukiwanie użytkowników w bazie danych<i class="fas fa-image-portrait"></i>
						<br><input type = "text" name = "keyword">
						<input type = "submit" value = "Search">
					</form>
			<table>
				<?php
					if(!empty($_GET["keyword"])){
						$keyword = $_GET["keyword"];
						$stmt = $con->prepare("select ID, IF(accounts.IDczlonek is not null, czlonek.imie, IF(accounts.IDopiekun is not null, opiekun.Imie, accounts.username)) as '_imie', IF(accounts.IDczlonek is not null, czlonek.nazwisko, IF(accounts.IDopiekun is not null, opiekun.nazwisko, accounts.ID )) as '_nazwisko', role, email, username from (accounts natural left join czlonek) left join opiekun on accounts.IDopiekun = opiekun.IDopiekun having concat(_imie,' ',_nazwisko) RLIKE concat('^.*',?,'.*$')");
						$stmt->bind_param('s',$keyword);
						$stmt->execute();
						$stmt->bind_result($IDs,$imie,$nazwisko, $urole, $email, $username);
						while($stmt->fetch()){
							echo "<hr>";
							echo "Username: ".$username." Email: ".$email." Rola: ".$urole." | ".$nazwisko." ".$imie;
							uzytkownik::removeuzytkownik($IDs,$role);
						}
					}
				?>
				<hr>
				</table>
				<?php
				uzytkownik::adduzytkownik($role);
				?>
				</div>
		</div>
	</body>
</html>