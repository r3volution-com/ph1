<?php
session_start();
include("includes/config.php");
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$db) die("ERROR CRITICO: NO HAY CONEXION CON LA BASE DE DATOS");
$db->set_charset("utf8");
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>WePic - <?php echo $title; ?></title>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css"/>
        <link href="css/style.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="css/style-print.css" rel="stylesheet" type="text/css" media="print"/>
		<link href="css/style-accesible.css" rel="alternate stylesheet" type="text/css" title="Accesible"/>
		<link href="css/<?php echo $cssfile; ?>.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="css/<?php echo $cssfile; ?>-print.css" rel="stylesheet" type="text/css" media="print"/>
	</head>
