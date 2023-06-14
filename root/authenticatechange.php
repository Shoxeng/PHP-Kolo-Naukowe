<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

if ( !isset($_POST['oldpassword'], $_POST['newpassword'], $_POST['repeatnewpassword']) ) {
	// Could not get the data that should have been sent.
	header('Location: changepassword.php?keyword=empty_fields');
	exit();
}

if($_POST["newpassword"] != $_POST["repeatnewpassword"] ){
	header('Location: changepassword.php?keyword=inc_new_pass');
	exit();
}

$stmt = $con->prepare('select password from accounts WHERE id = ?');
$stmt->bind_param("i", $_SESSION['id']);
$stmt->bind_result($password);
$stmt->execute();
$stmt->fetch();
$stmt->close();
if (password_verify($_POST['oldpassword'], $password)) {
		// Verification success! User has logged-in!
		// Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
		$_newpassword = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
		$stmt = $con->prepare('UPDATE accounts SET accounts.password = ? WHERE id = ?');
		$stmt->bind_param("si",$_newpassword, $_SESSION['id']);
		$stmt->execute();
		header('Location: homepage.php?keyword=succ_change');
	} else {
		// Incorrect password
		header('Location: changepassword.php?keyword=inc_pass');
	}

?>