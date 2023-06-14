<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'admin' and $role != 'opiekun'){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}

if(!isset($_GET["keyword"],$_GET["keyword2"])){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}



$stmt = $con->prepare('DELETE FROM zajecia WHERE IDzajecia = ?');
$stmt->bind_param("i",$_GET["keyword"]);
$stmt->execute();
$stmt->close();
header('Location: ../grupa/grupa.php?keyword='.$_GET['keyword2']);
exit();
?>