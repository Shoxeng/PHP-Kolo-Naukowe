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
			<h2>Grupy</h2>
			<div>
			<form action = "grupy.php">
						Wyszukiwanie grup w bazie danych<i class="fas fa-image-portrait"></i>
						<br><input type = "text" name = "keyword">
						<input type = "submit" value = "Search">
					</form>
			<table>
				<?php
					if(!empty($_GET["keyword"])){
						$keyword = $_GET["keyword"];
						$stmt = $con->prepare("select IDgrupa, nazwa from grupa where nazwa RLIKE concat('^.*',?,'.*$') order by nazwa");
						$stmt->bind_param('s',$keyword);
						$stmt->execute();
						$stmt->bind_result($IDs,$nazwa);
						while($stmt->fetch()){
							echo "<hr>";
							echo "Nazwa: " . $nazwa;
							grupa::removegrupa($IDs,$role);
							grupa::viewgrupa($IDs,$role);
							grupa::editgrupa($IDs,$role);
						}
					}
				?>
				<hr>
				</table>
				<?php
				grupa::addgrupa($role);
				?>
				</div>
		</div>
	</body>
</html>