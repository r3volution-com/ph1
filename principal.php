<?php
	$title = "Pagina principal";
	$cssfile = "principal";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
	$response = $db->query("SELECT id, titulo, descripcion, fecha, idAlbum, idPais, (SELECT titulo FROM albumes WHERE id=idAlbum) as nombreAlbum,".
		"(SELECT nombre FROM paises WHERE id=(SELECT idPais FROM albumes WHERE id=idAlbum)) as nombrePais, ".
		"(SELECT nombre FROM usuarios WHERE id=(SELECT idUsuario FROM albumes WHERE id=idAlbum)) as nombreUsuario, ".
		"(SELECT foto FROM usuarios WHERE id=(SELECT idUsuario FROM albumes WHERE id=idAlbum)) as fotoUsuario, ".
		"(SELECT idUsuario FROM albumes WHERE id=idAlbum) as idUsuario, ruta FROM fotos ORDER BY fechaSubida DESC LIMIT 5");
	if(!$response){
		die("<section>No hay fotos".$db->error."</section>");
	}
?>
<?php/*
		if(($fichero = @file("importante.txt"))==false){
			echo "No se ha podido abrir el fichero";
		}
		else{
			echo "<pre>\n";
			$ids=array();
			$auxarray=array();
			foreach($fichero as $numLinea => $linea){
				$aux=htmlspecialchars($linea, ENT_NOQUOTES, "UTF-8");
				$claves = preg_split("/[_]+/", $aux);
				$id=$claves[0];
				$nombre=$claves[1];
				$fecha=trim($claves[2]);
				$ids[]=$id;
				$auxarray[]=array("id" => $id, "nombre" => $nombre, "fecha" => $fecha);
			}
			$idsmayor=max($ids);
			$idsmenor=min($ids);
			$rand=rand($idsmenor, $idsmayor);
			$key = array_search($rand, array_column($auxarray, 'id'));
			print_r($auxarray[$key]);
			echo "</pre>\n";
			$response = $db->query("SELECT titulo, descripcion, fecha, idAlbum, ruta, idPais FROM fotos WHERE id=$rand");
			if(!$response){
					die("<section>No hay fotos".$db->error."</section>");
				}
			if($response->num_rows<=0) echo "No hay fotos";
			else{
				$row = $response->fetch_assoc();
				print_r($row);
			}
		}
		*/
		?>
<section>
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
			<p class="right author"><a href="perfil.php?id=<?php echo $row["idUsuario"]; ?>">
				<img src="images/<?php echo $row["fotoUsuario"]; ?>" alt="Perfil"/><b><?php echo $row["nombreUsuario"]; ?></b></a>
			</p>
			<p class="clear"></p>
		</div>
	</article>
<?php }
} ?>
</section>
<?php
	include("includes/footer.php");
?>
