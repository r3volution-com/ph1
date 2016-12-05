<?php
	$title = "Sube foto";
	$cssfile = "solicitaralbum";
	include("includes/head.php");
	if (isset($_GET["idalbum"])) {
		if ($_GET["idalbum"] == "" || !is_numeric($_GET["idalbum"]) || $_GET["idalbum"] <= 0){
			header("location: index.php");
			exit;
		}
		$res = $db->query("SELECT id FROM albumes WHERE id=".$db->real_escape_string($_GET["idalbum"])." AND idUsuario=".$_SESSION["remember"]["id"]);
		if (!$res || ($res && $res->num_rows <= 0)){
			header("location: perfil.php");
			exit;
		}
	}
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
		exit;
	}
	include("includes/header.php");
	$response = $db->query("SELECT id,nombre FROM paises ORDER BY nombre");
	$response2 = $db->query("SELECT id,titulo FROM albumes WHERE idUsuario=".$_SESSION["remember"]["id"]." ORDER BY titulo");
	if($response2->num_rows){
?>
<section class="box">
	<div class="content">
	<h2>Añade una foto</h2>
		<?php
			if (isset($_GET["error"])) {
				switch($_GET["error"]){
					case "bad_params":
						echo "Debe enviar todos los datos";
					break;
					case "bad_length_title":
						echo "El titulo debe tener entre 3 y 200 caracteres";
					break;
					case "album_not_found":
						echo "El album especificado no existe o no le pertenece";
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
					default:
						echo "Error inesperado";
					break;
				}
			} ?>
		<form id="formulario" action="operaciones.php?operacion=fotoalbum" method="post">
				<label for="titulo">Título de la foto</label>
				<input id="titulo" name="titulo" type="text" maxlength="30" required placeholder="Título de la foto"/>
				<select id="pais" name="pais" >
					<option value="0">Elija un país</option>
					<?php
						while($row=$response->fetch_array()){
							echo '<option value="'.$row["id"].'">'.$row["nombre"].'</option>';
						}
					?>
				</select>
				<?php if (!isset($_GET["idalbum"])) { ?>
					<p>¿A qué álbum quieres añadirlo?</p>
					<select id="album" name="album" >
						<option value="0">Elija un album</option>
						<?php
							while($row=$response2->fetch_array()){
								echo '<option value="'.$row["id"].'">'.$row["titulo"].'</option>';
							}
						?>
					</select>
				<?php } else { ?>
					<input type="hidden" name="album" value="<?php echo $_GET["idalbum"]; ?>"/>
				<?php } ?>
				<label class="label" for="date">Fecha</label>
				<input type="date" id="date" name="date" required>
				<label for="pais">País</label>
				<p>
				<label class="label" for="foto">Foto</label><br>
				<input type="file" id="foto" name="foto" accept="image/jpg,image/png" requiered>
				</p>
			<input id="campo9" name="enviar" type="submit" value="Enviar"/>
		</form>
	</div>
</section>
<?php
	}
	else{
		echo "Debes crear un album primero";
	}
	include("includes/footer.php");
?>
