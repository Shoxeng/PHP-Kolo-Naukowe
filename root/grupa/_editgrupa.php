<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'opiekun' && $role != 'admin'){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}

if ( !isset($_POST['name'], $_POST['keyword'], $_POST['IDo']) ) {
	// Could not get the data that should have been sent.
	header("Location: grupy.php?err=empty_fields");
	exit();
}

$stmt = $con->prepare('UPDATE grupa SET grupa.nazwa = ?, grupa.IDopiekun = ? WHERE grupa.IDgrupa = ?');
$stmt->bind_param("sii", $_POST['name'],$_POST['IDo'],$_POST['keyword']);
$stmt->execute();
$stmt->fetch();
$stmt->close();
header('Location:  grupy.php');
exit();

?>