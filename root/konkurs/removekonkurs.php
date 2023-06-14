<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'admin' && $role != 'opiekun'){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}

if(!isset($_GET["keyword"])){
	header('Location:  konkursy.php?err=empty_fields');
	exit();
}

$stmt = $con->prepare('DELETE FROM uczestnik WHERE IDkonkurs = ?');
$stmt->bind_param("i",$_GET["keyword"]);
$stmt->execute();
$stmt->close();
$stmt = $con->prepare('DELETE FROM konkurs WHERE IDkonkurs = ?');
$stmt->bind_param("i",$_GET["keyword"]);
$stmt->execute();
$stmt->close();
header('Location:  konkursy.php');
exit();
?>