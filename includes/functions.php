<?php
function generarGrafico($values, $column_text){
	$columns  = count($values);

	// Get the height and width of the final image
    $width = 400;
    $height = 300;

	// Set the amount of space between each column
    $padding = 5;
	$padding_bottom = 15;

	// Get the width of 1 column
    $column_width = $width / $columns ;

	// Generate the image variables
    $im        = imagecreate($width,$height);
    $gray      = imagecolorallocate ($im,0xcc,0xcc,0xcc);
    $gray_lite = imagecolorallocate ($im,0xee,0xee,0xee);
    $gray_dark = imagecolorallocate ($im,0x7f,0x7f,0x7f);
    $white     = imagecolorallocate ($im,0xff,0xff,0xff);

	// Fill in the background of the image
    imagefilledrectangle($im,0,0,$width,$height,$white);
    $maxv = 0;

	// Calculate the maximum value we are going to plot
    for($i=0;$i<$columns;$i++)$maxv = max($values[$i],$maxv);

	// Now plot each column
    for($i=0;$i<$columns;$i++) {
        $column_height = ($height / 100) * (( $values[$i] / $maxv) *100);
        $x1 = $i*$column_width;
        $y1 = $height-$column_height;
        $x2 = (($i+1)*$column_width)-$padding;
        $y2 = $height-$padding_bottom;
		$color_texto = imagecolorallocate($im, 0, 0, 255);
		imagestring($im, 5, $x2 - $column_width/2 - 10, $y2 - 1, "".$column_text[$i], $color_texto);
		
		// This part is just for 3D effect
		if($values[$i]){
			imagefilledrectangle($im,$x1,$y1,$x2,$y2,$gray);
			imageline($im,$x1,$y1,$x1,$y2,$gray_lite);
			imageline($im,$x1,$y2,$x2,$y2,$gray_lite);
			imageline($im,$x2,$y1,$x2,$y2,$gray_dark);
		}
		imagestring($im, 5, $x2 - $column_width/2 - 5, $y2 - 15 - 3, "".$values[$i], $color_texto);
    }

    imagepng($im);
}
function sanear_string($string) {
	    $string = trim($string);
	    $string = str_replace(
	        array('�', '�', '�', '�', '�', '�', '�', '�', '�'),
	        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
	        $string
	    );
	    $string = str_replace(
	        array('�', '�', '�', '�', '�', '�', '�', '�'),
	        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
	        $string
	    );
	    $string = str_replace(
	        array('�', '�', '�', '�', '�', '�', '�', '�'),
	        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
	        $string
	    );
	    $string = str_replace(
	        array('�', '�', '�', '�', '�', '�', '�', '�'),
	        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
	        $string
	    );
	    $string = str_replace(
	        array('�', '�', '�', '�', '�', '�', '�', '�'),
	        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
	        $string
	    );
	    $string = str_replace(
	        array('�', '�', '�', '�'),
	        array('n', 'N', 'c', 'C',),
	        $string
	    );
	    //Esta parte se encarga de eliminar cualquier caracter extra�o
	    $string = str_replace(
	        array("\\", "�", "�", "-", "~",
	             "#", "@", "|", "!", "\"",
	             "�", "$", "%", "&", "/",
	             "(", ")", "?", "'", "�",
	             "�", "[", "^", "<code>", "]",
	             "+", "}", "{", "�", "�",
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
?>
