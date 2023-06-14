<?php
Class wydarzenie{
	public static function addwydarzenie($role){		
		if($role == 'admin' or $role == 'opiekun'){
			echo '<form action = "/wydarzenie/addwydarzenie.php">';
			echo '<input type = "submit" value = "Dodaj nowe wydarzenie +">';
			echo '</form>';
		}
	}
	
	public static function viewwydarzenie($role,$con){	
		$stmt = $con->prepare("select IDwydarzenie, wydarzenie.IDgrupa,wydarzenie.nazwa, Data, TIME_FORMAT(Godzina, '%H:%i'), Opis, post_time, grupa.nazwa, image from wydarzenie left join grupa on wydarzenie.IDgrupa = grupa.IDgrupa order by post_time DESC;");

		$stmt->bind_result($IDw, $IDg,$name,$Date,$Hour,$Opis,$post_time,$nazwa, $image );
		$stmt->execute();
		while($stmt->fetch()){
			echo "<div class = 'wydarzenie'>";
			echo "<h6> ".$nazwa." | Data: ".$Date." Godzina: ".$Hour.", ".$name;
			echo "<div class = 'buttons'>";
			wydarzenie::removewydarzenie($role,$IDw);
			wydarzenie::editwydarzenie($role,$IDw);
			echo "</div>";
			echo "</h6>";
			echo '<div class = "dane">';
			echo $Opis;
			echo "</div>";
			echo "</div>";
			}
			$stmt->close();
	}
	
	public static function removewydarzenie($role,$IDs){
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = 'usbw';
		$DATABASE_NAME = 'k_naukowe';
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		$con->query("SET NAMES 'utf8'");
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		$stmt = $con->prepare("SELECT ID FROM (wydarzenie left join grupa on wydarzenie.IDgrupa = grupa.IDgrupa) left join (opiekun natural left join accounts) on grupa.IDopiekun = opiekun.IDopiekun where IDwydarzenie = ?");
		$stmt->bind_param('i',$IDs);
		$stmt->execute();
		$stmt->bind_result($ID);
		$stmt->fetch();
		
		echo '<form action = "/wydarzenie/removewydarzenie.php">';
		echo '<input type = "hidden" name = "keyword" value = '.$IDs.'>';
		if($ID == $_SESSION['id'] or $role == 'admin') echo '<input onclick="return confirm(\'Jesteś pewny, że chcesz usunąć to wydarzenie?\')" type = "submit" value = "Remove">';
		echo "</form>";
	}
	
	public static function editwydarzenie($role,$IDs){
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = 'usbw';
		$DATABASE_NAME = 'k_naukowe';
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		$con->query("SET NAMES 'utf8'");
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		$stmt = $con->prepare("SELECT ID FROM (wydarzenie left join grupa on wydarzenie.IDgrupa = grupa.IDgrupa) left join (opiekun natural left join accounts) on grupa.IDopiekun = opiekun.IDopiekun where IDwydarzenie = ?");
		$stmt->bind_param('i',$IDs);
		$stmt->execute();
		$stmt->bind_result($ID);
		$stmt->fetch();
		
		echo '<form action = "/wydarzenie/editwydarzenie.php">';
		echo '<input type = "hidden" name = "keyword" value = '.$IDs.'>';
		if($ID == $_SESSION['id'] or $role == 'admin') echo '<input type = "submit" value = "Edit">';
		echo "</form>";
	}
	
}
?>