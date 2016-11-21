<?php
if(isset($_POST)){
	if(isset($_POST["nombre"]) && isset($_POST["pass"]) && isset($_POST["pass2"]) && isset($_POST["email"]) && isset($_POST["ciudad"])
		 && isset($_POST["pais"]) && isset($_POST["sexo"]) && isset($_POST["fecha"]) && isset($_POST["foto"])){
		//Comprobamos con los del profesor
		if($_POST["nombre"] != "" && $_POST["nombre"] != "johnsnow" && $_POST["nombre"] != "ygritte" && $_POST["nombre"] != "test"){
			if ($_POST["pass"] == $_POST["pass2"]){
				if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
					$user   = $_POST["nombre"];
					$pass   = $_POST["pass"];
					$email  = $_POST["email"];
					$ciudad = $_POST["ciudad"];
					$pais   = $_POST["pais"];
					$sexo   = $_POST["sexo"];
					$fecha  = $_POST["fecha"];
					$foto   = $_POST["foto"];
					
				} else header("location: index.php?q=registro&error=3");
			} else header("location: index.php?q=registro&error=2");
		} else header("location: index.php?q=registro&error=1");
	}
}
$response = $db->query("SELECT id,nombre FROM paises ORDER BY nombre");
?>
<section class="box registro">
	<h3>Regístrate</h3>
	<?php 
	if (isset($_GET["error"])) {
		switch($_GET["error"]){
			case 0:
				echo "Debe enviar todos los datos";
			break;
			case 1:
				echo "El usuario que has especificado ya esta registrado";
			break;
			case 2:
				echo "Las contraseñas no coinciden";
			break;
			case 3:
				echo "El e-mail no es valido";
			break;
			default:
				echo "Error inesperado";
			break;
		}
	} ?>
	<form method="POST" action="index.php?q=registro">
		<label for="nombre" class="hide">Nombre</label>
		<input id="nombre" name="nombre" type="text" placeholder="Nombre" <?php if (isset($user)) echo "value='".$user."' disabled"; ?> required/>
		<label for="pass" class="hide">Contraseña</label>
		<input id="pass" name="pass" type="password" placeholder="Contraseña" required/>
		<label for="pass2" class="hide">Repetir Contraseña</label>
		<input id="pass2" name="pass2" type="password" placeholder="Confirmar Contraseña" required/>
		<label for="email" class="hide">E-mail</label>
		<input id="email" name="email" type="email" placeholder="E-mail" <?php if (isset($email)) echo "value='".$email."' disabled"; ?> required/>
		<label for="ciudad" class="hide">Ciudad</label>
		<input id="ciudad" name="ciudad" type="text" placeholder="Ciudad" <?php if (isset($ciudad)) echo "value='".$ciudad."' disabled"; ?> />
		<label for="pais">País</label>
		<select id="pais" name="pais">
		<option value="0">Elija un país</option>
		<?php
			while($row=$response->fetch_array()){
				echo '<option value="'.$row["id"].'">'.$row["nombre"].'</option>';
			}
		?>
		</select>
		<label for="sexo">Sexo</label>
		<select name="sexo" id="sexo">
			<option value="h">Hombre</option>
			<option value="m">Mujer</option>
		</select>
		<label for="fecha">Fecha de nacimiento</label>
		<input id="fecha" name="fecha" type="date" <?php if (isset($fecha)) echo "value='".$foto."' disabled"; ?>/><br>
		<p>
		<label for="foto">Foto</label>
		<input type="file" id="foto" name="foto">
		</p>
		<input id="enviar" name="enviar" type="submit" value="Enviar" />
	</form>
</section>
