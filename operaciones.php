<?php
session_start();
	include ("includes/config.php");
	$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$db->set_charset("utf8");
	if(!isset($_GET["operacion"])){
		header("location: index.php");
	}
	$opt=$_GET["operacion"];
	function sanear_string($string) {
	    $string = trim($string);
	    $string = str_replace(
	        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
	        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
	        $string
	    );
	    $string = str_replace(
	        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
	        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
	        $string
	    );
	    $string = str_replace(
	        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
	        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
	        $string
	    );
	    $string = str_replace(
	        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
	        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
	        $string
	    );
	    $string = str_replace(
	        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
	        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
	        $string
	    );
	    $string = str_replace(
	        array('ñ', 'Ñ', 'ç', 'Ç'),
	        array('n', 'N', 'c', 'C',),
	        $string
	    );
	    //Esta parte se encarga de eliminar cualquier caracter extraño
	    $string = str_replace(
	        array("\\", "¨", "º", "-", "~",
	             "#", "@", "|", "!", "\"",
	             "·", "$", "%", "&", "/",
	             "(", ")", "?", "'", "¡",
	             "¿", "[", "^", "<code>", "]",
	             "+", "}", "{", "¨", "´",
	             ">", "< ", ";", ",", ":",
	             " "),
	        '',
	        $string
	    );
	    return $string;
	}
	function createThumbnail($image_name, $new_width, $new_height, $uploadDir){
	    $path = $uploadDir . '/' . $image_name;
	    $mime = getimagesize($path);
	    if($mime['mime']=='image/png'){ $src_img = imagecreatefrompng($path); }
	    if($mime['mime']=='image/jpg'){ $src_img = imagecreatefromjpeg($path); }
	    if($mime['mime']=='image/jpeg'){ $src_img = imagecreatefromjpeg($path); }
	    if($mime['mime']=='image/pjpeg'){ $src_img = imagecreatefromjpeg($path); }
	    $old_x          =   imageSX($src_img);
	    $old_y          =   imageSY($src_img);
	    if($old_x > $old_y) {
	        $thumb_w    =   $new_width;
	        $thumb_h    =   $old_y*($new_height/$old_x);
	    }
	    if($old_x < $old_y) {
	        $thumb_w    =   $old_x*($new_width/$old_y);
	        $thumb_h    =   $new_height;
	    }
	    if($old_x == $old_y) {
	        $thumb_w    =   $new_width;
	        $thumb_h    =   $new_height;
	    }
	    $dst_img        =   ImageCreateTrueColor($thumb_w,$thumb_h);
	    imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);
	    // New save location
	    $new_thumb_loc = $uploadDir . "thumb_".$image_name;
	    if($mime['mime']=='image/png'){ $result = imagepng($dst_img,$new_thumb_loc,8); }
	    if($mime['mime']=='image/jpg'){ $result = imagejpeg($dst_img,$new_thumb_loc,80); }
	    if($mime['mime']=='image/jpeg'){ $result = imagejpeg($dst_img,$new_thumb_loc,80); }
	    if($mime['mime']=='image/pjpeg'){ $result = imagejpeg($dst_img,$new_thumb_loc,80); }
	    imagedestroy($dst_img);
	    imagedestroy($src_img);
	    return $result;
	}
	switch($opt){
		case "login":
			if(isset($_POST)){
				if(isset($_POST["nombre"]) && isset($_POST["pass"])){
					$user=$db->real_escape_string($_POST["nombre"]);
					$pass=$db->real_escape_string($_POST["pass"]);
					$response = $db->query("SELECT * FROM usuarios WHERE nombre='".$user."'");
					if($response && $response->num_rows>0){
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
					 && isset($_POST["pais"]) && isset($_POST["sexo"]) && isset($_POST["fecha"])){
					$user   = $db->real_escape_string($_POST["nombre"]);
					$pass   = $db->real_escape_string($_POST["pass"]);
					$pass2  = $db->real_escape_string($_POST["pass2"]);
					$email  = $db->real_escape_string($_POST["email"]);
					$ciudad = htmlentities($db->real_escape_string($_POST["ciudad"]));
					$pais   = $db->real_escape_string($_POST["pais"]);
					$sexo   = $db->real_escape_string($_POST["sexo"]);
					$fecha  = $db->real_escape_string($_POST["fecha"]);
					if (strlen($user) < 3 || strlen($user) > 15) {
						header("location: index.php?q=registro&error=bad_length_name");
						exit;
					}
					$response = $db->query("SELECT * FROM usuarios WHERE nombre='".$user."'");
					if(!$response || ($response && $response->num_rows != 0)){
						header("location: index.php?q=registro&error=user_already_exists");
						exit;
					}
					if (!ctype_alnum($user)){
						header("location: index.php?q=registro&error=user_only_alphanumeric");
						exit;
					}
					if (strlen($pass) < 6 || strlen($pass) > 15) {
						header("location: index.php?q=registro&error=bad_length_pass");
						exit;
					}
					if (!ctype_alnum(str_replace('_', '', $pass))){
						header("location: index.php?q=registro&error=pass_only_alphanumeric");
						exit;
					}
					if (!preg_match("#[0-9]+#", $pass)) {
						header("location: index.php?q=registro&error=pass_no_number");
						exit;
					}
					if (!preg_match("#[a-z]+#", $pass)) {
						header("location: index.php?q=registro&error=pass_no_lowercase");
						exit;
					}
					if (!preg_match("#[A-Z]+#", $pass)) {
						header("location: index.php?q=registro&error=pass_no_uppercase");
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
					if(!$response || ($response && $response->num_rows != 0)){
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
					if(!$response && ($response && $response->num_rows == 0)){
						header("location: index.php?q=registro&error=country_not_found");
						exit;
					}
					if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {
						if (!is_uploaded_file($_FILES['foto']['tmp_name'])) {
							header("location: index.php?q=registro&error=file_not_found");
							exit;
						}
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						if (finfo_file($finfo, $_FILES['foto']['tmp_name']) != "image/jpeg" && finfo_file($finfo, $_FILES['foto']['tmp_name']) != "image/png"){
							header("location: index.php?q=registro&error=wrong_photo_type");
							exit;
						}
						if (filesize($_FILES['foto']['tmp_name']) > 10485760){
							header("location: index.php?q=registro&error=wrong_photo_size");
							exit;
						}
						$foto = sanear_string(basename($_FILES['foto']['name']));
						if (!$foto){
							header("location: index.php?q=registro&error=wrong_photo_name");
							exit;
						}
						$rutafoto = UPLOAD_DIR.$user."_".$foto;
						if(!@move_uploaded_file($_FILES['foto']['tmp_name'], $rutafoto)) {
							header("location: index.php?q=registro&error=file_not_found");
							exit;
						}
						createThumbnail($user."_".$foto, 50, 50, UPLOAD_DIR);
						if (!file_exists($rutafoto)){
							header("location: index.php?q=registro&error=file_not_found");
							exit;
						}
					} else $foto = "";
					$db->query("INSERT INTO usuarios (nombre, clave, email, sexo, fechaNacimiento, ciudad, idPais, foto) VALUES ('".$user."', '".sha1($pass)."', '".$email."', '".$sexo."', '".$fecha."', '".$ciudad."', ".$pais.", '".$user."_".$foto."')");
					header("location: index.php");
				} else header("location: index.php?error=bad_params");
			}
		break;

		case "modificaruser":
			if(isset($_POST)){
				if(isset($_POST["pass"]) && isset($_POST["pass2"]) && isset($_POST["email"]) && isset($_POST["ciudad"])
				&& isset($_POST["pais"]) && isset($_POST["sexo"])){
					$response = $db->query("SELECT * FROM usuarios WHERE id=".$_SESSION["remember"]["id"]);
					if (!$response || ($response && $response->num_rows == 0)) {
						header("location: modificaperfil.php?error=user_no_exists");
						exit;
					}
					$row = $response->fetch_assoc();
					$pass   = $db->real_escape_string($_POST["pass"]);
					$pass2  = $db->real_escape_string($_POST["pass2"]);
					$email  = $db->real_escape_string($_POST["email"]);
					$ciudad = htmlentities($db->real_escape_string($_POST["ciudad"]));
					$pais   = $db->real_escape_string($_POST["pais"]);
					$sexo   = $db->real_escape_string($_POST["sexo"]);
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
						if (!ctype_alnum(str_replace('_', '', $pass))){
							header("location: modificaperfil.php?error=pass_only_alphanumeric");
							exit;
						}
						if (!preg_match("#[0-9]+#", $pass)) {
							header("location: modificaperfil.php?error=pass_no_number");
							exit;
						}
						if (!preg_match("#[a-z]+#", $pass)) {
							header("location: modificaperfil.php?error=pass_no_lowercase");
							exit;
						}
						if (!preg_match("#[A-Z]+#", $pass)) {
							header("location: modificaperfil.php?error=pass_no_uppercase");
							exit;
						}
						$_SESSION["remember"]["clave"] = sha1($pass);
						$extra[] = " clave='".sha1($pass)."' ";
					}
					if ($email != "" && $email != $row["email"]){
						if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
							header("location: modificaperfil.php?error=bad_email");
							exit;
						}
						$response = $db->query("SELECT * FROM usuarios WHERE email='".$email."'");
						if(!$response || ($response && $response->num_rows != 0)){
							header("location: modificaperfil.php?error=email_already_exists");
							exit;
						}
						$_SESSION["remember"]["email"] = $email;
						$extra[] = " email='".$email."' ";
					}
					if ($ciudad != "" && $ciudad != $row["ciudad"]){
					$_SESSION["remember"]["ciudad"] = $ciudad;
						$extra[] = " ciudad='".$ciudad."' ";
					}
					if ($pais != "" && $pais != $row["idPais"] && is_numeric($pais)){
						$response = $db->query("SELECT * FROM paises WHERE id=".$pais);
						if(!$response || ($response && $response->num_rows == 0)){
							header("location: modificaperfil.php?error=country_not_found");
							exit;
						}
						$_SESSION["remember"]["idPais"] = $pais;
						$extra[] = " idPais=".$pais." ";
					}
					if ($sexo != "" && $sexo != $row["sexo"]){
						if ($sexo != "h" && $sexo != "m"){
							header("location: modificaperfil.php?error=bad_sex");
							exit;
						}
						$_SESSION["remember"]["sexo"] = $sexo;
						$extra[] = " sexo='".$sexo."' ";
					}
					if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {
						if (!is_uploaded_file($_FILES['foto']['tmp_name'])) {
							header("location: modificaperfil.php?error=file_not_found");
							exit;
						}
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						if (finfo_file($finfo, $_FILES['foto']['tmp_name']) != "image/jpeg" && finfo_file($finfo, $_FILES['foto']['tmp_name']) != "image/png"){
							header("location: modificaperfil.php?error=wrong_photo_type");
							exit;
						}
						if (filesize($_FILES['foto']['tmp_name']) > 10485760){
							header("location: modificaperfil.php?error=wrong_photo_size");
							exit;
						}
						$foto = sanear_string(basename($_FILES['foto']['name']));
						if (!$foto){
							header("location: modificaperfil.php?error=wrong_photo_name");
							exit;
						}
						$rutafoto = UPLOAD_DIR.$row["nombre"]."_".$foto;
						if(!@move_uploaded_file($_FILES['foto']['tmp_name'], $rutafoto)) {
							header("location: modificaperfil.php?error=file_not_found");
							exit;
						}
						createThumbnail($row["nombre"]."_".$foto, 50, 50, UPLOAD_DIR);
						if (!file_exists($rutafoto)){
							header("location: modificaperfil.php?error=file_not_found");
							exit;
						}

						if ($row["foto"]) unlink($row["foto"]);
						$_SESSION["remember"]["foto"] = $row["nombre"]."_".$foto;
						$extra[] = "foto='".$row["nombre"]."_".$foto."'";
					}
					$extraquery = implode(",", $extra);
					if($extraquery != "") {
						$db->query("UPDATE usuarios SET ".$extraquery." WHERE id=".$row["id"]);
						if(isset($_COOKIE["remember_user"])){
							setcookie("remember_user", "", time() -3600);
							setcookie("remember_pass", "", time() -3600);
							setcookie("remember_time", "", time() -3600);
						}
					}
					header("location: perfil.php");
				}else header("location: modificaperfil.php?error=bad_params");
			}
		break;

		case "crearalbum":
			if(isset($_POST)){
				if(isset($_POST["titulo"]) && isset($_POST["descripcion"]) && isset($_POST["pais"]) && isset($_POST["date"])){
					$response = $db->query("SELECT * FROM usuarios WHERE id=".$_SESSION["remember"]["id"]);
					if (!$response || ($response && $response->num_rows == 0)) {
						header("location: crearalbum.php?error=user_no_exists");
						exit;
					}
					$titulo  = htmlentities($db->real_escape_string($_POST["titulo"]));
					$descripcion  = htmlentities($db->real_escape_string($_POST["descripcion"]));
					$fecha = $db->real_escape_string($_POST["date"]);
					$pais   = $db->real_escape_string($_POST["pais"]);
					if (strlen($titulo) < 3 || strlen($titulo) > 200) {
						header("location: crearalbum.php?error=bad_length_title");
						exit;
					}
					if (strlen($descripcion) < 3 || strlen($descripcion) > 4000) {
						header("location: crearalbum.php?error=bad_length_desc");
						exit;
					}
					if (!is_numeric($pais)){
						header("location: crearalbum.php?error=country_not_found");
						exit;
					}
					$response = $db->query("SELECT * FROM paises WHERE id=".$pais);
					if(!$response || ($response && $response->num_rows == 0)){
						header("location: crearalbum.php?error=country_not_found");
						exit;
					}
					if (!strtotime($fecha)){
						header("location: crearalbum.php?error=bad_date");
						exit;
					}
					$db->query("INSERT INTO albumes (titulo, descripcion, fecha, idPais, idUsuario) VALUES ('".$titulo."', '".$descripcion."', '".$fecha."', ".$pais.", ".$_SESSION["remember"]["id"].")");
					if ($db->error) die($db->error." INSERT INTO albumes (titulo, descripcion, fecha, idPais, idUsuario) VALUES ('".$titulo."', '".$descripcion."', '".$fecha."', ".$pais.", ".$_SESSION["remember"]["id"].")");
					header("location: perfil.php");
				} else header("location: crearalbum.php?error=bad_params");
			}
		break;

		case "fotoalbum":
			if(isset($_POST)){
				if(isset($_POST["titulo"]) && isset($_POST["pais"]) && isset($_POST["date"]) && isset($_POST["album"]) && isset($_POST["descripcion"])){
					$response = $db->query("SELECT * FROM usuarios WHERE id=".$_SESSION["remember"]["id"]);
					if (!$response || ($response && $response->num_rows == 0)) {
						header("location: subefoto.php?error=user_no_exists");
						exit;
					}
					$titulo = htmlentities($db->real_escape_string($_POST["titulo"]));
					$fecha 	= $db->real_escape_string($_POST["date"]);
					$pais   = $db->real_escape_string($_POST["pais"]);
					$album  = $db->real_escape_string($_POST["album"]);
					$descripcion  = $db->real_escape_string($_POST["descripcion"]);
					if (strlen($titulo) < 3 || strlen($titulo) > 200) {
						header("location: subefoto.php?error=bad_length_title");
						exit;
					}
					if (strlen($descripcion) < 3 || strlen($descripcion) > 200) {
						header("location: subefoto.php?error=bad_length_description");
						exit;
					}
					if (!is_numeric($pais)){
						header("location: subefoto.php?error=country_not_found");
						exit;
					}
					$response = $db->query("SELECT * FROM paises WHERE id=".$pais);
					if(!$response || ($response && $response->num_rows == 0)){
						header("location: subefoto.php?error=country_not_found");
						exit;
					}
					if (!is_numeric($album)){
						header("location: subefoto.php?error=album_not_found");
						exit;
					}
					$response = $db->query("SELECT * FROM albumes WHERE id=".$album." AND idUsuario=".$_SESSION["remember"]["id"]);
					if(!$response || ($response && $response->num_rows == 0)){
						header("location: subefoto.php?error=album_not_found");
						exit;
					}
					if (!strtotime($fecha)){
						header("location: subefoto.php?error=bad_date");
						exit;
					}
					if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {
						if (!is_uploaded_file($_FILES['foto']['tmp_name'])) {
							header("location: subefoto.php?error=file_not_found");
							exit;
						}
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						if (finfo_file($finfo, $_FILES['foto']['tmp_name']) != "image/jpeg" && finfo_file($finfo, $_FILES['foto']['tmp_name']) != "image/png"){
							header("location: subefoto.php?error=wrong_photo_type");
							exit;
						}
						if (filesize($_FILES['foto']['tmp_name']) > 10485760){
							header("location: subefoto.php?error=wrong_photo_size");
							exit;
						}
						$tamano = getimagesize($_FILES['foto']['tmp_name']);
						if (($tamano[0] > 1125 || $tamano[0] < 500) || ($tamano[1] > 1125 || $tamano[1] < 500)){
							header("location: subefoto.php?error=wrong_photo_size");
							exit;
						}
						$foto = sanear_string(basename($_FILES['foto']['name']));
						if (!$foto){
							header("location: subefoto.php?error=wrong_photo_name");
							exit;
						}
						$foto = time()."_".sanear_string($foto);
						$rutafoto = UPLOAD_DIR.$foto;
						if(!@move_uploaded_file($_FILES['foto']['tmp_name'], $rutafoto)) {
							header("location: subefoto.php?error=file_not_found");
							exit;
						}
						if (!file_exists($rutafoto)){
							header("location: subefoto.php?error=file_not_found");
							exit;
						}
					}
					$db->query("INSERT INTO fotos (titulo, descripcion, idAlbum, fecha, idPais, ruta) VALUES ('".$titulo."', '".$descripcion."', ".$album.", '".$fecha."', ".$pais.", '".$foto."')");
					header("location: veralbum.php?id=".$album);
				} else header("location: subefoto.php?error=bad_params");
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

		case "dardebaja":
			if (isset($_SESSION["remember"])){
				$res = $db->query("DELETE FROM usuarios WHERE id=".$_SESSION["remember"]["id"]);
				if ($res){
					unset($_SESSION["remember"]);
					if(isset($_COOKIE["remember_user"])){
						setcookie("remember_user", "", time() -3600);
						setcookie("remember_pass", "", time() -3600);
						setcookie("remember_time", "", time() -3600);
					}
				} else die("ERROR al dar de baja ".$db->error);
			}
			header("location: index.php");
		break;

		default:
			die("No existe esa opcion.<br><a href='index.php'>Volver</a>");
		break;
	}
?>
