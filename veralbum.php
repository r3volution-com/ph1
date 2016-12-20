<?php
	$title = "Ver álbum";
	$cssfile = "veralbum";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
	$error = false;
	if (isset($_GET["pg"]) && $_GET["pg"] > 0) $pg = $_GET["pg"];
	else $pg = 1;
	if (isset($_GET["id"])){
		$id = $db->real_escape_string($_GET["id"]);
		if(is_numeric($id)){
			if($id>=0){
				$res = $db->query("SELECT titulo FROM albumes WHERE id=".$id);
				if (!$res || ($res && $res->num_rows <= 0)) $error = true;
				$album = $res->fetch_array();
				$res2 = $db->query('SELECT count(*) as cuantos FROM fotos WHERE idAlbum='.$id);
				if (!$res2 || ($res2 && $res2->num_rows <= 0)) $error = true;
				$row2 = $res2->fetch_assoc();
				$total = $row2["cuantos"];
				$tupla = 10;
				$npaginas = $total/$tupla;
				if (($total % $tupla) > 0) $npaginas = $npaginas +1;
				if ($total > $tupla) $extra = "LIMIT ".(($pg-1)*$tupla).", ".$tupla;
				else $extra = "";
				$response = $db->query("SELECT id, titulo, descripcion, fecha, idAlbum, idPais, ruta, (SELECT titulo FROM albumes WHERE id=idAlbum) as nombreAlbum,".
					"(SELECT nombre FROM paises WHERE id=idPais) as nombrePais, ".
					"(SELECT nombre FROM usuarios WHERE id=(SELECT idUsuario FROM albumes WHERE id=idAlbum)) as nombreUsuario, ".
					"(SELECT foto FROM usuarios WHERE id=(SELECT idUsuario FROM albumes WHERE id=idAlbum)) as fotoUsuario, ".
					"(SELECT idUsuario FROM albumes WHERE id=idAlbum) as idUsuario FROM fotos where idAlbum=$id ORDER BY fechaSubida DESC ".$extra);
				if (!$response) $error = true;
			} else $error=true;
		} else $error=true;
	} else $error = true;

	if (!$error){
	?>
<section>
	<h2 class="h2"><?php echo $album["titulo"]; ?></h2>
	<a class="foto2" href="subefoto.php?idalbum=<?php echo $id; ?>">Añadir foto</a>
	<a class="foto3" href="listalbumes.php">Volver a la lista</a>
	<?php
		if($response->num_rows<=0) echo "<p>No hay fotos</p>";
		else {
			while ($row = $response->fetch_array()){
				?>
		<article>
			<div class="image">
				<a href="detalle.php?id=<?php echo $row["id"]; ?>"><img src="uploads/bigthumb_<?php echo $row["ruta"]; ?>" width="800" alt="Foto"/></a>
			</div>
			<div class="info">
				<a href="detalle.php?id=<?php echo $row["id"]; ?>"><h3><?php echo $row["titulo"]; ?></h3></a>
				<p class="left"><?php echo date("d/m/Y", strtotime($row["fecha"])); ?></p>
				<p class="right author"><a href="detalleusuario.php?id=<?php echo $row["idUsuario"]; ?>"><img src="uploads/<?php echo ($row["fotoUsuario"]) ? "thumb_".$row["fotoUsuario"] : "user.png"; ?>" alt="Perfil"/><b><?php echo $row["nombreUsuario"]; ?></b></a></p>
				<p class="clear"></p>
			</div>
		</article>
	<?php 	}
		}
?>
</section>
<?php
		if ($total > $tupla) {
			echo "<section>";
			for ($i = 1; $i <= $npaginas; $i++) {
				if ($i == $pg) echo $i;
				else echo "<a href='veralbum.php?id=".$_GET["id"]."&pg=".$i."'>".$i."</a>";
				if ($i < $npaginas-1) echo " - ";
			}
			echo "</section>";
		}
	} else echo "<section>ERROR</section>";
	include("includes/footer.php");
?>
