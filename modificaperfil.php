<?php
	$title = "Modificar perfil";
	$cssfile = "modificaperfil";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
	$response = $db->query("SELECT id,nombre FROM paises ORDER BY nombre");
	if($response->num_rows){
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
			default:
				echo "Error inesperado";
			break;
		}
	} ?>
	<form method="POST" action="operaciones.php?operacion=modificaruser">
		<label for="pass" class="hide">Contraseña</label>
		<input id="pass" name="pass" type="password" minlength="6" maxlength="15" pattern="[a-zA-Z0-9\s_]{6,15}" placeholder="Contraseña" required/>
		<label for="pass2" class="hide">Repetir Contraseña</label>
		<input id="pass2" name="pass2" type="password" minlength="6" maxlength="15" pattern="[a-zA-Z0-9\s_]{6,15}" placeholder="Confirmar Contraseña" required/>
		<label for="email" class="hide">E-mail</label>
		<input id="email" name="email" type="email" minlength="8" maxlength="250" placeholder="E-mail" <?php if (isset($email)) echo "value='".$email."' disabled"; ?> required/>
		<label for="ciudad" class="hide">Ciudad</label>
		<input id="ciudad" name="ciudad" type="text" maxlength="250" placeholder="Ciudad" <?php if (isset($ciudad)) echo "value='".$ciudad."' disabled"; ?> />
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
		<p>
		Elija su foto de perfil<br><br>
		<label for="foto">Foto</label>
		<input type="file" id="foto" name="foto">
		</p>
		<input id="enviar" name="enviar" type="submit" value="Enviar" />
	</form>
	</section>
<?php
	}
	include("includes/footer.php");
?>
