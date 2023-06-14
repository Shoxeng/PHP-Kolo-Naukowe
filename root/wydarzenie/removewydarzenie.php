<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'admin' and $role != 'opiekun'){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}

if(!isset($_GET["keyword"])){
	header('Location:  wydarzenia.php');
	exit();
}



$stmt = $con->prepare('DELETE FROM wydarzenie WHERE IDwydarzenie = ?');
$stmt->bind_param("i",$_GET["keyword"]);
$stmt->execute();
$stmt->close();
header('Location: wydarzenia.php');
exit();
?>