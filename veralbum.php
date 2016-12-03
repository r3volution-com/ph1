<?php
	$title = "Ver álbum";
	$cssfile = "principal";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
	$error = false;
	if (isset($_GET["id"])){
		$id = $db->real_escape_string($_GET["id"]);
		if(is_numeric($id)){
			if($id>=0){
				$res = $db->query("SELECT titulo FROM albumes WHERE id=".$id);
				if (!$res || ($res && $res->num_rows <= 0)) $error = true;
				$album = $res->fetch_array();
				$response = $db->query("SELECT id, titulo, descripcion, fecha, idAlbum, idPais, ruta, (SELECT titulo FROM albumes WHERE id=idAlbum) as nombreAlbum,".
					"(SELECT nombre FROM paises WHERE id=(SELECT idPais FROM albumes WHERE id=idAlbum)) as nombrePais, ".
					"(SELECT nombre FROM usuarios WHERE id=(SELECT idUsuario FROM albumes WHERE id=idAlbum)) as nombreUsuario, ".
					"(SELECT foto FROM usuarios WHERE id=(SELECT idUsuario FROM albumes WHERE id=idAlbum)) as fotoUsuario, ".
					"(SELECT idUsuario FROM albumes WHERE id=idAlbum) as idUsuario FROM fotos where idAlbum=$id ORDER BY fechaSubida DESC");
				if (!$response) $error = true;
			} else $error=true;
		} else $error=true;
	} else $error = true;
?>
<section>
	<?php
	if (!$error){
	?>
	<h2><?php echo $album["titulo"]; ?></h2>
	<a class="foto2" href="subefoto.php?idalbum=<?php echo $row["id"]; ?>">Añadir foto</a>
	<?php
		if($response->num_rows<=0) echo "No hay fotos";
		else {
			while ($row = $response->fetch_array()){
				?>
		<article>
			<div class="image">
				<a href="detalle.php?id=<?php echo $row["id"]; ?>"><img src="images/<?php echo $row["ruta"]; ?>" width="800" alt="Foto"/></a>
			</div>
			<div class="info">
				<a href="detalle.php?id=<?php echo $row["id"]; ?>"><h3><?php echo $row["titulo"]; ?></h3></a>
				<p class="left"><?php echo date("d/m/Y", strtotime($row["fecha"])); ?> - <?php echo $row["nombrePais"]; ?></p>
				<p class="right author"><a href="perfil.php?id=<?php echo $row["idUsuario"]; ?>"><img src="images/<?php echo $row["fotoUsuario"]; ?>" alt="Perfil"/><b><?php echo $row["nombreUsuario"]; ?></b></a></p>
				<p class="clear"></p>
			</div>
		</article>
	<?php 	}
		}
	} else echo "ERROR";

?>
</section>
<?php
	include("includes/footer.php");
?>
