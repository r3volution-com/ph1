<?php
	error_reporting(E_ALL);
	$title = "Perfil";
	$cssfile = "perfil";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
	if (isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] > 0){
		$response = $db->query("SELECT nombre, email, ciudad, idPais, sexo, foto, fechaNacimiento FROM usuarios WHERE id=".$_GET["id"]);
		if ($response && $response->num_rows){
			$row = $response->fetch_assoc();
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
			$myself = false;
		} else die ("<section>ERROR: id incorrecta ".$db->error."</section>");
	}else{
		$nombre = $_SESSION["remember"]["nombre"];
		$email = $_SESSION["remember"]["email"];
		$ciudad = $_SESSION["remember"]["ciudad"];
		$response = $db->query("SELECT nombre FROM paises WHERE id=".$_SESSION["remember"]["idPais"]);
		if ($response && $response->num_rows){
			$row_pais = $response->fetch_assoc();
			$pais = $row_pais["nombre"];
		} else $pais = "Desconocido";
		$sexo = ($_SESSION["remember"]["sexo"] == 0) ? "Hombre" : "Mujer";
		$foto = $_SESSION["remember"]["foto"];
		$myself = true;
		$fecha = date("d/m/Y", strtotime($_SESSION["remember"]["fechaNacimiento"]));
	}
?>
<section>
	<div class="perfil">
		<div class="cabecera">
			<img src="uploads/<?php echo ($foto) ? $foto : "user.png"; ?>" alt="Foto"/>
			<h2><?php echo $nombre; ?></h2>
		</div>
		<div class="section-profile">
			<p><b>Email: </b><?php echo $email; ?></p>
			<p><b>Sexo: </b><?php echo $sexo; ?></p>
			<p><b>Fecha de nacimiento: </b><?php echo $fecha; ?></p>
			<p><b>País: </b><?php echo $pais; ?></p>
			<?php if ($myself){ ?>
			<p><b><a class="boton2" href="modificaperfil.php">Modificar datos</a></b></p>
			<p><b><a class="boton2" href="dardebaja.php">Darse de baja</a></b></p>
			<?php } ?>
		</div>
		<div class="section-profile buttons">
		<?php if ($myself){ ?>
			<div class="boton">
				<a href="listalbumes.php">Visualizar album</a>
			</div>
			<div class="boton">
				<a href="crearalbum.php">Crear album</a>
			</div>
			<div class="boton">
				<a href="solicitaralbum.php">Imprimir album</a>
			</div>
			<?php } ?>
		</div>
	</div>
</section>
<?php
	include("includes/footer.php");
?>
