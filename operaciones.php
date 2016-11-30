<?php
session_start();
	include ("includes/config.php");
	$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$db->set_charset("utf8");
	if(!isset($_GET["operacion"])){
		header("location: index.php");
	}
	$opt=$_GET["operacion"];
	switch($opt){
		case "login":
			if(isset($_POST)){
				if(isset($_POST["nombre"]) && isset($_POST["pass"])){
					$user=$db->real_escape_string($_POST["nombre"]);
					$pass=$db->real_escape_string($_POST["pass"]);
					$response = $db->query("SELECT * FROM usuarios WHERE nombre='".$user."'");
					if($response->num_rows>0){
						$row=$response->fetch_array();
						if($row["clave"]==sha1($pass)){
							if(isset($_POST["remember"]) && ($_POST["remember"]=="Yes" || $_POST["remember"]=="on")){
								setcookie("remember_user", $user, time()+3600);
								setcookie("remember_pass", $pass, time()+3600);
								setcookie("remember_time", time(), time()+3600);
							}
							$_SESSION["remember"]=$row;
							header("location: principal.php");
							exit;
						}else{
							header("location: index.php?error");
						}
					}else{
						header("location: index.php?error");
					}
				}
			}
		break;
		case "register":
			if(isset($_POST)){
				if(isset($_POST["nombre"]) && isset($_POST["pass"]) && isset($_POST["pass2"]) && isset($_POST["email"]) && isset($_POST["ciudad"])
					 && isset($_POST["pais"]) && isset($_POST["sexo"]) && isset($_POST["fecha"]) && isset($_POST["foto"])){
					$user   = $db->real_escape_string($_POST["nombre"]);
					$pass   = $db->real_escape_string($_POST["pass"]);
					$pass2  = $db->real_escape_string($_POST["pass2"]);
					$email  = $db->real_escape_string($_POST["email"]);
					$ciudad = $db->real_escape_string($_POST["ciudad"]);
					$pais   = $db->real_escape_string($_POST["pais"]);
					$sexo   = $db->real_escape_string($_POST["sexo"]);
					$fecha  = $db->real_escape_string($_POST["fecha"]);
					$foto   = "";//$db->real_escape_string($_POST["foto"]);
					if (strlen($user) < 3 || strlen($user) > 15) {
						header("location: index.php?q=registro&error=bad_length_name");
						exit;
					}
					$response = $db->query("SELECT * FROM usuarios WHERE nombre='".$user."'");
					if($response && $response->num_rows != 0){
						header("location: index.php?q=registro&error=user_already_exists");
						exit;
					}
					if (ctype_alnum($user)){
						header("location: index.php?q=registro&error=user_only_alphanumeric");
						exit;
					}
					if (strlen($pass) < 6 || strlen($pass) > 15) {
						header("location: index.php?q=registro&error=bad_length_pass");
						exit;
					}
					if (ctype_alnum(str_replace('_', '', $pass))){
						header("location: index.php?q=registro&error=pass_only_alphanumeric");
						exit;
					}
					if ($pass != $pass2){
						header("location: index.php?q=registro&error=pass_not_equals");
						exit;
					}
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
						header("location: index.php?q=registro&error=bad_email");
						exit;
					}
					$response = $db->query("SELECT * FROM usuarios WHERE email='".$email."'");
					if($response && $response->num_rows != 0){
						header("location: index.php?q=registro&error=email_already_exists");
						exit;
					}
					if ($sexo != "h" && $sexo != "m"){
						header("location: index.php?q=registro&error=bad_sex");
						exit;
					}
					if (!strtotime($fecha)){
						header("location: index.php?q=registro&error=bad_date");
						exit;
					}
					if (!is_numeric($pais)){
						header("location: index.php?q=registro&error=country_not_found");
						exit;
					}
					$response = $db->query("SELECT * FROM paises WHERE id='".$pais."'");
					if($response && $response->num_rows != 0){
						header("location: index.php?q=registro&error=country_not_found");
						exit;
					}
					$db->query("INSERT INTO usuarios (nombre, clave, email, sexo, fechaNacimiento, ciudad, idPais, foto) VALUES ('".$user."', '".sha1($pass)."', '".$email."', '".$sexo."', '".$fecha."', '".$ciudad."', ".$pais.", '".$foto."')");
					header("location: index.php");
				} else header("location: index.php?error=bad_params");
			}
		break;
		
		case "modificaruser":
			if(isset($_POST)){
				if(isset($_POST["pass"]) && isset($_POST["pass2"]) && isset($_POST["email"]) && isset($_POST["ciudad"])
				&& isset($_POST["pais"]) && isset($_POST["sexo"]) && isset($_POST["foto"])){
					$response = $db->query("SELECT * FROM usuarios WHERE id=".$_SESSION["remember"]["id"]);
					if (!$response) {
						header("location: modificaperfil.php?error=user_no_exists");
						exit;
					}
					$row = $response->fetch_assoc();
					$pass   = $db->real_escape_string($_POST["pass"]);
					$pass2  = $db->real_escape_string($_POST["pass2"]);
					$email  = $db->real_escape_string($_POST["email"]);
					$ciudad = $db->real_escape_string($_POST["ciudad"]);
					$pais   = $db->real_escape_string($_POST["pais"]);
					$sexo   = $db->real_escape_string($_POST["sexo"]);
					//$foto   = $db->real_escape_string($_POST["foto"]);
					$extra = array();
					if ($pass != "" && $pass != $row["clave"]){
						if (strlen($pass) < 6 || strlen($pass) > 15) {
							header("location: modificaperfil.php?error=bad_length_pass");
							exit;
						}
						if ($pass != $pass2){
							header("location: modificaperfil.php?error=pass_not_equals");
							exit;
						}
						if (ctype_alnum(str_replace('_', '', $pass))){
							header("location: modificaperfil.php?error=pass_only_alphanumeric");
							exit;
						}
						$extra[] = " clave='".sha1($pass)."' ";
					}
					if ($email != "" && $email != $row["email"]){
						if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
							header("location: modificaperfil.php?error=bad_email");
							exit;
						}
						$response = $db->query("SELECT * FROM usuarios WHERE email='".$email."'");
						if($response->num_rows != 0){
							header("location: modificaperfil.php?error=email_already_exists");
							exit;
						}
						$extra[] = " email='".$email."' ";
					}
					if ($ciudad != "" && $ciudad != $row["ciudad"]){
						$extra[] = " ciudad='".$ciudad."' ";
					}
					if ($pais != "" && $pais != $row["pais"] && is_numeric($pais)){
						$response = $db->query("SELECT * FROM paises WHERE id=".$pais);
						if($response->num_rows != 0){
							header("location: modificaperfil.php?error=country_not_found");
							exit;
						}
						$extra[] = " pais=".$pais." ";
					}
					if ($sexo != "" && $sexo != $row["sexo"]){
						if ($sexo != "h" && $sexo != "m"){
							header("location: modificaperfil.php?error=bad_sex");
							exit;
						}
						$extra[] = " sexo='".$sexo."' ";
					}
					$extraquery = implode(",", $extra);
					if($extraquery != "") $db->query("UPDATE usuarios SET ".$extraquery." WHERE id=".$row["id"]);
				}else header("location: modificaperfil.php?error=bad_params");
			}
		break;
		
		case "crearalbum":
			if(isset($_POST)){
				if(isset($_POST["titulo"]) && isset($_POST["descripcion"]) && isset($_POST["pais"]) && isset($_POST["date"])){
					$response = $db->query("SELECT * FROM usuarios WHERE id=".$_SESSION["remember"]["id"]);
					if (!$response) {
						header("location: modificaperfil.php?error=user_no_exists");
						exit;
					}
					$titulo  = $db->real_escape_string($_POST["titulo"]);
					$descripcion  = $db->real_escape_string($_POST["descripcion"]);
					$date = $db->real_escape_string($_POST["date"]);
					$pais   = $db->real_escape_string($_POST["pais"]);
					if (strlen($titulo) < 3 || strlen($titulo) > 200) {
						header("location: index.php?q=registro&error=bad_length_title");
						exit;
					}
					if (strlen($descripcion) < 3 || strlen($descripcion) > 4000) {
						header("location: index.php?q=registro&error=bad_length_desc");
						exit;
					}
					if (!is_numeric($pais)){
						header("location: index.php?q=registro&error=country_not_found");
						exit;
					}
					$response = $db->query("SELECT * FROM paises WHERE id='".$pais."'");
					if($response && $response->num_rows != 0){
						header("location: index.php?q=registro&error=country_not_found");
						exit;
					}
					if (!strtotime($fecha)){
						header("location: index.php?q=registro&error=bad_date");
						exit;
					}
					$db->query("INSERT INTO albumes (titulo, descripcion, fecha, idPais) VALUES ('".$titulo."', '".$descripcion."', '".$date."', ".$pais.")");
					header("location: index.php");
				} else header("location: modificaperfil.php?error=bad_params");
			}
		break;
		
		case "fotoalbum":
		
		break;
		
		case "solicitaalbum":
		
		break;
		
		case "logout":
			if(isset($_SESSION["remember"])){
				unset($_SESSION["remember"]);
				if(isset($_COOKIE["remember_user"])){
					setcookie("remember_user", "", time() -3600);
					setcookie("remember_pass", "", time() -3600);
					setcookie("remember_time", "", time() -3600);
				}
				header("location: index.php");
			}
		break;
		
		case "deletecookie":
			if(isset($_COOKIE["remember_user"])){
				setcookie("remember_user", "", time() -3600);
				setcookie("remember_pass", "", time() -3600);
				setcookie("remember_time", "", time() -3600);
			}
			header("location: index.php");
		break;
		
		case "semilogout":
			if(isset($_SESSION["remember"])){
				unset($_SESSION["remember"]);
			}
			header("location: index.php");
		break;
		
		case "dardebaja":
			if (isset($_SESSION["remember"])){
				$db->query("DELETE FROM usuarios WHERE id=".$_SESSION["remember"]["id"]);
			}
			header("location: index.php");
		break;
		
		default:
			die("No existe esa opcion.<br><a href='index.php'>Volver</a>");
		break;
	}
?>
