<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if(!isset($_POST['keyword'],$_POST['text'])){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}

$stmt = $con->prepare('select IDczlonek, IDopiekun from accounts where ID = ? and (IDczlonek in (select IDczlonek from grupa where IDgrupa = ?) or IDopiekun in (select IDopiekun from grupa where IDgrupa = ?))');
$stmt->bind_param("iii",$_SESSION['id'],$_POST['keyword'],$_POST['keyword']);
$stmt->bind_result($IDc, $IDo);
$stmt->execute();
$stmt->fetch();
$stmt->close();

if(($role != 'admin' and (is_null($IDc) and is_null($IDo)))){
	header('Location:  ../grupa/grupa.php?keyword='.$_POST['keyword']);
	exit();
}

$stmt = $con->prepare('select max(IDwpis) + 1 from wpis');
$stmt->bind_result($newid);
$stmt->execute();
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare('INSERT INTO wpis (IDwpis, IDgrupa, IDopiekun, IDczlonek,text,post_time) VALUES (?, ?,?,?,?,now());');
$stmt->bind_param("iiiis", $newid, $_POST['keyword'],$IDo,$IDc, $_POST['text']);
$stmt->execute();
$stmt->fetch();
$stmt->close();
header('Location:  ../wpis/wpisy.php?keyword='.$_POST['keyword']);
exit();

?>