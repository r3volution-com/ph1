<?php 
	if (isset($_GET["id"])){
		$id = $_GET["id"];
		if(is_numeric($id)){
			if($id>=0){
				if (($id % 2) == 0){ //par
					$titulo = "Jardín de mi casa";
					$foto = "01.jpg";
					$descripcion = "Foto que subí desde el jardín de mi casa, esta bastante bien la verdad, se ven plantas, una mesa, sillas, suelo de madera, paredes, cactus.";
					$fecha = "29/09/2016";
					$pais = "España";
					$autor = "Jon Snow";
				} else {
					$titulo = "Jardín de mi comunidad";
					$foto = "02.jpg";
					$descripcion = "Foto subí jardín casa, estar bien, ven plantas, mesa, sillas, suelo de madera, paredes, cactus.";
					$fecha = "22/09/2016";
					$pais = "España";
					$autor = "Ygritte";
				}
			}else{
				$error=true;
			}
		}
		else{
			$error=true;
		}
	} 
	$title = "Detalle de foto";
	$cssfile = "detalle";
	include("includes/head.php");
	include("includes/header.php");
?>
<section>
	<div class="cabecera">
		<h1><?php echo $titulo; ?></h1>
	</div>
	<article>
		<div class="image">
			<img src="images/<?php echo $foto; ?>" width="500" alt="Foto"/>
			<div class="info">
				<p class="descripcion"><?php echo $descripcion;?></p>
				<p><?php echo $fecha; ?> - <?php echo $pais; ?></p>
				<p><b><a href="perfil.php"><?php echo $autor; ?></a></b></p>
			</div>
		</div>
		<div class="comments">
			<h1>Comentarios</h1>
			<p class="coment"><b><a href="perfil.php">Ygritte:</a></b> You know nothing John Snow</p>
		</div>
		<div class="clear"></div>
	</article>
</section>
<?php
	include("includes/footer.php");
?>
