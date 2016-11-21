<?php
session_start();
	include ("includes/config.php");
	$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$db->set_charset("utf8");
	$opt=$_GET["operacion"];
	switch($opt){
		case "login":
			if(isset($_POST)){
				if(isset($_POST["nombre"]) && isset($_POST["pass"])){
					//Comprobamos con los del profesor
					$user=$_POST["nombre"];
					$pass=$_POST["pass"];
					$response = $db->query("SELECT nombre,clave FROM usuarios WHERE nombre='".$db->real_escape_string($user)."'");
					if($response->num_rows>0){
						$row=$response->fetch_array();
						if($row["clave"]==sha1($pass)){
							if(isset($_POST["remember"]) && ($_POST["remember"]=="Yes" || $_POST["remember"]=="on")){
								setcookie("remember_user", $user, time()+3600);
								setcookie("remember_pass", $pass, time()+3600);
								setcookie("remember_time", time(), time()+3600);
							}
							$_SESSION["remember"]=$user;
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
					$email  = $_POST["email"];
					$ciudad = $_POST["ciudad"];
					$pais   = $_POST["pais"];
					$sexo   = $_POST["sexo"];
					$fecha  = $_POST["fecha"];
					$foto   = $_POST["foto"];
					if($user != "" && $user == "johnsnow" && $user == "ygritte" && $user == "test"){
						if ($pass == $pass2){
							if (filter_var($email, FILTER_VALIDATE_EMAIL)){
								header("location: index.php");
							} else header("location: index.php?q=registro&error=3");
						} else header("location: index.php?error=2");
					} else header("location: index.php?error=1");
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
