<?php
	$title = "Dar de baja";
	$cssfile = "solicitaralbum";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
	$response = $db->query("SELECT id,nombre FROM paises ORDER BY nombre");
?>
<section class="box">
	<h1>Pedido realizado</h1>
		<p>¿Quiere darse de baja?</p>
	<br><a class="ref" href="solicitaralbum.php">Si</a>
	<br><a class="ref" href="solicitaralbum.php">No</a>
</section>
<?php
	include("includes/footer.php");
?>

