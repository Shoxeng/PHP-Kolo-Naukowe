<?php

Class wpis{
	public static function viewwpisy(int $keyword, String $role){
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
		$stmt->close();
		
		$stmt = $con->prepare("SELECT count(*) FROM accounts left join czlonek_grupa on accounts.IDczlonek = czlonek_grupa.IDczlonek where IDgrupa = ? and ID = ?");
		$stmt->bind_param('ii',$keyword,$_SESSION['id']);
		$stmt->execute();
		$stmt->bind_result($cn);
		$stmt->fetch();
		$stmt->close();
		
		echo '<form action = "/wpis/wpisy.php">';
		echo '<input type = "hidden" name = "keyword" value = '.$keyword.'>';
		if($ID == $_SESSION['id'] or $role == 'admin' or $cn > 0) echo '<input type = "submit" value = "Zobacz Wpisy">';
		echo "</form>";
	}
	public static function editwpis(int $keyword,int $IDs, String $role){
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
		$stmt->close();
		
		$stmt = $con->prepare("SELECT 1 from accounts where IDczlonek in (select IDczlonek from wpis where IDwpis = ?) and IDczlonek in (select IDczlonek from grupa where IDgrupa = ?) and ID = ?");
		$stmt->bind_param('iii',$IDs, $keyword, $_SESSION['id']);
		$stmt->execute();
		$stmt->bind_result($valid);
		$stmt->fetch();
		$stmt->close();
		
		echo '<form action = "/wpis/editwpis.php" method = "post">';
		echo '<input type = "hidden" name = "keyword" value = '.$keyword.'>';
		echo '<input type = "hidden" name = "keyword2" value = '.$IDs.'>';
		if($ID == $_SESSION['id'] or $role == 'admin' or $valid) echo '<input type = "submit" value = "Edit">';
		echo "</form>";
	}
	public static function addwpis(int $keyword, String $role){
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
		$stmt->close();
		
		$stmt = $con->prepare("SELECT 1 from accounts where IDczlonek in (select IDczlonek from grupa where IDgrupa = ?) and ID = ?");
		$stmt->bind_param('ii',$keyword, $_SESSION['id']);
		$stmt->execute();
		$stmt->bind_result($valid);
		$stmt->fetch();
		$stmt->close();
		
		if($role == 'admin' or $ID == $_SESSION['id'] or $valid){
			echo '<form action = "/wpis/addwpis.php" method = "post">';
			echo '<input type = "hidden" name = "keyword" value = '.$keyword.'>';
			echo '<input type = "submit" value = "Dodaj nowy wpis +">';
			echo '</form>';
			}	
		}	
	public static function removewpis(int $keyword, int $IDs,String $role){
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
		$stmt->close();
		
		$stmt = $con->prepare("SELECT 1 from accounts where IDczlonek in (select IDczlonek from wpis where IDwpis = ?) and IDczlonek in (select IDczlonek from grupa where IDgrupa = ?) and ID = ?");
		$stmt->bind_param('iii',$IDs, $keyword, $_SESSION['id']);
		$stmt->execute();
		$stmt->bind_result($valid);
		$stmt->fetch();
		$stmt->close();
		
		echo '<form action = "/wpis/removewpis.php">';
		echo '<input type = "hidden" name = "keyword" value = '.$keyword.'>';
		echo '<input type = "hidden" name = "keyword2" value = '.$IDs.'>';
		if($ID == $_SESSION['id'] or $role == 'admin' or $valid) echo '<input type = "submit"  onclick="return confirm(\'Jesteś pewny, że chcesz usunąć ten wpis?\')" value = "Remove -">';
		echo "</form>";	
	}
}

?>