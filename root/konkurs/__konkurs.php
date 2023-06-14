<?php

Class konkurs{
	
	public static function editkonkurs(int $IDs, String $role){
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = 'usbw';
		$DATABASE_NAME = 'k_naukowe';
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		$con->query("SET NAMES 'utf8'");
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		$stmt = $con->prepare("SELECT ID FROM (konkurs natural left join grupa) left join (opiekun natural left join accounts) on grupa.IDopiekun = opiekun.IDopiekun where IDkonkurs = ?");
		$stmt->bind_param('i',$IDs);
		$stmt->execute();
		$stmt->bind_result($ID);
		$stmt->fetch();
		
		echo '<form action = "/konkurs/editkonkurs.php">';
		echo '<input type = "hidden" name = "keyword" value = '.$IDs.'>';
		if($ID == $_SESSION['id'] or $role == 'admin') echo '<input type = "submit" value = "Edit">';
		echo "</form>";
	}
	public static function addkonkurs(String $role){
		if($role == 'admin' or $role == 'opiekun'){
			echo '<form action = "/konkurs/addkonkurs.php" method = "post">';
			echo '<input type = "submit" value = "Dodaj nowy konkurs +">';
			echo '</form>';
			}	
		}	
	public static function removekonkurs(int $IDs,String $role){
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = 'usbw';
		$DATABASE_NAME = 'k_naukowe';
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		$con->query("SET NAMES 'utf8'");
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		$stmt = $con->prepare("SELECT ID FROM (konkurs natural left join grupa) left join (opiekun natural left join accounts) on grupa.IDopiekun = opiekun.IDopiekun where IDkonkurs = ?");
		$stmt->bind_param('i',$IDs);
		$stmt->execute();
		$stmt->bind_result($ID);
		$stmt->fetch();
		
		echo '<form action = "/konkurs/removekonkurs.php">';
		echo '<input type = "hidden" name = "keyword" value = '.$IDs.'>';
		if($ID == $_SESSION['id'] or $role == 'admin') echo '<input type = "submit"  onclick="return confirm(\'Jesteś pewny, że chcesz usunąć ten konkurs?\')" value = "Remove -">';
		echo "</form>";	
	}
	public static function viewkonkurs(int $IDs,String $role){
		echo '<form action = "/konkurs/konkurs.php">';
		echo '<input type = "hidden" name = "keyword" value = '.$IDs.'>';
		echo '<input type = "submit" value = "View">';
		echo "</form>";
	}
	
	public static function addtokonkurs(String $role,int $keyword){
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = 'usbw';
		$DATABASE_NAME = 'k_naukowe';
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		$con->query("SET NAMES 'utf8'");
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		$stmt = $con->prepare("SELECT ID FROM (konkurs natural left join grupa) left join (opiekun natural left join accounts) on grupa.IDopiekun = opiekun.IDopiekun where IDkonkurs = ?");
		$stmt->bind_param('i',$keyword);
		$stmt->execute();
		$stmt->bind_result($ID);
		$stmt->fetch();
		
		echo '<form action = "/konkurs/addtokonkurs.php">';
		echo '<input type = "hidden" name = "keyword" value ='.$keyword.'>';
		if($ID == $_SESSION['id'] or $role == 'admin') echo '<input type = "submit" value = "Dodaj uczestnika do konkursu +">';
		echo '</form>';
	}
	
	public static function removefromkonkurs(int $IDs, int $keyword, String $role){
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = 'usbw';
		$DATABASE_NAME = 'k_naukowe';
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		$con->query("SET NAMES 'utf8'");
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		$stmt = $con->prepare("SELECT ID FROM (konkurs natural left join grupa) left join (opiekun natural left join accounts) on grupa.IDopiekun = opiekun.IDopiekun where IDkonkurs = ?");
		$stmt->bind_param('i',$keyword);
		$stmt->execute();
		$stmt->bind_result($ID);
		$stmt->fetch();
		
		echo '<form action = "/konkurs/removefromkonkurs.php">';
		echo '<input type = "hidden" name = "keyword" value = '.$IDs.'>';
		echo '<input type = "hidden" name = "keyword2" value = '.$keyword.'>';
		if($role == 'admin' or $ID == $_SESSION['id']) echo '<input type = "submit"  onclick="return confirm(\'Jesteś pewny, że chcesz usunąć tą osobe z konkursu?\')" value = "Remove -">';
		echo "</form>";
	}
	
	public static function editwynik(int $IDs, int $keyword, ?int $wynik, String $role){
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = 'usbw';
		$DATABASE_NAME = 'k_naukowe';
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		$con->query("SET NAMES 'utf8'");
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		$stmt = $con->prepare("SELECT ID FROM (konkurs natural left join grupa) left join (opiekun natural left join accounts) on grupa.IDopiekun = opiekun.IDopiekun where IDkonkurs = ?");
		$stmt->bind_param('i',$keyword);
		$stmt->execute();
		$stmt->bind_result($ID);
		$stmt->fetch();
		
		echo '<form action = "/konkurs/editwynik.php">';
		echo '<input type = "hidden" name = "keyword" value = '.$IDs.'>';
		echo '<input type = "hidden" name = "keyword2" value = '.$keyword.'>';
		if($role == 'admin' or $ID == $_SESSION['id']) echo '<input type = "text" name = "keyword3" style ="width:40px;" value = '.$wynik.'>';
		else echo $wynik;
		echo '</form>';
	}
}
?>