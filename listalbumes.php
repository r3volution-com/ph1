<?php
	$title = "Mis álbumes";
	$cssfile = "listalbumes";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
	$response = $db->query("SELECT * FROM albumes ORDER BY fecha DESC LIMIT 5");
?>
<section>
	<div class="cabecera">
		<h1>Tus álbumes</h1>
	</div>
<?php 
	if($response->num_rows<=0) echo "El album especificado no existe"; 
	else { 
		while ($row = $response->fetch_array()){ 
			$r_pais = $db->query("SELECT nombre FROM paises WHERE id=".$row["idPais"]);
			$pais = $r_pais->fetch_array();
	?>
	<article>
		<div class="aux">
		<div class="image">
			<img src="images/01.jpg" alt="Foto"/>
		</div>
		<div class="info">
			<div class="titulo"><a href="veralbum.php?id=<?php echo $row["id"]; ?>"><?php echo $row["titulo"]; ?></a></div>
			<div class="descripcion"><?php echo $row["descripcion"]; ?></div>
			<div class="pais"><?php echo $pais["nombre"]; ?></div>
			<div class="fecha"><?php echo $row["fecha"]; ?></div>
		</div>
		<div class="clear">
		</div>
		</div>
	</article>
	<?php } 
	}?>
</section>
<?php
	include("includes/footer.php");
?>

