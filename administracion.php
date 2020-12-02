<?php 
// Inclusion del codigo de seguridad de la administracion, si no pasa por aqui no se podra
// ver la pagina.
include('./includes/seguridad_adm.inc');

// Si existe en memoria la variable de sesion 'la_encuesta' esta se tendria que destruir.
if (isset($_SESSION['la_encuesta']))
{
	echo "<p>Ya existe una encuesta en memoria... destruyendola</p>";
	unset($_SESSION['la_encuesta']);
}

// Inclusion de la cabecera de la pagina html.
include('./includes/cabecera.inc');

?>

<h3>administracion</h3>
<table border=0 width=100% cellpadding=5 cellspacing=0 align=center>
	<tr>
		<th>
		</th>
		<th width=27%>
	U S U A R I O S
		</th>
		<th width=5%>
		</th>
		<th width=27%>
	E N C U E S T A S
		</th>
		<th>
		</th>
	</tr>
	<tr>
		<td></td>
		<td class="conborde">
	<!-- OPCIONES DE USUARIOS -->
	<form action="./adm_usuarios1.php" method="POST">
		<input type="hidden" name="id" value="<?php echo $id?>">
		<table border=0 cellpadding=5 cellspacing=0>
			<tr>
				<td align=left valign=middle colspan=2>
			1º Elige una una tabla
				</td>
			</tr>
			<tr>
				<td align=center valign=middle colspan=2>
			<select name="tabla" size=1>
				<option value="0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
				<option value="1">Votantes</option>
				<option value="2">Administradores</option>
			</select>
				</td>
			</tr>
			<tr>
				<td align=left valign=middle colspan=2>
			2º Elige una una acción a realizar
				</td>
			</tr>
			<tr>
				<td align=center valign=middle colspan=2>
			<select name="accion" size=1>
				<option value="0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
				<option value="1">añadir</option>
				<option value="2">modificar</option>
				<option value="3">eliminar</option>
				<option value="4">buscar</option>
			</select>
				</td>
			</tr>
				<td align=left valign=middle colspan=2>
			3º Pulsa en cualquiera de estos<br>dos botones
				</td>
			<tr>
			</tr>
			<tr>
				<td align=center valign=middle width=50%>
			<input type="reset" value="Borrar" class="boton">
				</td>
				<td align=center valign=middle width=50%>
			<input type="button" value="Aceptar" onclick="valida_adm_usuarios(this.form)" class="boton">
				</td>
			</tr>
		</table>
	</form>
	<!-- FIN OPCIONES DE USUARIOS -->
		</td>
		<td>
		</td>
		<td class="conborde">
	<!-- OPCIONES DE Encuestas -->
	<form action="./adm_encuestas1.php" method="POST">
		<table border=0 cellpadding=5 cellspacing=0>
			<tr>
				<td align=left valign=middle colspan=2>
			1º Elige una una acción a realizar
				</td>
			</tr>
			<tr>
				<td align=center valign=middle colspan=2>
			<select name="accion" size=1>
				<option value="0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
				<option value="1">añadir</option>
				<option value="2">modificar</option>
				<option value="3">eliminar</option>
				<option value="4">buscar</option>
				<option value="5">ver resultados</option>
			</select>
				</td>
			</tr>
				<td align=left valign=middle colspan=2>
			2º Pulsa en cualquiera de estos<br>dos botones
				</td>
			<tr>
			</tr>
			<tr>
				<td align=center valign=middle width=50%>
			<input type="reset" value="Borrar" class="boton">
				</td>
				<td align=center valign=middle width=50%>
			<input type="button" value="Aceptar" onclick="valida_adm_Encuestas(this.form)" class="boton">
				</td>
			</tr>
		</table>
	</form>
	<!-- FIN OPCIONES DE Encuestas -->
		</td>
		<td></td>
	</tr>
</table>

<br>
<a href='./index.php'>salir</a>
<?php 
// Inclusion del pie de la pagina html.
include('./includes/pie.inc');
?>