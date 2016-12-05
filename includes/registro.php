<?php
$response = $db->query("SELECT id,nombre FROM paises ORDER BY nombre");
?>
<section class="box registro">
	<h3>Regístrate</h3>
	<?php
	if (isset($_GET["error"])) {
		switch($_GET["error"]){
			case "bad_params":
				echo "Debe enviar todos los datos";
			break;
			case "bad_length_name":
				echo "El nombre de usuario debe tener entre 3 y 15 caracteres";
			break;
			case "user_already_exists":
				echo "El usuario que has especificado ya esta registrado";
			break;
			case "user_only_alphanumeric":
				echo "El usuario que has especificado no cumple los requisitos (Solo letras y numeros)";
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
			case "pass_no_uppercase":
				echo "La contraseña que has especificado no cumple los requisitos (Debe contener al menos una letra mayuscula)";
			break;
			case "pass_no_lowercase":
				echo "La contraseña que has especificado no cumple los requisitos (Debe contener al menos una letra minuscula)";
			break;
			case "pass_no_number":
				echo "La contraseña que has especificado no cumple los requisitos (Debe contener al menos un número)";
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
			case "bad_date":
				echo "La fecha introducida no es valida";
			break;
			case "country_not_found":
				echo "El pais especificado no existe";
			break;
			case "wrong_photo_name":
				echo "Nombre de fotografía incorrecto";
			default:
			case "wrong_photo_type":
				echo "Formato de archivo incorrecto";
			break;
			case "wrong_photo_size":
				echo "El tamaño de la fotografía es incorrecto";
			break;
			case "file_not_found":
				echo "No se ha encontrado el archivo";
			break;
				echo "Error inesperado";
			break;
		}
	} ?>
	<form method="POST" action="operaciones.php?operacion=register">
		<label for="nombre" class="hide">Nombre</label>
		<input id="nombre" name="nombre" type="text" minlength="3" maxlength="15" pattern="[a-zA-Z0-9\s]{3,15}" placeholder="Nombre de usuario" <?php if (isset($user)) echo "value='".$user."' disabled"; ?> required/>
		<label for="pass" class="hide">Contraseña</label>
		<input id="pass" name="pass" type="password" minlength="6" maxlength="15" pattern="[a-zA-Z0-9\s_]{6,15}" placeholder="Contraseña" required/>
		<label for="pass2" class="hide">Repetir Contraseña</label>
		<input id="pass2" name="pass2" type="password" minlength="6" maxlength="15" pattern="[a-zA-Z0-9\s_]{6,15}" placeholder="Confirmar Contraseña" required/>
		<label for="email" class="hide">E-mail</label>
		<input id="email" name="email" type="email" minlength="8" maxlength="250" placeholder="E-mail" required/>
		<label for="ciudad" class="hide">Ciudad</label>
		<input id="ciudad" name="ciudad" type="text" maxlength="250" placeholder="Ciudad" />
		<label for="pais">País</label>
		<select id="pais" name="pais">
		<option value="0">Elija un país</option>
		<?php
		if ($response){
			while($row=$response->fetch_array()){
				echo '<option value="'.$row["id"].'">'.$row["nombre"].'</option>';
			}
		}
		?>
		</select>
		<label for="sexo">Sexo</label>
		<select name="sexo" id="sexo">
			<option value="h">Hombre</option>
			<option value="m">Mujer</option>
		</select>
		<label for="fecha">Fecha de nacimiento</label>
		<input id="fecha" name="fecha" type="date" placeholder="dd/mm/yy"/><br>
		<p>
		<label for="foto">Foto</label>
		<input type="file" id="foto" name="foto" accept="image/jpg,image/png">
		</p>
		<input id="enviar" name="enviar" type="submit" value="Enviar" />
	</form>
</section>
