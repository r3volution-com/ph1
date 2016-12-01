<?php
	$title = "Detalle de foto";
	$cssfile = "enviado";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
		exit;
	}
	if(!isset($_POST["nombre"])){
		header("location: index.php");
		exit;
	}
	$nombre = $_POST["nombre"];
	$titulo = $_POST["titulo"];
	$adicional = $_POST["adicional"];
	$email = $_POST["email"];
	$direccion = $_POST["direccion"];
	$numero = $_POST["numero"];
	$cod = $_POST["cod"];
	$localidad = $_POST["localidad"];
	$prov = $_POST["prov"];
	$pais = $_POST["pais"];
	$color = $_POST["color"];
	$res = $_POST["res"];
	$numcopias = $_POST["numcopias"];
	$album = $_POST["album"];
	$date = $_POST["date"];
	$colored = $_POST["colored"];
	$error = false;
	include("includes/header.php");
?>
<section class="box">
<?php
	if(strlen($nombre)>51){
		echo"Se ha excedido el tamaño máximo de campo <b>Nombre</b>";
		$error=true;
	}
	if(strlen($titulo)>21){
		echo"Se ha excedido el tamaño máximo de campo <b>Título</b>";
		$error=true;
	}
	if(strlen($adicional)>201){
		echo"Se ha excedido el tamaño máximo de campo <b>Texto adicional</b>";
		$error=true;
	}
	if (filter_var($email, FILTER_VALIDATE_EMAIL)){
		if(strlen($email)>21){
			echo"Se ha excedido el tamaño máximo de campo <b>Email</b>";
			$error=true;
		}
	}
	if(strlen($direccion)>21){
		echo"Se ha excedido el tamaño máximo de campo <b>Dirección</b>";
		$error=true;
	}
	if(strlen($numero)>10){
		echo"Se ha excedido el tamaño máximo de campo <b>Número</b>";
		$error=true;
	}
	if(strlen($cod)>6){
		echo"Se ha excedido el tamaño máximo de campo <b>Código postal</b>";
		$error=true;
	}
	if(strlen($localidad)>11){
		echo"Se ha excedido el tamaño máximo de campo <b>Localidad</b>";
		$error=true;
	}
	if(strlen($prov)>11){
		echo"Se ha excedido el tamaño máximo de campo <b>Provincia</b>";
		$error=true;
	}
	if(strlen($pais)>11){
		echo"Se ha excedido el tamaño máximo de campo <b>País</b>";
		$error=true;
	}
	if($error == false){
		$db->query("INSERT INTO fotos (titulo, idAlbum, fecha, idPais, ruta) VALUES ('".$titulo."', ".$album.", '".$date."', ".$pais.", '".$ruta."')");
?>
<h1>Pedido realizado</h1>
	<p>Su pedido de envío de album impreso ha sido registrado. El coste es de <em><?php echo (($res/100)*$numcopias)+$colored; ?>€</em></p>
<?php
	}
?>
	<br><br><a class="ref" href="solicitaralbum.php">Volver</a>
</section>
<?php
	include("includes/footer.php");
?>
