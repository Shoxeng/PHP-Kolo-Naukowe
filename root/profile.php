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
$stmt = $con->prepare('SELECT email,role,IF(accounts.IDczlonek is not null, czlonek.imie, IF(accounts.IDopiekun is not null, opiekun.Imie, null)) as "_imie", IF(accounts.IDczlonek is not null, czlonek.nazwisko, IF(accounts.IDopiekun is not null, opiekun.nazwisko, null )) as "_nazwisko" FROM (accounts left join czlonek on accounts.IDczlonek = czlonek.IDczlonek) left join opiekun on opiekun.IDopiekun = accounts.IDopiekun WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($email, $role, $imie, $nazwisko);
$stmt->fetch();
$stmt->close();
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
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
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Username:</td>
						<td><?=$_SESSION['name']?></td>
					</tr>
					<tr>
						<td>Role:</td>
						<td><?=$role?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=$email?></td>
					</tr>
					<?php
					if(!is_null($imie)){
						echo "<tr>";
						echo "<td>Imie:</td>";
						echo "<td>".$imie."</td>";
						echo "</tr>";
					}
					if(!is_null($nazwisko)){
						echo "<tr>";
						echo "<td>Nazwisko:</td>";
						echo "<td>".$nazwisko."</td>";
						echo "</tr>";
					}
					
					
					?>
					<tr>
							<td>
							<form action = "changepassword.php">
							<input type = "submit" value = "Change password">
							</form>
							</td>
							</tr>
				</table>
			</div>
		</div>
	</body>
</html>