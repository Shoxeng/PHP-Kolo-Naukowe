<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include $path.'/_startsession.php';

?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Edytuj wpis</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"/>
		<link rel="stylesheet" href="/style.css"/>
	</head>
	<body>
		<?php
			if(!empty($_GET['err'])){
				$keyword = $_GET["err"];
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
			<h1>Edytuj Wpis</h1>
			<form action="_editwpis.php" method="post">
				<input type = 'hidden' name = 'keyword' value = <?=$_POST['keyword']?>>
				<input type = 'hidden' name = 'keyword2' value = <?=$_POST['keyword2']?>>
				<textarea name="text" placeholder="text" id="text"></textarea>
				<input type="submit" value="Edytuj Wpis">
			</form>
		</div>
	</body>
</html>