<?php
	$title = "Detalle de foto";
	$cssfile = "enviado";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
		exit;
	}
	if(!isset($_POST["nombre"]) ||!isset($_POST["titulo"]) || !isset($_POST["adicional"]) || !isset($_POST["email"]) ||
	!isset($_POST["direccion"]) || !isset($_POST["numero"]) ||  !isset($_POST["cod"]) || !isset($_POST["localidad"]) ||
	!isset($_POST["prov"]) || !isset($_POST["pais"]) || !isset($_POST["color"]) || !isset($_POST["res"]) ||
	!isset($_POST["numcopias"]) || !isset($_POST["album"]) || !isset($_POST["date"]) || !isset($_POST["colored"])){
		header("location: index.php");
		exit;
	}
	$nombre = htmlentities($db->real_escape_string($_POST["nombre"]));
	$titulo = htmlentities($db->real_escape_string($_POST["titulo"]));
	$descripcion = htmlentities($db->real_escape_string($_POST["adicional"]));
	$email = $db->real_escape_string($_POST["email"]);
	$direccion = htmlentities($db->real_escape_string($_POST["direccion"]));
	$numero = $db->real_escape_string($_POST["numero"]);
	$cod = $db->real_escape_string($_POST["cod"]);
	$localidad = htmlentities($db->real_escape_string($_POST["localidad"]));
	$prov = htmlentities($db->real_escape_string($_POST["prov"]));
	$pais = $db->real_escape_string($_POST["pais"]);
	$color = $db->real_escape_string($_POST["color"]);
	$res = $db->real_escape_string($_POST["res"]);
	$numcopias = $db->real_escape_string($_POST["numcopias"]);
	$album = $db->real_escape_string($_POST["album"]);
	$date = $db->real_escape_string($_POST["date"]);
	$colored = $db->real_escape_string($_POST["colored"]);
	$error = false;
	include("includes/header.php");
?>
<section class="box">
<?php
	if(strlen($nombre)>51){
		echo"Se ha excedido el tamaño máximo de campo <b>Nombre</b><br>";
		$error=true;
	}
	if(strlen($titulo)>21){
		echo"Se ha excedido el tamaño máximo de campo <b>Título</b><br>";
		$error=true;
	}
	if(strlen($descripcion)>201){
		echo"Se ha excedido el tamaño máximo de campo <b>Texto adicional</b><br>";
		$error=true;
	}
	if (filter_var($email, FILTER_VALIDATE_EMAIL)){
		if(strlen($email)>21){
			echo"Se ha excedido el tamaño máximo de campo <b>Email</b><br>";
			$error=true;
		}
	} else {
		echo"El <b>Email</b> introducido no es valido<br>";
		$error=true;
	}
	if(strlen($direccion)>50){
		echo"Se ha excedido el tamaño máximo de campo <b>Dirección</b><br>";
		$error=true;
	}
	if(strlen($numcopias)>10 || !is_numeric($numcopias)){
		echo"Se ha excedido el tamaño máximo o no es valido el campo <b>Número</b><br>";
		$error=true;
	}
	if(strlen($album)>10 || !is_numeric($album)){
		echo"Se ha excedido el tamaño máximo o no es valido el campo <b>Album</b><br>";
		$error=true;
	}
	if(strlen($cod)>6){
		echo"Se ha excedido el tamaño máximo de campo <b>Código postal</b><br>";
		$error=true;
	}
	if(strlen($localidad)>50){
		echo"Se ha excedido el tamaño máximo de campo <b>Localidad</b><br>";
		$error=true;
	}
	if(strlen($prov)>20){
		echo"Se ha excedido el tamaño máximo de campo <b>Provincia</b><br>";
		$error=true;
	}
	if(strlen($pais)>2 || !is_numeric($pais)){
		echo"Se ha excedido el tamaño máximo de campo <b>País</b><br>";
		$error=true;
	}
	if($error == false){
		$precio = (($res/100)*$numcopias)+$colored;
		$db->query("INSERT INTO solicitudes (nombre, titulo, descripcion, email, idAlbum, direccion, idPais, color, nCopias, resolucion, ".
		"fecha, portadaColor, coste) VALUES ('".$nombre."', '".$titulo."', '".$descripcion."', '".$email."', ".$album.", '".
		$direccion."', ".$pais.", '".$color."', ".$numcopias.", ".$res.", '".$date."', '".$colored."', '".$precio."')");
?>
<h1>Pedido realizado</h1>
	<p>Su pedido de envío de album impreso ha sido registrado. El coste es de <em><?php echo $precio; ?>€</em></p>
<?php
	}
?>
	<br><br><a class="ref" href="solicitaralbum.php">Volver</a>
</section>
<?php
	include("includes/footer.php");
?>
