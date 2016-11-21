<?php
	$title = "Solicitar album";
	$cssfile = "solicitaralbum";
	include("includes/head.php");
	if(isset($_SESSION["remember"])==false){
		header("location: index.php");
	}
	include("includes/header.php");
?>
<section class="box">
	<div class="content">
	<h2>Formulario de solicitud</h2>	
		<p>Permite solicitar un album de fotos impreso</p>
		<form id="formulario" action="enviado.php" method="post">
				<label for="nombre">Nombre completo</label>
				<input id="nombre" name="nombre" type="text" maxlength="200" required placeholder="Nombre completo"/>
				<label for="titulo">Título del album</label>
				<input id="titulo" name="titulo" type="text" maxlength="200" required placeholder="Título del album"/>
				<label for="adicional">Texto adicional</label>
				<textarea name="adicional" id="adicional" maxlength="4000" placeholder="Texto adicional"></textarea>
				<label for="email">Email</label>
				<input id="email" name="email" type="email" required placeholder="Email"/>
				<label for="direccion">Dirección</label>
				<input id="direccion" name="direccion" type="text" placeholder="Dirección"/> 
				<label for="numero">Número</label>
				<input id="numero" name="numero" type="number" placeholder="Número"/>
				<label for="cod">Código Postal</label>
				<input id="cod" name="cod" type="text" placeholder="Código Postal"/> 
				<label for="localidad">Localidad</label>
				<input id="localidad" name="localidad" type="text" placeholder="Localidad"/>
				<label for="prov">Provincia</label>
				<input id="prov" name="prov" type="text" placeholder="Provincia"/> 
				<label for="pais">País</label>
				<input id="pais" name="pais" type="text" placeholder="País"/>
				<p>
				<label class="label" for="color">Color de la portada</label>
				<input type="color" name="color" value="#000000">
				</p>
				<p>
				<label class="label" for="res">Resolución de las fotos</label>
				<input id="res" name="res" type="number" value="150" step="150" min="150" max="900" required placeholder="Resolución de las fotos"/>
				</p>
				<p>
				<label class="label" for="numcopias">Número de copias</label>
				<input id="numcopias" name="numcopias" type="number" value="1" min="1" placeholder="Número de copias"/>
				</p>
				<p>
				<label class="label" for="album">Album</label>
				<select id="album" name="album">
					<option value="1">Tu album 1</option>
					<option value="2">Tu album 2</option>
					<option value="3">Tu album 3</option>
					<option value="4">Tu album 4</option>
				</select>
</p>
				<p>
				<label class="label" for="date">Fecha de recepción</label>
				<input type="date" id="date" name="date">
				</p>
				<p>
				<label class="label" for="colored">¿Desea Impresión a color?</label>
				<select id="colored" name="colored">
					<option value="1" selected>Negro</option>
					<option value="2">Color</option>
				</select>
				</p>
			<input id="campo9" name="enviar" type="submit" value="Enviar" />
		</form>
	</div>
	<h3>Tarifas</h3>
	<table class="tabla">
		<thead>
			<tr>
				<th>Número de Páginas</th>
				<th>Resolución</th>
				<th>Color de la portada</th>
				<th>Precio</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>300ppp</td>
				<td>Blanco y Negro</td>
				<td>4€</td>
			</tr>
			<tr>
				<td>1</td>
				<td>150ppp</td>
				<td>Color</td>
				<td>3.5€</td>
			</tr>
			<tr>
				<td>2</td>
				<td>300ppp</td>
				<td>Blanco y Negro</td>
				<td>7€</td>
			</tr>
			<tr>
				<td>2</td>
				<td>300ppp</td>
				<td>Color</td>
				<td>8€</td>
			</tr>
		</tbody>
	</table>
</section>
<?php
	include("includes/footer.php");
?>
