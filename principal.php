<?php
	$title = "Pagina principal";
	$cssfile = "principal";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
?>
<section>
	<article>
		<div class="image">
			<a href="detalle.php?id=0"><img src="images/01.jpg" width="800" alt="Foto"/></a>
		</div>
		<div class="info">
			<a href="detalle.php?id=0"><h3>Jardín de mi casa</h3></a>
			<p class="left">29/09/2016 - España</p>
			<p class="right author"><a href="perfil.php"><img src="images/fotoperfil.png" alt="Perfil"/><b>Jon Snow</b></a></p>
			<p class="clear"></p>
		</div>
	</article>
	<article>
		<div class="image">
			<a href="detalle.php?id=1"><img src="images/02.jpg" width="800" alt="Foto"/></a>
		</div>
		<div class="info">
			<a href="detalle.php?id=1"><h3>Jardín con piscina</h3></a>
			<p class="left">29/09/2016 - España</p>
			<p class="right author"><a href="perfil.php"><img src="images/fotoperfil.png" alt="Perfil"/><b>Jon Snow</b></a></p>
			<p class="clear"></p>
		</div>
	</article>
	<article>
		<div class="image">
			<a href="detalle.php?id=2"><img src="images/03.jpg" width="800" alt="Foto"/></a>
		</div>
		<div class="info">
			<a href="detalle.php?id=2"><h3>Piscina de mi comunidad</h3></a>
			<p class="left">29/09/2016 - España</p>
			<p class="right author"><a href="perfil.php"><img src="images/fotoperfil.png" alt="Perfil"/><b>Jon Snow</b></a></p>
			<p class="clear"></p>
		</div>
	</article>
	<article>
		<div class="image">
			<a href="detalle.php?id=3"><img src="images/04.jpg" width="800" alt="Foto"/></a>
		</div>
		<div class="info">
			<a href="detalle.php?id=3"><h3>Piscina del hotel</h3></a>
			<p class="left">29/09/2016 - España</p>
			<p class="right author"><a href="perfil.php"><img src="images/fotoperfil.png" alt="Perfil"/><b>Jon Snow</b></a></p>
			<p class="clear"></p>
		</div>
	</article>
	<article>
		<div class="image">
			<a href="detalle.php?id=4"><img src="images/05.jpg" width="800" alt="Foto"/></a>
		</div>
		<div class="info">
			<a href="detalle.php?id=3"><h3>Puentes</h3></a>
			<p class="left">29/09/2016 - España</p>
			<p class="right author"><a href="perfil.php"><img src="images/fotoperfil.png" alt="Perfil"/><b>Jon Snow</b></a></p>
			<p class="clear"></p>
		</div>
	</article>
</section>
<?php
	include("includes/footer.php");
?>

