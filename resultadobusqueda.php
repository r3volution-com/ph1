<?php
	$title = "Resultados de la busqueda";
	$cssfile = "principal";
	include("includes/head.php");
	include("includes/header.php");
	if(isset($_GET["search"])) $search = $_GET["search"];
	else $search = "";
	if (isset($_GET["pais"]) && $_GET["pais"]) $pais = $_GET["pais"];
	else $pais = 0;
	if (isset($_GET["fecha"]) && $_GET["fecha"]) $fecha= date("Y-m-d", strtotime($_GET['fecha']));
	else $fecha = "";
	$extra = "WHERE 1=1";
	$extra2 = "";
	if ($search) $extra .= " AND titulo LIKE '%".$db->real_escape_string($search)."%'";
	if ($pais) $extra .= " AND idPais=".$db->real_escape_string($pais);
	if ($fecha) $extra .= " AND fecha='".$db->real_escape_string($fecha)."'";
	if(!$search && !$fecha && !$pais){
		$extra2 = " LIMIT 10";
	}
	$query = "SELECT id, titulo, descripcion, fecha, idAlbum, idPais, ruta, (SELECT titulo FROM albumes WHERE id=idAlbum) as nombreAlbum,".
		"(SELECT nombre FROM paises WHERE id=idPais) as nombrePais, ".
		"(SELECT nombre FROM usuarios WHERE id=(SELECT idUsuario FROM albumes WHERE id=idAlbum)) as nombreUsuario, ".
		"(SELECT foto FROM usuarios WHERE id=(SELECT idUsuario FROM albumes WHERE id=idAlbum)) as fotoUsuario, ".
		"(SELECT idUsuario FROM albumes WHERE id=idAlbum) as idUsuario FROM fotos $extra ORDER BY fechaSubida DESC $extra2";
	$response = $db->query($query);
	if(!$response){
		die("error: ".$query);
	}
?>
<section class="search">
	<form method="GET" action="resultadobusqueda.php">
		<label for="search">Buscar</label>
		<input type="text" placeholder="Buscar" value="<?php echo $search;?>" name="search" id="search"/>
		<?php if ($pais != 0){?>
			<select id="pais" name="pais" disabled>
				<option value="0">Elija un país</option>
				<?php
					$res_pais = $db->query("SELECT id,nombre FROM paises ORDER BY nombre");
					while($row=$res_pais->fetch_array()){
						$selected = "";
						if ($row["id"] == $pais) $selected = "selected";
						echo '<option '.$selected.' value="'.$row["id"].'">'.$row["nombre"].'</option>';
					}
				?>
			</select>
		<?php } ?>
		<?php if ($fecha) echo '<input id="fecha" name="fecha" type="date" value="'.$fecha.'" disabled/>'; ?>
		<input type="submit" value="Buscar"/> - <a href="buscafoto.php"><b>Búsqueda avanzada</b></a>
	</form>
</section>
<section class="results">
	<h1>Resultados</h1>
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
			<p class="right author"><a href="detalleusuario.php?id=<?php echo $row["idUsuario"]; ?>"><img src="uploads/<?php echo ($row["fotoUsuario"]) ? "thumb_".$row["fotoUsuario"] : "user.png"; ?>" alt="Perfil"/><b><?php echo $row["nombreUsuario"]; ?></b></a></p>
			<p class="clear"></p>
		</div>
	</article>
<?php }
} ?>
</section>
<?php
	include("includes/footer.php");
?>
