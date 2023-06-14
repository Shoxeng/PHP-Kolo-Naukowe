<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if(!isset($_GET["keyword"],$_GET["keyword2"])){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}

$stmt = $con->prepare("SELECT ID FROM grupa left join (opiekun natural left join accounts) on grupa.IDopiekun = opiekun.IDopiekun where IDgrupa = ?");
$stmt->bind_param('i',$keyword);
$stmt->execute();
$stmt->bind_result($ID);
$stmt->fetch();
$stmt->close();
		
$stmt = $con->prepare("SELECT 1 from accounts where IDczlonek in (select IDczlonek from wpis where IDwpis = ?) and IDczlonek in (select IDczlonek from grupa where IDgrupa = ?) and ID = ?");
$stmt->bind_param('iii',$keyword2,$keyword, $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($valid);
$stmt->fetch();
$stmt->close();

if($role != 'admin' and $_SESSION['id'] != $ID and $valid){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}


$stmt = $con->prepare('DELETE FROM wpis WHERE IDwpis = ?');
$stmt->bind_param("i",$_GET["keyword2"]);
$stmt->execute();
$stmt->close();
header('Location: ../wpis/wpisy.php?keyword='.$_GET['keyword']);
exit();
?>