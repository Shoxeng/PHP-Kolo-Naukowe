<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'opiekun' && $role != 'admin'){
	header('Location:  ../homepage.php?keyword=no_acc');
	exit();
}

$stmt = $con->prepare('DELETE FROM uczestnik WHERE uczestnik.IDczlonek = ? AND uczestnik.IDkonkurs = ?');
$stmt->bind_param("ii",$_GET["keyword"], $_GET["keyword2"]);
$stmt->execute();
$stmt->close();
header('Location:  konkurs.php?keyword='.$_GET["keyword2"]);
exit();
?>