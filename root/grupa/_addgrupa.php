<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'admin'){
	header('Location:  '.$path.'/homepage.php?err=no_acc');
	exit();
}

if ( !isset($_POST['name'],$_POST['IDo'] ) ) {
	// Could not get the data that should have been sent.
	header("Location: grupy.php?err=empty_fields");
	exit();
}


$stmt = $con->prepare('select max(IDgrupa) + 1 from grupa');
$stmt->bind_result($newid);
$stmt->execute();
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare('INSERT INTO grupa (IDgrupa, nazwa, IDopiekun) VALUES (?, ?, ?);');
$stmt->bind_param("isi", $newid, $_POST['name'], $_POST['IDo']);
$stmt->execute();
$stmt->fetch();
$stmt->close();
header('Location:  grupy.php');
exit();

?>