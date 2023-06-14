<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Change password</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"/>
		<link rel="stylesheet" href="/style.css"/>
	</head>
	<body>
		<?php
			if(!empty($_GET)){
				$keyword = $_GET["keyword"];
				if($keyword == "inc_pass"){
					echo "<script>";
					echo "alert('Podano niepoprawne hasło')";
					echo "</script>";
				}
				if($keyword == "inc_new_pass"){
					echo "<script>";
					echo "alert('Nowe podane hasło nie powtarza się')";
					echo "</script>";
				}
				if($keyword == "empty_fields"){
					echo "<script>";
					echo "alert('Wypełnij wszystkie pola')";
					echo "</script>";
				}
			}
		?>
		<div class="login">
			<h1>Change password</h1>
			<form action="authenticatechange.php" method="post">
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="oldpassword" placeholder="old password" id="oldpassword" required>
								<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="newpassword" placeholder="new password" id="newpassword" required>
								<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="repeatnewpassword" placeholder="repeat new password" id="repeatnewpassword" required>
				<input type="submit" value="Change password">
			</form>
		</div>
	</body>
</html>