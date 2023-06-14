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
			<h2>Wydarzenia</h2>
			<div class = "wydarzenia">
			<?php
			wydarzenie::addwydarzenie($role);
			?>
			
			
			<?php
			wydarzenie::viewwydarzenie($role, $con);
			?>
			</div>	
		</div>

	</body>
</html>