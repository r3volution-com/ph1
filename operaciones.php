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
					//Comprobamos con los del profesor
					$user=$_POST["nombre"];
					$pass=$_POST["pass"];
					$response = $db->query("SELECT * FROM usuarios WHERE nombre='".$db->real_escape_string($user)."'");
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
					//Comprobamos con los del profesor
					$user   = $_POST["nombre"];
					$pass   = $_POST["pass"];
					$pass2  = $_POST["pass2"];
					$email  = $_POST["email"];
					$ciudad = $_POST["ciudad"];
					$pais   = $_POST["pais"];
					$sexo   = $_POST["sexo"];
					$fecha  = $_POST["fecha"];
					$foto   = $_POST["foto"];
					if (strlen($user) < 3 || strlen($user) > 15) {
						header("location: index.php?q=registro&error=bad_length_name");
						exit;
					}
					$response = $db->query("SELECT * FROM usuarios WHERE nombre='".$db->real_escape_string($user)."'");
					if($response->num_rows != 0){
						header("location: index.php?q=registro&error=user_already_exists");
						exit;
					}
					if (strlen($pass) < 6 || strlen($pass) > 15) {
						header("location: index.php?q=registro&error=bad_length_pass");
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
					$response = $db->query("SELECT * FROM usuarios WHERE email='".$db->real_escape_string($email)."'");
					if($response->num_rows != 0){
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
					header("location: index.php");
				} else header("location: index.php?error=0");
			}
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
		
		default:
		
		break;
	}
?>
