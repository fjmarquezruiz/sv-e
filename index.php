<?php 
// Comprobacion de que si estan estan estas variables de sesion creadas, sean destruidas.
if (isset($_SESSION['iduser']))
{
	echo "<p>destruyendo al usuario</p>";
	unset($_SESSION['iduser']);
}

if (isset($_SESSION['tipouser']))
{
	echo "<p>destruyendo el tipo de usuario</p>";
	unset($_SESSION['tipouser']);
}

if (isset($_SESSION['la_encuesta']))
{
	echo "<p>destruyendo la encuesta</p>";
	unset($_SESSION['la_encuesta']);
}

// Inclusion de la cabecera de la pagina html.
include('./includes/cabecera.inc');
?>

<form action="./login.php" method="POST" name="FORM">
	<table border=0 cellpadding=5 cellspacing=0 align=center>
		<tr>
			<td width=50% align=center valign=middle>
		Login:
			</td>
			<td width=50% align=center valign=middle>
		<input type="text" name="login_entrada" size="15" maxlength="15">
			</td>
		</tr>
		<tr>
			<td width=50% align=center valign=middle>
		Password:
			</td>
			<td width=50% align=center valign=middle>
		<input type="password" name="password_entrada" size="15" maxlength="15">
			</td>
		</tr>
		<tr>
			<td align=center valign=middle width=50%>
		<input type="reset" value="Borrar" class="boton">
			</td>
			<td align=center valign=middle width=50%>
		<input type="button" value="enviar" onclick="valida_entrada(this.form)" class="boton">
			</td>
		</tr>
	</table>
</form>

<?php
// Inclusion del pie de la pagina html.
include('./includes/pie.inc');
?>