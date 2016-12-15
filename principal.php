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

	if(($fichero = file("importante.txt"))==false){
		die("No se ha podido abrir el fichero");
	}
	else{
		$auxarray=array();
		foreach($fichero as $numLinea => $linea){
			$aux=htmlspecialchars($linea, ENT_NOQUOTES, "UTF-8");
			$claves = preg_split("/[_]+/", $aux);
			$auxarray[]=array("id" => $claves[0], "nombre" => $claves[1], "motivo" => trim($claves[2]));
		}
		$key=rand(0, count($fichero)-1);
		$id = $auxarray[$key]["id"];
		$important_response = $db->query("SELECT id, titulo, descripcion, fecha, idAlbum, ruta, idPais FROM fotos WHERE id=$id");
		if(!$important_response){
			die("<section>No hay fotos".$db->error."</section>");
		}
		if($important_response->num_rows<=0) echo "No hay fotos";
		else{
			$important_row = $important_response->fetch_assoc();
			$important_data = $id;
		}
	}
	if(isset($important_row)){
	?>
<section>
	<h2 class="trending">Trending</h2>
	<article>
		<div class="image">
			<a href="detalle.php?id=<?php echo $important_row["id"]; ?>"><img src="uploads/<?php echo $important_row["ruta"]; ?>" width="800" alt="Foto"/></a>
		</div>
		<div class="info">
			<a href="detalle.php?id=<?php echo $important_row["id"]; ?>"><h3><?php echo $important_row["titulo"]; ?></h3></a>
			<p class="left"><?php echo $important_data["motivo"]?></p>
			<p class="right author">
				<b><?php echo $important_data["nombre"]; ?></b></a>
			</p>
			<p class="clear"></p>
		</div>
	</article>
</section>
<?php
	}
	?>
<section class="section2">
<?php
	if($response->num_rows<=0) echo "No hay fotos";
	else {
		while ($row = $response->fetch_array()){
	?>
	<article>
		<div class="image">
			<a href="detalle.php?id=<?php echo $row["id"]; ?>"><img src="uploads/<?php echo $row["ruta"]; ?>" width="800" alt="Foto"/></a>
		</div>
		<div class="info">
			<a href="detalle.php?id=<?php echo $row["id"]; ?>"><h3><?php echo $row["titulo"]; ?></h3></a>
			<p class="left"><?php echo date("d/m/Y", strtotime($row["fecha"])); ?> - <?php echo $row["nombrePais"]; ?></p>
			<p class="right author"><a href="perfil.php?id=<?php echo $row["idUsuario"]; ?>">
				<img src="uploads/<?php echo ($row["fotoUsuario"]) ? "thumb_".$row["fotoUsuario"] : "user.png"; ?>" alt="Perfil"/><b><?php echo $row["nombreUsuario"]; ?></b></a>
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
