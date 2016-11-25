<section class="box">
	<h2>Conéctate</h2>
	<?php if(isset($_COOKIE["remember_user"])) echo "Hola, <b>".$_COOKIE["remember_user"]."</b><br><br>Tu última visita fue: <br><b>".date("F j, Y, g:i a",$_COOKIE["remember_time"])."</b>";?>
	<form method="POST" action="operaciones.php?operacion=login">
		<label for="nombre" class="hide">Nombre</label>
		<input id="nombre" name="nombre" minlength="3" maxlength="15" type="<?php if(!isset($_COOKIE["remember_user"])) echo "text"; else echo "hidden";?>" placeholder="Nombre" value="<?php if(isset($_COOKIE["remember_user"])) echo $_COOKIE["remember_user"];?>"/><br>
		<label for="pass" class="hide">Contraseña</label>
		<input id="pass" name="pass" minlength="6" maxlength="15" type="<?php if(!isset($_COOKIE["remember_user"])) echo "password"; else echo "hidden";?>" placeholder="Contraseña" value="<?php if(isset($_COOKIE["remember_pass"])) echo $_COOKIE["remember_pass"];?>"/><br>
		<?php if(isset($_COOKIE["remember_user"])==false){?>
		<p>
			<input type="checkbox" name="remember" id="remember"/>
			<label for="remember">Recordar la contraseña</label>
		</p>
		<?php
			}else{
		?>
		<a href="operaciones.php?operacion=deletecookie" class="btn2">Dejar de recordar</a>
		<?php
			}
		?>
		<input id="submit" name="submit" type="submit" value="Acceder" />
	</form>
	<?php
	if(isset($_GET["error"])){
		echo "<br>El usuario y la contraseña no coinciden";
	}
	?>
</section>
