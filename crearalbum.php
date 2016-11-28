<?php
	$title = "Crear album";
	$cssfile = "solicitaralbum";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
	$response = $db->query("SELECT id,nombre FROM paises ORDER BY nombre");
?>
<section class="box">
	<div class="content">
	<h2>Formulario de creación</h2>	
		<p>Permite crear un álbum de fotos</p>
		<form id="formulario" action="operaciones.php?operacion=crearalbum" method="post">
				<label for="titulo">Título del álbum</label>
				<input id="titulo" name="titulo" type="text" minlength="3" maxlength="200" required placeholder="Título del álbum"/>
				<label for="descrip">Descripción</label>
				<textarea name="descrip" id="descrip" minlength="3" maxlength="4000" placeholder="Descripción"></textarea>
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
