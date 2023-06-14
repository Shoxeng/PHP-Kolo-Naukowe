<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if(($role != 'opiekun' && $role != 'admin') or !isset($_POST['keyword'])){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}

if ( !isset($_POST['dzien'],$_POST['Hour'] ) ) {
	// Could not get the data that should have been sent.
	header("Location: ../grupa/grupa.php?keyword=".$_POST['keyword']);
	exit();
}


$stmt = $con->prepare('select max(IDzajecia) + 1 from zajecia');
$stmt->bind_result($newid);
$stmt->execute();
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare('INSERT INTO zajecia (IDzajecia, IDgrupa, dzien_tygodnia, godzina) VALUES (?, ?,?,?);');
$stmt->bind_param("isss", $newid, $_POST['keyword'],$_POST['dzien'],$_POST['Hour']);
$stmt->execute();
$stmt->fetch();
$stmt->close();
header('Location:  ../grupa/grupa.php?keyword='.$_POST['keyword']);
exit();

?>