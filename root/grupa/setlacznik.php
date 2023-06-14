<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'opiekun' && $role != 'admin'){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}

if(!isset($_GET['keyword'],$_GET['keyword2'])){
	header('Location:  ../homepage.php?keyword=no_acc');
	exit();
}

$stmt = $con->prepare('UPDATE grupa SET grupa.IDczlonek = ? WHERE grupa.IDgrupa = ?');
$stmt->bind_param("ii", $_GET['keyword'],$_GET['keyword2']);
$stmt->execute();
$stmt->fetch();
$stmt->close();
header('Location:  grupa.php?keyword='.$_GET['keyword2']);
exit();

?>