<?php
	$title = "Pagina principal";
	$cssfile = "principal";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
	$response = $db->query("SELECT id, titulo, descripcion, fecha, idAlbum, idPais, ruta FROM fotos ORDER BY fechaSubida DESC LIMIT 5");
	if(!$response){
		die("<section>No hay fotos".$db->error."</section>");
	}
?>
<section>
<?php 
	if($response->num_rows<=0) echo "No hay fotos"; 
	else { 
		while ($row = $response->fetch_array()){ 
			$r_pais = $db->query("SELECT nombre FROM paises WHERE id=".$row["idPais"]);
			$pais = $r_pais->fetch_array();
			$r_usuario = $db->query("SELECT * FROM usuarios WHERE id=(SELECT idUsuario FROM albumes WHERE id=".$row["idAlbum"].")");
			$usuario = $r_usuario->fetch_array();
	?>
	<article>
		<div class="image">
			<a href="detalle.php?id=<?php echo $row["id"]; ?>"><img src="images/<?php echo $row["ruta"]; ?>" width="800" alt="Foto"/></a>
		</div>
		<div class="info">
			<a href="detalle.php?id=<?php echo $row["id"]; ?>"><h3><?php echo $row["titulo"]; ?></h3></a>
			<p class="left"><?php echo $row["fecha"]; ?> - <?php echo $pais["nombre"]; ?></p>
			<p class="right author"><a href="perfil.php?id=<?php echo $usuario["id"]; ?>"><img src="images/<?php echo $usuario["foto"]; ?>" alt="Perfil"/><b><?php echo $usuario["nombre"]; ?></b></a></p>
			<p class="clear"></p>
		</div>
	</article>
<?php }
} ?>
</section>
<?php
	include("includes/footer.php");
?>

