<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'opiekun' && $role != 'admin'){
	header('Location:  '.$path.'/homepage.php?keyword=no_acc');
	exit();
}

$stmt = $con->prepare('INSERT INTO czlonek_grupa (IDczlonek, IDgrupa) VALUES (?, ?);');
$stmt->bind_param("ii",$_GET["keyword"], $_GET["keyword2"]);
$stmt->execute();
$stmt->close();
header('Location:  grupa.php?keyword='.$_GET["keyword2"]);
exit();
?>