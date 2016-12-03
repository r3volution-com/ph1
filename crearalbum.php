<?php
	$title = "Crear album";
	$cssfile = "solicitaralbum";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
	$response = $db->query("SELECT id,nombre FROM paises ORDER BY nombre");
	if(!$response){
		die("<section>".$db->error."</section>");
	}
?>
<section class="box">
	<div class="content">
	<h2>Formulario de creación</h2>
		<p>Permite crear un álbum de fotos</p>
		<?php
			if (isset($_GET["error"])) {
				switch($_GET["error"]){
					case "bad_params":
						echo "Debe enviar todos los datos";
					break;
					case "bad_length_title":
						echo "El titulo debe tener entre 3 y 200 caracteres";
					break;
					case "bad_length_desc":
						echo "La contraseña debe tener entre 3 y 4000 caracteres";
					break;
					case "bad_date":
						echo "La fecha introducida no es valida";
					break;
					case "country_not_found":
						echo "El pais especificado no existe";
					break;
					default:
						echo "Error inesperado";
					break;
				}
			} ?>
		<form id="formulario" action="operaciones.php?operacion=crearalbum" method="post">
				<label for="titulo">Título del álbum</label>
				<input id="titulo" name="titulo" type="text" minlength="3" maxlength="30" required placeholder="Título del álbum"/>
				<label for="descripcion">Descripción</label>
				<textarea name="descripcion" id="descripcion" minlength="3" maxlength="130" placeholder="Descripción"></textarea>
				<label for="pais">País</label>
				<select id="pais" name="pais">
					<option value="0">Elija un país</option>
					<?php
						while($row=$response->fetch_array()){
							echo '<option value="'.$row["id"].'">'.$row["nombre"].'</option>';
						}
					?>
				</select>
				<p>
				<label class="label" for="date">Fecha</label>
				<input type="date" id="date" name="date">
				</p>
			<input id="campo9" name="enviar" type="submit" value="Enviar" />
		</form>
	</div>
</section>
<?php
	include("includes/footer.php");
?>
