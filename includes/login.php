<section class="box">
	<h2>Conéctate</h2>
	<form method="POST" action="operaciones.php?operacion=login">
		<label for="nombre" class="hide">Nombre</label>
		<input id="nombre" name="nombre" type="text" placeholder="Nombre"/><br>
		<label for="pass" class="hide">Contraseña</label>
		<input id="pass" name="pass" type="password" placeholder="Contraseña"/><br>
		<input id="submit" name="submit" type="submit" value="Acceder" />
	</form>
	<?php
	if(isset($_GET["error"])){
		echo "<br>El usuario y la contraseña no coinciden";
	}
	?>
</section>