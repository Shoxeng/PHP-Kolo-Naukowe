<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if(!isset($_GET['keyword'])){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Wpisy</title>
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
			<h2>
			Wpisy:
			<?php
			$stmt = $con->prepare("select nazwa from grupa where IDgrupa = ?");
			$stmt->bind_param('i',$_GET['keyword']);
			$stmt->bind_result($nazwa);
			$stmt->execute();
			$stmt->fetch();
			$stmt->close();
			echo $nazwa;
			?>
			</h2>
			<div class = "wydarzenia">
				<div class = 'but'>
				<?php
				wpis::addwpis($_GET['keyword'],$role);
				?>
				<form action="/grupa/grupa.php">
				<input type = 'hidden' name = 'keyword' value = <?=$_GET['keyword']?>>
				<input type="submit" value="Return">
				</form>
				</div>
				<?php
					if(isset($_GET["keyword"])){
						$keyword = $_GET['keyword'];
						$stmt = $con->prepare("select IDwpis, wpis.IDopiekun, wpis.IDczlonek, text, DATE_FORMAT(post_time, '%Y.%m.%d, %a | %H:%i,'),IF(wpis.IDczlonek is not null, czlonek.imie, IF(wpis.IDopiekun is not null, opiekun.Imie, null)) as '_imie', IF(wpis.IDczlonek is not null, czlonek.nazwisko, IF(wpis.IDopiekun is not null, opiekun.nazwisko, null )) as '_nazwisko' from wpis left join opiekun on wpis.IDopiekun = opiekun.IDopiekun left join czlonek on wpis.IDczlonek = czlonek.IDczlonek where IDgrupa = ? order by post_time DESC");
						$stmt->bind_result($IDw,$IDo,$IDc, $text, $date, $imie, $nazwisko);
						$stmt->bind_param('i',$keyword);
						$stmt->execute();
						while($stmt->fetch()){
							echo "<div class = 'wydarzenie'>";
							echo "<h6>";
							echo $date." ".$nazwisko." ".$imie;
							echo "<div class = 'buttons'>";
							wpis::removewpis($_GET['keyword'],$IDw,$role);
							wpis::editwpis($_GET['keyword'],$IDw,$role);
							echo "</div>";
							echo "</h6>";
							echo "<div class = 'dane'>";
							echo $text;
							echo "</div>";
							echo "</div>";
						}
						$stmt->close();
					}
				?>
				</div>
		</div>
	</body>
</html>