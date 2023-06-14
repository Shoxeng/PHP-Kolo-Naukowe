<?php

Class grupa{
	
	public static function editgrupa(int $IDs, String $role){
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
		$stmt->bind_param('i',$IDs);
		$stmt->execute();
		$stmt->bind_result($ID);
		$stmt->fetch();
		
		echo '<form action = "/grupa/editgrupa.php">';
		echo '<input type = "hidden" name = "keyword" value = '.$IDs.'>';
		if($ID == $_SESSION['id'] or $role == 'admin') echo '<input type = "submit" value = "Edit">';
		echo "</form>";
	}
	public static function addgrupa(String $role){
		if($role == 'admin'){
			echo '<form action = "/grupa/addgrupa.php" method = "post">';
			echo '<input type = "submit" value = "Dodaj nową grupe +">';
			echo '</form>';
			}	
		}	
	public static function removegrupa(int $IDs,String $role){
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
		$stmt->bind_param('i',$IDs);
		$stmt->execute();
		$stmt->bind_result($ID);
		$stmt->fetch();
		
		echo '<form action = "/grupa/removegrupa.php">';
		echo '<input type = "hidden" name = "keyword" value = '.$IDs.'>';
		if($ID == $_SESSION['id'] or $role == 'admin') echo '<input type = "submit"  onclick="return confirm(\'Jesteś pewny, że chcesz usunąć tą grupe?\')" value = "Remove -">';
		echo "</form>";	
	}
	
	public static function viewgrupa(int $IDs,String $role){
		echo '<form action = "/grupa/grupa.php">';
		echo '<input type = "hidden" name = "keyword" value = '.$IDs.'>';
		echo '<input type = "submit" value = "View">';
		echo "</form>";
	}
	
	public static function addtogrupa(String $role,int $keyword){
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
		
		echo '<form action = "/grupa/addtogrupa.php">';
		echo '<input type = "hidden" name = "keyword" value ='.$keyword.'>';
		if($ID == $_SESSION['id'] or $role == 'admin') echo '<input type = "submit" value = "Dodaj członka do grupy +">';
		echo '</form>';
	}
	
	public static function removefromgrupa(int $IDs, int $keyword, String $role){
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
		
		echo '<form action = "/grupa/removefromgrupa.php">';
		echo '<input type = "hidden" name = "keyword" value = '.$IDs.'>';
		echo '<input type = "hidden" name = "keyword2" value = '.$keyword.'>';
		if($ID == $_SESSION['id'] or $role == 'admin') echo '<input type = "submit"  onclick="return confirm(\'Jesteś pewny, że chcesz usunąć tą osobe z grupy??\')" value = "Remove -">';
		echo "</form>";
	}
	
	public static function setlacznik(int $IDs, int $keyword, String $role){
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = 'usbw';
		$DATABASE_NAME = 'k_naukowe';
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		$con->query("SET NAMES 'utf8'");
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		$stmt = $con->prepare("SELECT ID, grupa.IDczlonek FROM grupa left join (opiekun natural left join accounts) on grupa.IDopiekun = opiekun.IDopiekun where IDgrupa = ?");
		$stmt->bind_param('i',$keyword);
		$stmt->execute();
		$stmt->bind_result($ID,$IDl);
		$stmt->fetch();
		
		echo '<form action = "/grupa/setlacznik.php">';
		echo '<input type = "hidden" name = "keyword2" value = '.$keyword.'>';
		if(($ID == $_SESSION['id'] or $role == 'admin') and $IDs != $IDl){
			echo '<input type = "hidden" name = "keyword" value = '.$IDs.'>';
			echo '<input type = "submit" value = "Ustaw jako łącznik">';
		}
		else if(($IDs == $IDl) and ($ID == $_SESSION['id'] or $role == 'admin') ){
			echo '<input type = "hidden" name = "keyword" value = "null">';
			echo '<input type = "submit" value = "Zdejmij stanowisko łącznika">';
		}
		echo "</form>";
	}
}
?>