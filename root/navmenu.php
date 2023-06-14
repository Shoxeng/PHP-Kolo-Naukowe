<h1><i class="fas fa-users-line"></i>Strona Klubów Naukowych ZSP. Tenczynek</h1>
				<a href="/wydarzenie/wydarzenia.php"><i class="fas fa-bullhorn"></i>Wydarzenia</a>
				<a href="/harmonogram.php"><i class="fas fa-table"></i>Harmonogram</a>
				<a href="/konkurs/konkursy.php"><i class="fas fa-flag-checkered"></i>Konkursy</a>
				<a href="/grupa/grupy.php"><i class="fas fa-user-friends"></i>Grupy</a>
				<?php
				if($role == 'admin'){
					echo '<a href="/uzytkownik/uzytkownicy.php"><i class="fas fa-address-book"></i>Użytkownicy</a>';
				}
				?>
				<a href="/profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="/logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>