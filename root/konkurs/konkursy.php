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
			<h2>Konkursy</h2>
			<div>
			<table>
			Aktualne konkursy
			<?php
			$stmt = $con->prepare("SELECT IDkonkurs, Przedmiot, Data, TIME_FORMAT(Godzina, '%H:%i') FROM konkurs where Data >= CURDATE() order by Data;");
			$stmt->execute();
			$stmt->bind_result($ID, $pr, $date, $godzina);
			while($stmt->fetch()){
				echo "<hr>";
				echo " Data: " . $date. " Godzina: " . $godzina. " Przedmiot: " . $pr;
				konkurs::removekonkurs($ID,$role);
				konkurs::editkonkurs($ID,$role);
				konkurs::viewkonkurs($ID,$role);
			}
			$stmt->close();
			?>
			<hr>
					<form action = "konkursy.php">
						Wyszukiwanie konkursów w bazie danych
						<br><input type = "text" name = "keyword">
						<input type = "submit" value = "Search">
					</form><br>
					<?php
					if(!empty($_GET['keyword'])){
						$keyword = $_GET["keyword"];
						$stmt = $con->prepare("SELECT IDkonkurs, Przedmiot, Data, TIME_FORMAT(Godzina, '%H:%i') FROM konkurs where Przedmiot RLIKE concat('^.*',?,'.*$') order by Data;");
						$stmt->bind_param("s",$keyword);
						$stmt->execute();
						$stmt->bind_result($ID, $pr, $date, $godzina);
						while($stmt->fetch() && $keyword != ''){
							echo "<hr>";
							echo " Data: " . $date. " Godzina: " . $godzina. " Przedmiot: " . $pr;
							konkurs::removekonkurs($ID,$role);
							konkurs::editkonkurs($ID,$role);
							konkurs::viewkonkurs($ID,$role);
						}
						$stmt->close();
					}
					?>
					<hr>
				<?php
				konkurs::addkonkurs($role);
				?>
				</table>
				</div>
		</div>
	</body>
</html>