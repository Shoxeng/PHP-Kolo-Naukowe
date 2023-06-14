<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'opiekun' && $role != 'admin'){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}

if ( !isset($_POST['nazwa'], $_POST['opis'], $_POST['date'],$_POST['hour'],$_POST['IDg'],$_POST['keyword'] ) ) {
	// Could not get the data that should have been sent.
	header("Location: wydarzenie.php");
	exit();
}

if (empty($_FILES["image"]["name"])){
	$file = null;
}
else{
	$fileName = basename($_FILES["image"]["name"]); 
	$fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
    $allowTypes = array('jpg','png','jpeg','gif'); 
    if(in_array($fileType, $allowTypes)){ 
		$image = $_FILES['image']['tmp_name']; 
        $imgContent = file_get_contents($image);
	}
	else{
		header("Location: ewydarzenie.php");
		exit();
	}
}

$stmt = $con->prepare('UPDATE wydarzenie SET wydarzenie.nazwa = ?, wydarzenie.opis = ?,wydarzenie.data = ?, wydarzenie.godzina = ?, wydarzenie.image = ?, wydarzenie.IDgrupa = ?, wydarzenie.post_time = NOW() WHERE wydarzenie.IDwydarzenie = ?;');
$stmt->bind_param("sssssii", $_POST['nazwa'], $_POST['opis'],$_POST['date'],$_POST['hour'],$file,$_POST['IDg'],$_POST['keyword']);
if($stmt->execute()){
	$stmt->close();
	header('Location:  wydarzenia.php');
	exit();
}
else{
	$stmt->close();
	header('Location:  editwydarzenie.php');
	exit();
}


?>