<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'admin' and $role != 'opiekun'){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}

if(!isset($_GET["keyword"])){
	header('Location:  grupy.php?err=empty_fields');
	exit();
}

$stmt = $con->prepare('DELETE FROM zajecia WHERE IDgrupa = ?');
$stmt->bind_param("i",$_GET["keyword"]);
$stmt->execute();
$stmt->close();
$stmt = $con->prepare('DELETE FROM wydarzenie WHERE IDgrupa = ?');
$stmt->bind_param("i",$_GET["keyword"]);
$stmt->execute();
$stmt->close();
$stmt = $con->prepare('DELETE FROM wpis WHERE IDgrupa = ?');
$stmt->bind_param("i",$_GET["keyword"]);
$stmt->execute();
$stmt->close();
$stmt = $con->prepare('DELETE FROM uczestnik WHERE IDczlonek in (select IDczlonek from czlonek_grupa natural left join czlonek where IDgrupa = ?)');
$stmt->bind_param("i",$_GET["keyword"]);
$stmt->execute();
$stmt->close();
$stmt = $con->prepare('DELETE FROM czlonek_grupa WHERE IDgrupa = ?');
$stmt->bind_param("i",$_GET["keyword"]);
$stmt->execute();
$stmt->close();
$stmt = $con->prepare('DELETE FROM konkurs WHERE IDgrupa = ?');
$stmt->bind_param("i",$_GET["keyword"]);
$stmt->execute();
$stmt->close();
$stmt = $con->prepare('DELETE FROM grupa WHERE IDgrupa = ?');
$stmt->bind_param("i",$_GET["keyword"]);
$stmt->execute();
$stmt->close();
header('Location:  grupy.php');
exit();
?>