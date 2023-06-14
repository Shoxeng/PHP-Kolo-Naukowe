<?php

Class zajecia{
	
	public static function editzajecia(int $keyword,int $IDs, String $role){
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = 'usbw';
		$DATABASE_NAME = 'k_naukowe';
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		$con->query("SET NAMES 'utf8'");
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		$stmt = $con->prepare("SELECT ID FROM grupa left join (opiekun natural left join accounts) on grupa.IDopiekun = opiekun.IDopiekun where IDgrupa = ?");
		$stmt->bind_param('i',$keyword);
		$stmt->execute();
		$stmt->bind_result($ID);
		$stmt->fetch();
		
		echo '<form action = "/zajecia/editzajecia.php" method = "post">';
		echo '<input type = "hidden" name = "keyword" value = '.$IDs.'>';
		echo '<input type = "hidden" name = "keyword2" value = '.$keyword.'>';
		if($ID == $_SESSION['id'] or $role == 'admin') echo '<input type = "submit" value = "Edit">';
		echo "</form>";
	}
	public static function addzajecia(int $keyword, String $role){
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = 'usbw';
		$DATABASE_NAME = 'k_naukowe';
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		$con->query("SET NAMES 'utf8'");
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		$stmt = $con->prepare("SELECT ID FROM grupa left join (opiekun natural left join accounts) on grupa.IDopiekun = opiekun.IDopiekun where IDgrupa = ?");
		$stmt->bind_param('i',$keyword);
		$stmt->execute();
		$stmt->bind_result($ID);
		$stmt->fetch();
		
		if($role == 'admin' or $ID == $_SESSION['id']){
			echo '<form action = "/zajecia/addzajecia.php" method = "post">';
			echo '<input type = "hidden" name = "keyword" value = '.$keyword.'>';
			echo '<input type = "submit" value = "Dodaj nowe zajęcia +">';
			echo '</form>';
			}	
		}	
	public static function removezajecia(int $keyword, int $IDs,String $role){
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = 'usbw';
		$DATABASE_NAME = 'k_naukowe';
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		$con->query("SET NAMES 'utf8'");
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		$stmt = $con->prepare("SELECT ID FROM grupa left join (opiekun natural left join accounts) on grupa.IDopiekun = opiekun.IDopiekun where IDgrupa = ?");
		$stmt->bind_param('i',$keyword);
		$stmt->execute();
		$stmt->bind_result($ID);
		$stmt->fetch();
		
		echo '<form action = "/zajecia/removezajecia.php">';
		echo '<input type = "hidden" name = "keyword" value = '.$IDs.'>';
		echo '<input type = "hidden" name = "keyword2" value = '.$keyword.'>';
		if($ID == $_SESSION['id'] or $role == 'admin') echo '<input type = "submit"  onclick="return confirm(\'Jesteś pewny, że chcesz usunąć te zajęcia?\')" value = "Remove -">';
		echo "</form>";	
	}
}

?>