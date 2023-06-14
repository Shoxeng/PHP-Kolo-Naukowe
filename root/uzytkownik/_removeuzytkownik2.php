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

$stmt = $con->prepare('UPDATE grupa SET grupa.IDopiekun = ? where IDopiekun = ?');
$stmt->bind_param("ii",$_GET["IDg"],$_GET["keyword2"]);
$stmt->execute();
$stmt->fetch();
$stmt->close();

header('Location:  removeuzytkownik.php?keyword='.$keyword);
exit();
?>