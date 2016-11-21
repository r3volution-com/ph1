<?php
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

	if(strlen($nombre)<51){
		echo"Se ha excedido el tamaño máximo de campo";
	}
	if(strlen($titulo)<21){
		echo"Se ha excedido el tamaño máximo de campo";
	}
	if(strlen($adicional)<201){
		echo"Se ha excedido el tamaño máximo de campo";
	}
	if (filter_var($email, FILTER_VALIDATE_EMAIL)){
		if(strlen($email)<21){
			echo"Se ha excedido el tamaño máximo de campo";
		}
	}
	if(strlen($direccion)<21){
		echo"Se ha excedido el tamaño máximo de campo";
	}
	if(strlen($numero)<10){
		echo"Se ha excedido el tamaño máximo de campo";
	}
	if(strlen($cod)<6){
		echo"Se ha excedido el tamaño máximo de campo";
	}
	if(strlen($localidad)<11){
		echo"Se ha excedido el tamaño máximo de campo";
	}
	if(strlen($prov)<11){
		echo"Se ha excedido el tamaño máximo de campo";
	}
	if(strlen($pais)<11){
		echo"Se ha excedido el tamaño máximo de campo";
	}
?>