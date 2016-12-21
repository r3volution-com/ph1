<?php
	$title = "Perfil";
	$cssfile = "detalleusuario";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
	if (isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] > 0){
		$response = $db->query("SELECT id, nombre, email, ciudad, idPais, sexo, foto, fechaNacimiento FROM usuarios WHERE id=".$_GET["id"]);
		if ($response && $response->num_rows){
			$row = $response->fetch_assoc();
			$id = $row["id"];
			$nombre = $row["nombre"];
			$email = $row["email"];
			$ciudad = $row["ciudad"];
			$response = $db->query("SELECT nombre FROM paises WHERE id=".$row["idPais"]);
			if ($response && $response->num_rows){
				$row_pais = $response->fetch_assoc();
				$pais = $row_pais["nombre"];
			} else $pais = "Desconocido";
			$sexo = ($row["sexo"] == 0) ? "Hombre" : "Mujer";
			$foto = $row["foto"];
			$fecha = date("d/m/Y", strtotime($row["fechaNacimiento"]));
			$idalbum = mysql_real_escape_string($_GET["id"]);
			$response2 = $db->query("SELECT id, titulo, descripcion, fecha, (SELECT nombre FROM paises WHERE id=idPais) as nombrePais, (SELECT ruta from fotos WHERE idAlbum=albumes.id LIMIT 1) as default_image ".
	"FROM albumes WHERE idUsuario=".$idalbum." ORDER BY fecha DESC LIMIT 5");
			$myself = false;
		} else die ("<section>ERROR: id incorrecta ".$db->error."</section>");
	}
	else die ("<section>ERROR: id incorrecta ".$db->error."</section>");
?>
<section>
	<div class="perfil2">
		<div class="cabecera">
			<img src="uploads/<?php echo ($foto) ? $foto : "user.png"; ?>" alt="Foto" style="max-height: 100px;"/>
			<h2><?php echo $nombre; ?></h2>
		</div>

		<div class="section-profile">
			<p><b>Email: </b><?php echo $email; ?></p>
			<p><b>Sexo: </b><?php echo $sexo; ?></p>
			<p><b>Fecha de nacimiento: </b><?php echo $fecha; ?></p>
			<p><b>País: </b><?php echo $pais; ?></p>
			<p><b>Ciudad: </b><?php echo $ciudad; ?></p>
		</div>
		<div class="cabecera2">
		<h1>Tus álbumes</h1>
		</div>

<?php
	if(!$myself){
		if($response2->num_rows<=0) echo 'No tienes ningun album<br>';
		else {
			while ($row = $response2->fetch_array()){
		?>
		<article class="article">
			<div class="aux">
			<div class="image">
				<a href="veralbum.php?id=<?php echo $row["id"]; ?>"><img src="uploads/tinythumb_<?php echo ($row["default_image"]) ? $row["default_image"] : "nofoto.png"; ?>" alt="Foto"/></a>
			</div>
			<div class="info">
				<div class="titulo"><a href="veralbum.php?id=<?php echo $row["id"]; ?>"><?php echo $row["titulo"]; ?></a></div>
				<div class="descripcion"><?php echo $row["descripcion"]; ?></div>
				<div class="pais"><?php echo $row["nombrePais"]; ?></div>
				<div class="fecha"><?php echo $row["fecha"]; ?></div>
			</div>
			<div class="clear">
			</div>
			</div>
		</article>
		<?php }
		}
	}?>
</section>
<?php
	include("includes/footer.php");
?>
