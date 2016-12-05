<?php
	$title = "Dar de baja";
	$cssfile = "dardebaja";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
?>
<section class="box">
	<h1>Pedido realizado</h1>
	<p>¿Quiere darse de baja?</p>
	<a class="ref" href="operaciones.php?operacion=dardebja">Si</a>
	<a class="ref" href="perfil.php">No</a>
</section>
<?php
	include("includes/footer.php");
?>
