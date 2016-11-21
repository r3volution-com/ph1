<?php
	$opt=$_GET["operacion"];
	switch($opt){
		case "login":
			if(isset($_POST)){
				if(isset($_POST["nombre"]) && isset($_POST["pass"])){
					//Comprobamos con los del profesor
					$user=$_POST["nombre"];
					$pass=$_POST["pass"];
					if(($user=="johnsnow" && $pass=="admin") || ($user=="ygritte" && $pass=="admin") || ($user=="test" && $pass=="admin")){
						header("location: principal.php");
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
		default:
		
		break;
	}
?>
