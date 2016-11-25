<?php
	session_start();
	include ("includes/config.php");
	
	if(isset($_SESSION["remember"])==true){
		header("location: principal.php");
		exit;
	}
	if(isset($_GET["q"]) && $_GET["q"]=="login"){
		$pagina="l";
	}else if(isset($_GET["q"]) && $_GET["q"]=="registro"){
		$pagina="r";
	}else{
		$pagina="l";
	}
	$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$db->set_charset("utf8");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
		<?php
			if($pagina=="l"){
		?>
			<title>WePic - Control de acceso</title>

		<?php
			}else if($pagina=="r"){
		?>
			<title>WePic - Registro</title>
		<?php
			}
		?>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css"/>
        <link href="css/outside-style.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="css/outside-style-print.css" rel="stylesheet" type="text/css" media="print"/>
		<link href="css/style-accesible.css" rel="alternate stylesheet" type="text/css" title="Accesible"/> 
    </head>
    <body>
		<nav>
			<div class="left"><img src="images/logo.png" alt="Logo"/></div>
			<div class="right">
				<form method="GET" action="resultadobusqueda.php" style="display: inline-block;">
					<label for="search" class="hide">Buscar</label>
					<input type="text" placeholder="Buscar" name="search" id="search"/>
					<input class="material-icons search-icon" type="submit" value="search"/>
				</form>
				<?php
					if($pagina=="l"){
				?>
					<a href="index.php?q=registro" class="btn"><i class="material-icons lefticon">person_add</i>Regístrate</a>
				<?php
					}else if($pagina=="r"){
				?>
					<a href="index.php?q=login" class="btn"><i class="material-icons lefticon">person_add</i>Conéctate</a>
				<?php
					}
				?>
			</div>
			<div class="clear"></div>
		</nav>
		<?php
			if($pagina=="l"){
				include("includes/login.php");
			}else if($pagina=="r"){
				include("includes/registro.php");
			}
		?>
		<footer>
			WePic ©2016
		</footer>
	</body>
</html>
<?php
	$db->close();
?>
