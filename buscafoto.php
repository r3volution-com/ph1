<?php
	$title = "Buscar foto";
	$cssfile = "avanzada";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
	$response = $db->query("SELECT id,nombre FROM paises ORDER BY nombre");
?>
<section class="box">
	<div class="rediv">
		<form id="formulario" action="resultadobusqueda.php" method="get">
			<h2>Búsqueda de foto</h2>
				<label for="titulo">Título</label>
				<input id="titulo" name="search" type="text" placeholder="Título"/>
				<label for="pais">País</label>
				<select id="pais" name="pais">
					<option value="0">Elija un país</option>
					<?php
						while($row=$response->fetch_array()){
							echo '<option value="'.$row["id"].'">'.$row["nombre"].'</option>';
						}
					?>
				</select>
				<label for="fecha">Fecha</label>
				<input id="fecha" name="fecha" type="date"/>
				<br><br>
			<div class="enviar">
			<input id="campo4" name="buscar" type="submit" value="Buscar" />
			</div>
		</form>
	</div>
</section>
<?php
	include("includes/footer.php");
?>
