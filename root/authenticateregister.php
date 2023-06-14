<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'usbw';
$DATABASE_NAME = 'k_naukowe';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
$con->query("SET NAMES 'utf8'");
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ( !isset($_POST['username'], $_POST['email'],$_POST['password'],$_POST['repeatpassword'],$_POST['imie'],$_POST['nazwisko'],$_POST['klasa']) ) {
	// Could not get the data that should have been sent.
	header("Location: register.php?err=empty_fields");
	exit();
}

if($_POST['password'] != $_POST['repeatpassword']){
	header("Location: register.php?err=inc_new_pass");
	exit();
}

$stmt = $con->prepare('select count(*) from accounts where username = ?');
$stmt->bind_param("s",$_POST['username'] );
$stmt->bind_result($valid);
$stmt->execute();
$stmt->fetch();
$stmt->close();

if($valid != 0){
	header("Location: register.php?err=ex_us");
	exit();
}

$stmt = $con->prepare('select count(*) from accounts where email = ?');
$stmt->bind_param("s",$_POST['email'] );
$stmt->bind_result($valid);
$stmt->execute();
$stmt->fetch();
$stmt->close();

if($valid != 0){
	header("Location: register.php?err=ex_em");
	exit();
}

$stmt = $con->prepare('select max(IDczlonek) + 1 from czlonek');
$stmt->bind_result($newid);
$stmt->execute();
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare('INSERT INTO czlonek (IDczlonek,imie, nazwisko, klasa) VALUES (?, ?, ?, ?);');
$stmt->bind_param("isss",$newid ,$_POST['imie'], $_POST['nazwisko'], $_POST['klasa'] );
$stmt->execute();
$stmt->fetch();
$stmt->close();

$_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$stmt = $con->prepare('INSERT INTO accounts (username,email, password,role, IDczlonek) VALUES (?, ?, ?, "czlonek", ?);');
$stmt->bind_param("sssi", $_POST['username'], $_POST['email'], $_password, $newid );
$stmt->execute();
$stmt->fetch();
$stmt->close();
header('Location:  index.html');
exit();

?>