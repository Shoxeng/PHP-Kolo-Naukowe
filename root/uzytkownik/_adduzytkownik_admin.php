<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'admin'){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}

if ( !isset($_POST['username'], $_POST['email'],$_POST['password'],$_POST['repeatpassword']) ) {
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

$_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$stmt = $con->prepare('INSERT INTO accounts (username,email, password,role) VALUES (?, ?, ?, "admin");');
$stmt->bind_param("sss", $_POST['username'], $_POST['email'], $_password );
$stmt->execute();
$stmt->fetch();
$stmt->close();
header('Location:  uzytkownicy.php');
exit();

?>