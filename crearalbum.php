<?php
	$title = "Crear album";
	$cssfile = "solicitaralbum";
	include("includes/head.php");
	include("includes/header.php");
?>
<section class="box">
	<div class="content">
	<h2>Formulario de creación</h2>	
		<p>Permite crear un álbum de fotos</p>
		<form id="formulario" action="operaciones.php?op=crearalbum" method="post">
				<label for="titulo">Título del álbum</label>
				<input id="titulo" name="titulo" type="text" maxlength="200" required placeholder="Título del álbum"/>
				<label for="descrip">Descripción</label>
				<textarea name="descrip" id="descrip" maxlength="4000" placeholder="Descripción"></textarea>
				<label for="pais">País</label>
				<input id="pais" name="pais" type="text" placeholder="País"/>
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
