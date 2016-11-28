<?php
	$title = "Sube foto";
	$cssfile = "solicitaralbum";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
	$response = $db->query("SELECT id,nombre FROM paises ORDER BY nombre");
	$response2 = $db->query("SELECT id,titulo FROM albumes ORDER BY titulo");
	if($response2->num_rows){
?>
<section class="box">
	<div class="content">
	<h2>Añade una foto</h2>	
		<form id="formulario" action="perfil.php" method="post">
				<label for="titulo">Título de la foto</label>
				<input id="titulo" name="titulo" type="text" maxlength="200" required placeholder="Título de la foto"/>
				<p>
				<select id="pais" name="pais" >
					<option value="0">Elija un país</option>
					<?php
						while($row=$response->fetch_array()){
							echo '<option value="'.$row["id"].'">'.$row["nombre"].'</option>';
						}
					?>
				</select>
				<p>¿A qué álbum quieres añadirlo?</p>
				<?php if (!isset($_GET["idalbum"])) { ?>
					<select id="pais" name="pais" >
						<option value="0">Elija un album</option>
						<?php
							while($row=$response2->fetch_array()){
								echo '<option value="'.$row["id"].'">'.$row["titulo"].'</option>';
							}
				?>
					</select>
				<?php } ?>
				</p>
				<label class="label" for="date">Fecha</label>
				<input type="date" id="date" name="date" required>
				<label for="pais">País</label>
				<p>
				<label class="label" for="foto">Foto</label><br>
				<input type="file" id="foto" name="foto" requiered>
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
