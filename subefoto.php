<?php
	$title = "Mis álbumes";
	$cssfile = "misalbumes";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
?>
<section>
	
</section>
<?php
	include("includes/footer.php");
?>

