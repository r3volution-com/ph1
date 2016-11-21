<?php
	$title = "Buscar foto";
	$cssfile = "solicitaralbum";
	include("includes/head.php");
	include("includes/header.php");
?>
<section class="box">
	<div class="rediv">
		<form id="formulario" action="resultadobusqueda.php" method="get">
			<h2>Búsqueda de foto</h2>
				<label for="titulo">Título</label>
				<input id="titulo" name="search" type="text" placeholder="Título"/>
				<label for="pais">País</label>
				<input id="pais" name="pais" type="text" placeholder="País"/>
				<br>Fecha
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
