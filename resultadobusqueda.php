<?php
	$title = "Resultados de la busqueda";
	$cssfile = "principal";
	include("includes/head.php");
	include("includes/header.php");
?>
<section class="search">
	<form method="POST" action="resultadobusqueda.php">
		<label for="search">Buscar</label>
		<input type="text" placeholder="Buscar" value="<?php if(isset($_GET["search"]))echo $_GET["search"];?> " id="search"/>
		<input type="submit" value="Buscar"/> - <a href="buscafoto.php"><b>Búsqueda avanzada</b></a>
	</form>
</section>
<section class="results">
	<h1>Resultados</h1>
	<article>
		<div class="image">
			<img src="images/01.jpg" width="800" alt="Foto"/>
		</div>
		<div class="info">
			<a href="detalle.php"><h3>Jardín de mi casa</h3></a>
			<p class="left">29/09/2016- España</p>
			<p class="right author"><a href="perfil.php"><img src="images/fotoperfil.png" alt="Perfil"/><b>Jon Snow</b></a></p>
			<p class="clear"></p>
		</div>
	</article>
	<article>
		<div class="image">
			<img src="images/02.jpg" width="800" alt="Foto"/>
		</div>
		<div class="info">
			<h3>Jardin con piscina</h3>
			<p class="left">29/09/2016- España</p>
			<p class="right author"><a href="perfil.php"><img src="images/fotoperfil.png" alt="Perfil"/><b>Jon Snow</b></a></p>
			<p class="clear"></p>
		</div>
	</article>
</section>
<?php
	include("includes/footer.php");
?>
