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
				if(!empty($_GET)){
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
					<form action = "addtogrupa.php">
						Wyszukiwanie członków w bazie danych<i class="fas fa-image-portrait"></i>
						<br><input type = "text" name = "keyword2">
						<input type = "hidden" name = "keyword" value = <?echo $keyword?>>
						<input type = "submit" value = "Search">
					</form><br>
					<?php
					if(!empty($_GET["keyword2"])){
						$keyword2 = $_GET["keyword2"];
						$stmt = $con->prepare("SELECT IDczlonek, nazwisko, imie FROM czlonek natural left join czlonek_grupa where concat(imie,' ',nazwisko) RLIKE concat('^.*',?,'.*$') and IDczlonek not in (select IDczlonek from czlonek_grupa where IDgrupa = ?) order by nazwisko;");
						$stmt->bind_param("si",$keyword2,$keyword);
						$stmt->execute();
						$stmt->bind_result($ID, $nazwisko, $imie);
						while($stmt->fetch() && $keyword != ''){
							echo "<hr>";
							echo "Imie: " . $imie. " Nazwisko: " . $nazwisko ;
							echo '<form action = "_addtogrupa.php">';
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
					<form action = "grupy.php">
						<br></i>
						<input type = "hidden" name = "keyword" value = <?echo $keyword?>>
						<input type = "submit" value = "Return">
					</form><br>
					<div>
		</div>
	</body>
</html>