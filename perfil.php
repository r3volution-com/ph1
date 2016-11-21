<?php
	$title = "Perfil";
	$cssfile = "perfil";
	include("includes/head.php");
	include("includes/header.php");
?>
<section>
	<div class="perfil">
		<div class="cabecera">
			<img src="images/fotoperfil.gif" width="75" alt="Foto"/>
			<h2>Jon Snow</h2>
		</div>
		<div class="section-profile">
			<p><b>Email: </b>iknownothing@nightwatch.com</p>
			<p><b>Sexo: </b>Hombre</p>
			<p><b>Fecha de nacimiento: </b>Desconocida</p>
			<p><b>País: </b>Ivernalia</p>
			<p><b><a href="#">Modificar datos</a></b></p>
			<p><b><a href="#">Darse de baja</a></b></p>
		</div>
		<div class="section-profile buttons">
			<div class="boton">
				<a href="#">Visualizar album</a>
			</div>
			<div class="boton">
				<a href="crearalbum.php">Crear album</a>
			</div>
			<div class="boton">
				<a href="solicitaralbum.php">Imprimir album</a>	
			</div>
		</div>
	</div>
</section>
<?php
	include("includes/footer.php");
?>
