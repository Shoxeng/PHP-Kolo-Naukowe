<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'admin'){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}

if(!isset($_GET["keyword"])){
	header('Location:  uzytkownicy.php?err=empty_fields');
	exit();
}

$stmt = $con->prepare('select IDczlonek, IDopiekun from accounts where ID = ?');
$stmt->bind_param("i",$_GET["keyword"]);
$stmt->bind_result($IDc,$IDo);
$stmt->execute();
$stmt->fetch();
$stmt->close();
if(!is_null($IDo)){
	$stmt = $con->prepare('UPDATE accounts SET accounts.IDopiekun = null where ID = ?');
	$stmt->bind_param("i",$_GET["keyword"]);
	$stmt->execute();
	$stmt->close();
	
	$stmt = $con->prepare('DELETE FROM opiekun WHERE IDopiekun = ?');
	$stmt->bind_param("i",$IDo);
	$stmt->execute();
	$stmt->close();
	
	header('Location:  _removeuzytkownik.php?keyword='.$_GET["keyword"].'&keyword2='.$IDo);
	exit();
}

$stmt = $con->prepare('DELETE FROM uczestnik WHERE IDczlonek = ?');
$stmt->bind_param("i",$IDc);
$stmt->execute();
$stmt->close();

$stmt = $con->prepare('DELETE FROM czlonek_grupa WHERE IDczlonek = ?');
$stmt->bind_param("i",$IDc);
$stmt->execute();
$stmt->close();

$stmt = $con->prepare('DELETE FROM czlonek WHERE IDczlonek = ?');
$stmt->bind_param("i",$IDc);
$stmt->execute();
$stmt->close();

$stmt = $con->prepare('UPDATE grupa SET grupa.IDczlonek = null where IDczlonek = ?');
	$stmt->bind_param("i",$IDc);
	$stmt->execute();
	$stmt->close();

$stmt = $con->prepare('DELETE FROM accounts WHERE ID = ?');
$stmt->bind_param("i",$_GET["keyword"]);
$stmt->execute();
$stmt->close();
header('Location:  uzytkownicy.php?'.$IDo);
exit();
?>