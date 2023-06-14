<?php

Class uzytkownik{
	
	public static function adduzytkownik(String $role){	
		if($role == 'admin'){
			echo '<form action = "/uzytkownik/adduzytkownik.php" method = "post">';
			echo '<input type = "submit" value = "Dodaj nowego użytkownika +">';
			echo '</form>';
			}	
		}	
	public static function removeuzytkownik(int $IDs,String $role){
		echo '<form action = "/uzytkownik/removeuzytkownik.php">';
		echo '<input type = "hidden" name = "keyword" value = '.$IDs.'>';
		if($role == 'admin') echo '<input type = "submit"  onclick="return confirm(\'Jesteś pewny, że chcesz usunąć tego użytkownika?\')" value = "Remove -">';
		echo "</form>";	
	}
}

?>