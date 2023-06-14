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
						$stmt = $con->prepare("SELECT przedmiot,imie, nazwisko FROM konkurs natural left join grupa natural left join opiekun where IDkonkurs = ?;");
						$stmt->bind_param("s",$keyword);
						$stmt->execute();
						$stmt->bind_result($nazwa, $oimie,$onazwisko);
						$stmt->fetch();
						$stmt->close();
				}
				else{
					header('Location:  konkursy.php');
					exit();
				}
			?>
			<h2>Konkurs: 
			<?php
			echo $nazwa;
			?>
			</h2>
			<div>
			<table>
				<?php
				echo "Opiekun: ".$onazwisko." ".$oimie;
				?>
				<hr>
				<td>Wyniki:</td>
			</table>
				<table>
				<?php
					if(!empty($_GET)){
						$keyword = $_GET["keyword"];
						$stmt = $con->prepare("select IDczlonek,imie, nazwisko, miejsce from uczestnik natural left join czlonek where IDkonkurs = ? order by miejsce;");
						$stmt->bind_param('i',$keyword);
						$stmt->execute();
						$stmt->bind_result($IDs, $imie, $nazwisko, $wynik);
						while($stmt->fetch()){
							echo "<hr>";
							echo $nazwisko." ".$imie. " ";
							konkurs::editwynik($IDs,$keyword,$wynik,$role);
						}
					}
				?>
				<hr>
				</table>
				<table>
				<td>Zapisani uczestnicy:</td>
				</table>
				<table>

				<?php
					if(!empty($_GET)){
						$keyword = $_GET["keyword"];
						$stmt = $con->prepare("select IDczlonek, imie,nazwisko from uczestnik natural left join czlonek where IDkonkurs = ? order by nazwisko;");
						$stmt->bind_param('i',$keyword);
						$stmt->execute();
						$stmt->bind_result($IDs,$imie, $nazwisko);
						while($stmt->fetch()){
							echo "<hr>";
							echo $nazwisko." ".$imie;
							konkurs::removefromkonkurs($IDs,$keyword,$role);
						}
					}
				?>
				<hr>
				<?php
				konkurs::addtokonkurs($role,$keyword);
				?>
				</table>
			</div>
		</div>
	</body>
</html>