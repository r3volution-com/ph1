<?php
	$title = "Modificar perfil";
	$cssfile = "modificaperfil";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
	$response = $db->query("SELECT id,nombre FROM paises ORDER BY nombre");
	$email = $_SESSION["remember"]["email"];
	$ciudad = $_SESSION["remember"]["ciudad"];
	$pais = $_SESSION["remember"]["idPais"];
	$sexo = $_SESSION["remember"]["sexo"];
?>
<section class="box">
	<h3>Modificar pefil</h3>
	<?php
	if (isset($_GET["error"])) {
		switch($_GET["error"]){
			case "bad_params":
				echo "Debe enviar todos los datos";
			break;
			case "bad_length_pass":
				echo "La contraseña debe tener entre 6 y 15 caracteres";
			break;
			case "pass_not_equals":
				echo "Las contraseñas no coinciden";
			break;
			case "pass_only_alphanumeric":
				echo "La contraseña que has especificado no cumple los requisitos (Solo letras, numeros y barra baja)";
			break;
			case "bad_email":
				echo "El e-mail no es valido";
			break;
			case "email_already_exists":
				echo "El e-mail introducido ya esta registrado";
			break;
			case "bad_sex":
				echo "El sexo introducido no es valido";
			break;
			case "country_not_found":
				echo "El pais especificado no existe";
			break;
			case "wrong_photo_name":
				echo "Nombre de fotografía incorrecto";
			break;
			case "wrong_photo_type":
				echo "Formato de archivo incorrecto";
			break;
			case "wrong_photo_size":
				echo "El tamaño de la fotografía es incorrecto";
			break;
			case "file_not_found":
				echo "No se ha encontrado el archivo";
			break;
			default:
				echo "Error inesperado";
			break;
		}
	} ?>
	<form method="POST" action="operaciones.php?operacion=modificaruser" enctype="multipart/form-data">
		<label for="pass" class="hide">Contraseña</label>
		<input id="pass" name="pass" type="password" minlength="6" maxlength="15" pattern="[a-zA-Z0-9\s_]{6,15}" placeholder="Contraseña"/>
		<label for="pass2" class="hide">Repetir Contraseña</label>
		<input id="pass2" name="pass2" type="password" minlength="6" maxlength="15" pattern="[a-zA-Z0-9\s_]{6,15}" placeholder="Confirmar Contraseña"/>
		<label for="email" class="hide">E-mail</label>
		<input id="email" name="email" type="email" minlength="8" maxlength="250" placeholder="E-mail" <?php if (isset($email)) echo "value='".$email."'"; ?>/>
		<label for="ciudad" class="hide">Ciudad</label>
		<input id="ciudad" name="ciudad" type="text" maxlength="250" placeholder="Ciudad" <?php if (isset($ciudad)) echo "value='".$ciudad."'"; ?> />
		<label for="pais">País</label>
		<select id="pais" name="pais">
		<option value="0">Elija un país</option>
		<?php
		if($response && $response->num_rows){
			while($row=$response->fetch_array()){
				if ($row["id"] == $pais)
					echo '<option selected value="'.$row["id"].'">'.$row["nombre"].'</option>';
				else echo '<option value="'.$row["id"].'">'.$row["nombre"].'</option>';
			}
		}
		?>
		</select>
		<label for="sexo">Sexo</label>
		<select name="sexo" id="sexo">
			<option <?php if ($sexo == "h") echo "selected"; ?> value="h">Hombre</option>
			<option <?php if ($sexo == "m") echo "selected"; ?> value="m">Mujer</option>
		</select>
		<p>
		Elija su foto de perfil<br><br>
		<label for="foto">Foto</label>
		<input type="file" id="foto" name="foto" accept="image/jpg,image/png">
		</p>
		<input id="enviar" name="enviar" type="submit" value="Enviar" />
	</form>
	</section>
<?php
	include("includes/footer.php");
?>
