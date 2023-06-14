<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if($role != 'opiekun' && $role != 'admin'){
	header('Location:  ../homepage.php?err=no_acc');
	exit();
}

if ( !isset($_POST['nazwa'], $_POST['opis'], $_POST['date'],$_POST['hour'],$_POST['IDg'] ) ) {
	// Could not get the data that should have been sent.
	header("Location: addwydarzenie.php?err=empty_fields");
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
		header("Location: addwydarzenie.php?err=empty_fields456");
		exit();
	}
}

$stmt = $con->prepare('select max(IDwydarzenie) + 1 from wydarzenie');
$stmt->bind_result($newid);
$stmt->execute();
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare('INSERT INTO wydarzenie (IDwydarzenie,nazwa, opis, data, godzina,image,IDgrupa, post_time) VALUES (?, ?, ?, ?, ?,?,?, now());');
$date=date("Y-m-d",strtotime($_POST['datarozpoczecia']));
$stmt->bind_param("isssssi", $newid, $_POST['nazwa'], $_POST['opis'],$_POST['date'],$_POST['hour'],$file,$_POST['IDg']);
if($stmt->execute()){
	$stmt->close();
	header('Location:  wydarzenia.php');
	exit();
}
else{
	$stmt->close();
	header('Location:  addwydarzenie.php?err=file_fail');
	exit();
}


?>