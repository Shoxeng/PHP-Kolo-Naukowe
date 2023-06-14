<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';
?>


<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
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
			<?php
				if(!empty($_GET["keyword"])){
						$keyword = $_GET["keyword"];
						$stmt = $con->prepare("SELECT nazwa,imie, nazwisko FROM grupa natural left join opiekun where IDgrupa = ?;");
						$stmt->bind_param("s",$keyword);
						$stmt->execute();
						$stmt->bind_result($nazwa, $oimie,$onazwisko);
						$stmt->fetch();
						$stmt->close();
				}
				else{
					header('Location:  grupy.php');
					exit();
				}
			?>
			<h2>Grupa: 
			<?php
			echo $nazwa;
			?>
			</h2>
			<div>
			<table>
				<?php
				echo " Opiekun: ".$onazwisko." ".$oimie."<br><br>";
				wpis::viewwpisy($_GET["keyword"], $role);
				?>
				<hr>
			</table>
				<table>
				<td>Członkowie:</td>
				</table>
				<table>
				<?php
					if(!empty($_GET)){
						$keyword = $_GET["keyword"];
						$stmt = $con->prepare("select IDczlonek, imie,nazwisko, IF(IDczlonek in (select IDczlonek from grupa where IDgrupa = ?),'Łącznik',null) from czlonek_grupa natural left join czlonek where IDgrupa = ? order by nazwisko;");
						$stmt->bind_param('ii',$keyword,$keyword);
						$stmt->execute();
						$stmt->bind_result($IDs,$imie, $nazwisko,$cl);
						while($stmt->fetch()){
							echo "<hr>";
							echo $nazwisko." ".$imie." ".$cl;
							grupa::removefromgrupa($IDs,$keyword,$role);
							grupa::setlacznik($IDs,$keyword,$role);
						}
					}
				?>
				<hr>
				<?php
				grupa::addtogrupa($role,$keyword);
				?>
				</table>
				<table>
				<td>Zajęcia:</td>
				</table>
				<table>
				<?php
					if(!empty($_GET)){
						$keyword = $_GET["keyword"];
						$stmt = $con->prepare("select IDzajecia, dzien_tygodnia, TIME_FORMAT(Godzina, '%H:%i') from zajecia where IDgrupa = ?;");
						$stmt->bind_param('i',$keyword);
						$stmt->execute();
						$stmt->bind_result($ID, $d, $h);
						while($stmt->fetch()){
							echo "<hr>";
							echo " Dzień tygodnia: " . $d. " Godzina: " . $h;
							zajecia::removezajecia($keyword,$ID,$role);
							zajecia::editzajecia($keyword,$ID,$role);
						}
					}
				?>
				<hr>
				<?php
				zajecia::addzajecia($_GET['keyword'],$role);
				?>
				</table>

			</div>
		</div>
	</body>
</html>