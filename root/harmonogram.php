<?php
$path = $_SERVER['DOCUMENT_ROOT'];
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'usbw';
$DATABASE_NAME = 'k_naukowe';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
$con->query("SET NAMES 'utf8'");
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT IDopiekun,IDczlonek, role FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($IDt,$IDl,$role);
$stmt->fetch();
$stmt->close();
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
			<h2>Harmonogram</h2>
			<div class = "harmonogram">
			<?php
			if(!isset($_GET['keyword']) or !preg_match("/^-?[0-9]+$/",$_GET['keyword'])){
				$keyword = 0;
			}
			else{
				$keyword = $_GET['keyword'];
			}
			for($i = 0; $i < 31; $i++){
				$stmt = $con->prepare("SELECT DATE_ADD(CURDATE(), INTERVAL ? + ? DAY),nameofday(DAYOFWEEK(DATE_ADD(CURDATE(), INTERVAL ? + ? DAY)));");
				$stmt->bind_param("iiii", $keyword, $i, $keyword, $i);
				$stmt->bind_result($date, $dw);
				$stmt->execute();
				$stmt->fetch();
				$stmt->close();
				echo "<div class = 'date'>";
				echo "<p>".$dw.", ".$date."</p>";
				echo "<table>";
				$stmt = $con->prepare("select grupa.Nazwa, TIME_FORMAT(zajecia.Godzina, '%H:%i') from zajecia left join grupa on zajecia.IDgrupa =grupa.IDgrupa where (grupa.IDopiekun in (select IDopiekun from accounts where ID = ?) or (grupa.IDgrupa in (select IDgrupa from czlonek_grupa where IDczlonek in (select IDczlonek from accounts where ID = ?)))) and day_to_num(zajecia.Dzien_tygodnia) = DAYOFWEEK(?) order by godzina;");
				$stmt->bind_result($nazwa, $godzina);
				$stmt->bind_param("iis", $_SESSION['id'], $_SESSION['id'], $date);
				$stmt->execute();
				while($stmt->fetch()){
					echo "<td>";
					echo $nazwa.": ".$godzina;
					echo "</td>";
				}
				$stmt->close();
				echo "</table>";
				echo "<table>";
				$stmt = $con->prepare("select konkurs.przedmiot, TIME_FORMAT(konkurs.Godzina, '%H:%i') from konkurs left join grupa on konkurs.IDgrupa =grupa.IDgrupa where (grupa.IDopiekun in (select IDopiekun from accounts where ID = ?) or (grupa.IDgrupa in (select IDgrupa from czlonek_grupa where IDczlonek in (select IDczlonek from accounts where ID = ?)))) and konkurs.data = ? order by godzina;");
				$stmt->bind_result($nazwa, $godzina);
				$stmt->bind_param("iis", $_SESSION['id'], $_SESSION['id'], $date);
				$stmt->execute();
				while($stmt->fetch()){
					echo "<td>";
					echo $nazwa.": ".$godzina;
					echo "</td>";
				}
				$stmt->close();
				echo "</table>";
				echo "<table>";
				$stmt = $con->prepare("select wydarzenie.nazwa, TIME_FORMAT(wydarzenie.Godzina, '%H:%i') from wydarzenie left join grupa on wydarzenie.IDgrupa =grupa.IDgrupa where (grupa.IDopiekun in (select IDopiekun from accounts where ID = ?) or (grupa.IDgrupa in (select IDgrupa from czlonek_grupa where IDczlonek in (select IDczlonek from accounts where ID = ?)))) and wydarzenie.data = ? order by godzina;");
				$stmt->bind_result($nazwa, $godzina);
				$stmt->bind_param("iis", $_SESSION['id'], $_SESSION['id'], $date);
				$stmt->execute();
				while($stmt->fetch()){
					echo "<td>";
					echo $nazwa.": ".$godzina;
					echo "</td>";
				}
				$stmt->close();
				echo "</table>";
				echo "</div>";
			}
			
			?>
			
			<form action = "harmonogram.php">
				<input type = "hidden" name = "keyword" value = <?echo $keyword - 1?>>
				<input type = "submit" value = "<">
			</form>
			<form action = "harmonogram.php">
				<input type = "hidden" name = "keyword" value = <?echo $keyword + 1?>>
				<input type = "submit" value = ">">
			</form><br>
			</div>
			
		</div>
	</body>
</html>