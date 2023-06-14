<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'opiekun' && $role != 'admin'){
	header('Location:  ../homepage.php?keyword=no_acc');
	exit();
}
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"/>
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
					<form action = "addtokonkurs.php">
						Wyszukiwanie członków w bazie danych<i class="fas fa-image-portrait"></i>
						<br><input type = "text" name = "keyword2">
						<input type = "hidden" name = "keyword" value = <?echo $keyword?>>
						<input type = "submit" value = "Search">
					</form><br>
					<?php
					if(!empty($_GET["keyword2"])){
						$keyword2 = $_GET["keyword2"];
						$stmt = $con->prepare("SELECT IDczlonek, nazwisko, imie FROM konkurs left join (czlonek natural left join czlonek_grupa) on konkurs.IDgrupa = czlonek_grupa.IDgrupa where concat(imie,' ',nazwisko) RLIKE concat('^.*',?,'.*$') and IDczlonek not in (select IDczlonek from uczestnik where IDkonkurs = ?) and IDkonkurs = ? order by nazwisko;");
						$stmt->bind_param("sii",$keyword2,$keyword,$keyword);
						$stmt->execute();
						$stmt->bind_result($ID, $nazwisko, $imie);
						while($stmt->fetch() && $keyword != ''){
							echo "<hr>";
							echo "Imie: " . $imie. " Nazwisko: " . $nazwisko ;
							echo '<form action = "_addtokonkurs.php">';
							echo '<input type = "hidden" name = "keyword" value = '.$ID.'>';
							echo '<input type = "hidden" name = "keyword2" value = '.$keyword.'>';
							echo '<input type = "submit" value = "Add +">';
							echo "</form>";
							echo "<br>";
						}
						$stmt->close();
					}
					?>
					<hr>
				</table>
					<form action = "konkurs.php">
						<br></i>
						<input type = "hidden" name = "keyword" value = <?echo $keyword?>>
						<input type = "submit" value = "Return">
					</form><br>
					<div>
		</div>
	</body>
</html>