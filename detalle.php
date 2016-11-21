<?php 
	$title = "Detalle de foto";
	$cssfile = "detalle";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	if (isset($_GET["id"])){
		$id = $_GET["id"];
		if(is_numeric($id)){
			if($id>=0){
				$response = $db->query("SELECT id, titulo, descripcion, fecha, idAlbum, idPais, ruta FROM fotos WHERE id=".$id." ORDER BY fechaSubida DESC");
				$foto = $response->fetch_array();
				$titulo = $foto["titulo"];
				$ruta = $foto["ruta"];
				$descripcion = $foto["descripcion"];
				$fecha = $foto["fecha"];
				$r_pais = $db->query("SELECT nombre FROM paises WHERE id=".$foto["idPais"]);
				$row_pais = $r_pais->fetch_array();
				$pais = $row_pais["nombre"];
				$r_usuario = $db->query("SELECT * FROM usuarios WHERE id=(SELECT idUsuario FROM albumes WHERE id=".$foto["idAlbum"].")");
				$row_usuario = $r_pais->fetch_array();
				$id_autor = $row_usuario["id"];
				$autor = $row_usuario["nombre"];
			}else{
				$error=true;
			}
		}
		else{
			$error=true;
		}
	} 
	include("includes/header.php");
?>
<section>
	<div class="cabecera">
		<h1><?php echo $titulo; ?></h1>
	</div>
	<article>
		<div class="image">
			<img src="images/<?php echo $ruta; ?>" width="500" alt="Foto"/>
			<div class="info">
				<p class="descripcion"><?php echo $descripcion;?></p>
				<p><?php echo $fecha; ?> - <?php echo $pais; ?></p>
				<p><b><a href="perfil.php?id=<?php echo $id_autor; ?>"><?php echo $autor; ?></a></b></p>
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
