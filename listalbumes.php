<?php
	$title = "Mis álbumes";
	$cssfile = "listalbumes";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
	$response = $db->query("SELECT id, titulo, descripcion, fecha, (SELECT nombre FROM paises WHERE id=idPais) as nombrePais, (SELECT ruta from fotos WHERE idAlbum=albumes.id LIMIT 1) as default_image ".
	"FROM albumes WHERE idUsuario=".$_SESSION["remember"]["id"]." ORDER BY fecha DESC LIMIT 5");
	if(!$response){
		die("<section>".$db->error."</section>");
	}
?>
<section>
	<div class="cabecera">
		<h1>Tus álbumes</h1>
		<?php if($response->num_rows>0) echo '<a class="foto" href="subefoto.php">Añadir foto</a>'; ?>
	</div>
<?php
	if($response->num_rows<=0) echo 'No tienes ningun album<br><a class="foto" href="crearalbum.php">Crea un album</a>';
	else {
		while ($row = $response->fetch_array()){
	?>
	<article>
		<div class="aux">
		<div class="image">
			<a href="veralbum.php?id=<?php echo $row["id"]; ?>"><img src="uploads/<?php echo $row["default_image"]; ?>" height=alt="Foto"/></a>
		</div>
		<div class="info">
			<div class="titulo"><a href="veralbum.php?id=<?php echo $row["id"]; ?>"><?php echo $row["titulo"]; ?></a></div>
			<a class="foto2" href="subefoto.php?idalbum=<?php echo $row["id"]; ?>">Añadir foto a este album</a>
			<div class="descripcion"><?php echo $row["descripcion"]; ?></div>
			<div class="pais"><?php echo $row["nombrePais"]; ?></div>
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
