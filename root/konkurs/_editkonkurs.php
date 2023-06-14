<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'opiekun' && $role != 'admin'){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}

if ( !isset($_POST['name'], $_POST['date'], $_POST['time'], $_POST['opis'],$_POST['IDg'], $_POST['keyword'] ) ) {
	// Could not get the data that should have been sent.
	header("Location: konkursy.php?err=empty_fields");
	exit();
}

$stmt = $con->prepare('UPDATE konkurs SET konkurs.data = ?, konkurs.godzina = ?, konkurs.przedmiot = ?, konkurs.opis  = ?, konkurs.IDgrupa = ? WHERE konkurs.IDkonkurs = ?');
$dater=date("Y-m-d",strtotime($_POST['date']));
$stmt->bind_param("ssssii", $dater,$_POST['time'],$_POST['name'],$_POST['opis'],$_POST['IDg'],$_POST['keyword']);
$stmt->execute();
$stmt->fetch();
$stmt->close();
header('Location:  konkursy.php');
exit();

?>