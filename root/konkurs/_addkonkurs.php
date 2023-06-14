<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'opiekun' && $role != 'admin'){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}

if ( !isset($_POST['name'], $_POST['date'], $_POST['time'], $_POST['opis'],$_POST['IDg'] ) ) {
	// Could not get the data that should have been sent.
	header("Location: konkursy.php?err=empty_fields");
	exit();
}

$stmt = $con->prepare('select max(IDkonkurs) + 1 from konkurs');
$stmt->bind_result($newid);
$stmt->execute();
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare('INSERT INTO konkurs (IDkonkurs, data, godzina, przedmiot, opis, IDgrupa) VALUES (?, ?,?,?,?,?);');
$dater=date("Y-m-d",strtotime($_POST['date']));
$stmt->bind_param("issssi", $newid,$dater,$_POST['time'],$_POST['name'],$_POST['opis'],$_POST['IDg']);
$stmt->execute();
$stmt->fetch();
$stmt->close();
header('Location:  konkursy.php');
exit();

?>