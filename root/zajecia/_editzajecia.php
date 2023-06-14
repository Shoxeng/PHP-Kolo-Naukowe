<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if(($role != 'opiekun' && $role != 'admin') or !isset($_POST['keyword'],$_POST['keyword2'])){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}

if ( !isset($_POST['dzien'],$_POST['Hour'] ) ) {
	// Could not get the data that should have been sent.
	header("Location: ../grupa/grupa.php?keyword=".$_POST['keyword']);
	exit();
}

$stmt = $con->prepare('UPDATE zajecia SET zajecia.dzien_tygodnia = ?, zajecia.godzina = ? WHERE zajecia.IDzajecia = ?');
$stmt->bind_param("ssi",$_POST['dzien'],$_POST['Hour'], $_POST['keyword']);
$stmt->execute();
$stmt->fetch();
$stmt->close();
header('Location:  ../grupa/grupa.php?keyword='.$_POST['keyword2']);
exit();

?>