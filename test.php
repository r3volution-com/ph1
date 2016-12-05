<?php
include("includes/config.php");
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$db) die("ERROR CRITICO: NO HAY CONEXION CON LA BASE DE DATOS");
$db->set_charset("utf8");
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8"/>
		<title>Leer archivo</title>
	</head>
	<body>
		<?php
		if(($fichero = @file("importante.txt"))==false){
			echo "No se ha podido abrir el fichero";
		}
		else{
			echo "<pre>\n";
			$ids=array();
			$auxarray=array();
			foreach($fichero as $numLinea => $linea){
				$aux=htmlspecialchars($linea, ENT_NOQUOTES, "UTF-8");
				$claves = preg_split("/[_]+/", $aux);
				$id=$claves[0];
				$nombre=$claves[1];
				$fecha=trim($claves[2]);
				$ids[]=$id;
				$auxarray[]=array("id" => $id, "nombre" => $nombre, "fecha" => $fecha);
			}
			$idsmayor=max($ids);
			$idsmenor=min($ids);
			$rand=rand($idsmenor, $idsmayor);
			$key = array_search($rand, array_column($auxarray, 'id'));
			print_r($auxarray[$key]);
			echo "</pre>\n";
			$response = $db->query("SELECT titulo, descripcion, fecha, idAlbum, ruta, idPais FROM fotos WHERE id=$rand");
			if(!$response){
					die("<section>No hay fotos".$db->error."</section>");
				}
			if($response->num_rows<=0) echo "No hay fotos";
			else{
				$row = $response->fetch_assoc();
				print_r($row);
			}
		}
		?>
	</body>
</html>