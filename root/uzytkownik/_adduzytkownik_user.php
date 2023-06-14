<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'admin'){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}

if ( !isset($_POST['username'], $_POST['email'],$_POST['password'],$_POST['repeatpassword'],$_POST['imie'],$_POST['nazwisko'],$_POST['klasa']) ) {
	// Could not get the data that should have been sent.
	header("Location: adduzytkownik.php?err=empty_fields");
	exit();
}

if($_POST['password'] != $_POST['repeatpassword']){
	header("Location: adduzytkownik.php?err=inc_new_pass");
	exit();
}

$stmt = $con->prepare('select count(*) from accounts where username = ?');
$stmt->bind_param("s",$_POST['username'] );
$stmt->bind_result($valid);
$stmt->execute();
$stmt->fetch();
$stmt->close();

if($valid != 0){
	header("Location: adduzytkownik.php?err=ex_us");
	exit();
}

$stmt = $con->prepare('select count(*) from accounts where email = ?');
$stmt->bind_param("s",$_POST['email'] );
$stmt->bind_result($valid);
$stmt->execute();
$stmt->fetch();
$stmt->close();

if($valid != 0){
	header("Location: adduzytkownik.php?err=ex_em");
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
header('Location:  uzytkownicy.php');
exit();

?>