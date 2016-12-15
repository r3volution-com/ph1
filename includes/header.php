<nav>
	<div class="left"><a href="principal.php"><img src="images/logo.png" alt="Logo"/></a></div>
	<div class="right">
		<form method="GET" action="resultadobusqueda.php">
			<label for="search">Buscar</label>
			<input name="search" type="text" placeholder="Buscar" id="search" minlength="3" maxlength="22"/>
		</form>
		<a href="resultadobusqueda.php" class="search-icon"><i class="material-icons">search</i></a>
		<a href="buscafoto.php">Búsqueda avanzada</a>
		<?php if (isset($_SESSION["remember"])) { ?>
		<div class="profile dropdown"><img src="uploads/thumb_<?php echo ($_SESSION["remember"]["foto"]) ? $_SESSION["remember"]["foto"] : "user.png";?>" alt="Perfil"/>
			<div class="dropdown-content">
				<p>Hola, <?php echo $_SESSION["remember"]["nombre"];?></p>
				<a href="perfil.php">Perfil</a>
				<a href="operaciones.php?operacion=logout">Cerrar sesión</a>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="clear"></div>
</nav>
