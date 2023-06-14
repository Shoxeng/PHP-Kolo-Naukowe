<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if(!isset($_POST["keyword"],$_POST["keyword2"],$_POST["text"])){
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

$stmt = $con->prepare('select IDczlonek, IDopiekun from accounts where ID = ? and (IDczlonek in (select IDczlonek from grupa where IDgrupa = ?) or IDopiekun in (select IDopiekun from grupa where IDgrupa = ?))');
$stmt->bind_param("iii",$_SESSION['id'],$_POST['keyword'],$_POST['keyword']);
$stmt->bind_result($IDc, $IDo);
$stmt->execute();
$stmt->fetch();
$stmt->close();

if($role != 'admin' and $_SESSION['id'] != $ID and $valid){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}


$stmt = $con->prepare('UPDATE wpis SET wpis.IDczlonek = ?, wpis.IDopiekun = ?, wpis.text = ?, post_time = now() WHERE wpis.IDwpis = ?');
$stmt->bind_param("iisi",$IDc,$IDo,$_POST['text'],$_POST['keyword2']);
$stmt->execute();
$stmt->close();
header('Location: ../wpis/wpisy.php?keyword='.$_POST['keyword']);
exit();
?>