<html>
	<head>
		<meta charset="utf-8">
		<title>Rejestracja</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"/>
		<link rel="stylesheet" href="/style.css"/>
	</head>
	<body>
		<?php
			if(!empty($_GET["err"])){
				$err = $_GET["err"];
				if($err == "inc_new_pass"){
					echo "<script>";
					echo "alert('Podane hasła nie powtarzają się')";
					echo "</script>";
				}
				if($err == "empty_fields"){
					echo "<script>";
					echo "alert('Wypełnij wszystkie pola')";
					echo "</script>";
				}
				if($err == "ex_us"){
					echo "<script>";
					echo "alert('Nazwa użytkownika już istnieje')";
					echo "</script>";
				}
				if($err == "ex_em"){
					echo "<script>";
					echo "alert('Email już istnieje w systemie')";
					echo "</script>";
				}
			}
		?>
		<div class="login">
			<h1>Rejestracja</h1>
			
				<?php 
				echo '<form action="authenticateregister.php" method="post">';
				echo' <input type="text" name="imie" placeholder="imie" id="imie" required>';
				echo' <input type="text" name="nazwisko" placeholder="nazwisko" id="nazwisko" required>';
				echo' <input type="text" name="klasa" placeholder="klasa" id="klasa" required>';
				echo' <input type="text" name="username" placeholder="username" id="username" required>';
				echo' <input type="text" name="email" placeholder="email" id="email" required>';
				echo' <input type="password" name="password" placeholder="password" id="password" required>';
				echo' <input type="password" name="repeatpassword" placeholder="repeat password" id="repeatpassword" required>';
				echo '<input type="submit" value="Zarejestruj się">';
				echo '</form>';
				?>
				
			
		</div>
	</body>
</html>