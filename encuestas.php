<?php 
// Inclusion del codigo de seguridad de los Votantes, si no pasa por aqui no se podra
// ver la pagina.
include('./includes/seguridad_vot.inc');

// Si existe en memoria la variable de sesion 'la_encuesta' esta se tendria que destruir.
if (isset($_SESSION['la_encuesta']))
{
	echo "<p>Ya existe una encuesta en memoria... destruyendola</p>";
	unset($_SESSION['la_encuesta']);
}

// Inclusion de la cabecera de la pagina html.
include('./includes/cabecera.inc');
?>

<table border=0 width=100% cellpadding=5 cellspacing=0 align=center>
	<tr>
		<th>
		</th>
		<th width=27%>
	Encuestas NO votadas
		</th>
		<th width=5%>
		</th>
		<th width=27%>
	Encuestas votadas
		</th>
		<th>
		</th>
	</tr>
	<tr>
		<td></td>
		<td class="conborde" align=center>
	<!-- OPCIONES Encuestas no VOTADAS -->
<?php 
// 1 ------------------------------------------------------------------------------------------------
// Obtencion de la fecha actual.
$fecha_actual = date("Ymd");

// Sentencia SQL que muestra aquellas Encuestas en las que el votante no ha votado y que ha
// fecha actual puede votar.
$sentencia_sql="SELECT Encuestas.* FROM Encuestas LEFT JOIN Vota ON ((Encuestas.Codigo_Encuesta=Vota.Codigo_Encuesta) AND (Vota.Codigo_Votante = ".$id.")) WHERE (Vota.Codigo_Encuesta IS NULL) AND (Encuestas.Fecha_Fin >= ".$fecha_actual.") AND (Encuestas.Fecha_Inicio <= ".$fecha_actual.") ORDER BY Encuestas.Titulo_Encuesta";
$link1=conecta("fjmarkez_es_db");
$sql1 = mysql_query($sentencia_sql);
if (!$sql1) 
{
	echo "<P>Consulta SQL erronea (SELECT 1)</P>";
}
else
{
	if ($row1 = mysql_fetch_row($sql1))
	{
		echo "<form action='./muestra_encuesta.php' method='POST'>\n";
		echo "<table border=0 cellpadding=5 cellspacing=0>\n";
		echo "<tr>\n";
			echo "<td align=left valign=middle>\n";
			echo "1º Elige una una encuesta\n";
			echo "</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
			echo "<td align=center valign=middle>\n";
			echo "<select name=\"que_encuesta\" size=1>";

			do
			{
				echo "<option value='".$row1[0]."'>".$row1[1]."</option>\n";
			}while ($row1 = mysql_fetch_row($sql1));
			
			echo "</select>\n";
			echo "</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
			echo "<td align=left valign=middle>\n";
			echo "2º Pulsa este boton\n";
			echo "</td>\n";
		echo "<tr>\n";
		echo "</tr>\n";
		echo "<tr>\n";
			echo "<td align=center valign=middle width=50%>\n";
			echo "<input type='submit' value='Ir a Votar' class='boton'>\n";
			echo "</td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		echo "</form>\n";

		desconecta($link1);
	}
	else
	{
		desconecta($link1);
		echo "Has votado en todas las Encuestas disponibles";
	}
}
// 1 ------------------------------------------------------------------------------------------------
?>
	<!-- FIN OPCIONES Encuestas no VOTADAS -->
		</td>
		<td>
		</td>
		<td class="conborde" align=center>
	<!-- OPCIONES DE Encuestas VOTADAS -->
<?php 
// 3 ------------------------------------------------------------------------------------------------
// Sentencia SQL que muestra todas las Encuestas en las que el usuario ha votado.
$sentencia_sql = "SELECT E.Codigo_Encuesta, E.Titulo_Encuesta FROM Encuestas AS E, Vota AS V WHERE (E.Codigo_Encuesta = V.Codigo_Encuesta) AND (V.Codigo_Votante = ".$id.")";
$link3=$link=conecta("fjmarkez_es_db");
$sql3 = mysql_query($sentencia_sql);
if (!$sql3) 
{
	echo "<P>Consulta SQL erronea (SELECT 3)</P>";
}
else
{
	if ($row3 = mysql_fetch_row($sql3))
	{
		echo "<form action='./muestra_resultado.php' method='POST'>\n";
		echo "<table border=0 cellpadding=5 cellspacing=0>\n";
		echo "<tr>\n";
			echo "<td align=left valign=middle>\n";
			echo "1º Elige una una encuesta\n";
			echo "</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
			echo "<td align=center valign=middle>\n";
			echo "<select name=\"que_encuesta\" size=1>";

			do
			{
				echo "<option value='".$row3[0]."'>".$row3[1]."</option>\n";
			}while ($row3 = mysql_fetch_row($sql3));
			
			echo "</select>\n";
			echo "</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
			echo "<td align=left valign=middle>\n";
			echo "2º Pulsa este boton\n";
			echo "</td>\n";
		echo "<tr>\n";
		echo "</tr>\n";
		echo "<tr>\n";
			echo "<td align=center valign=middle width=50%>\n";
			echo "<input type='submit' value='Ver Resultados' class='boton'>\n";
			echo "</td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		echo "</form>\n";

	}
	else
	{
		desconecta($link3);
		echo "<P>No ha votado en ninguna encuesta</P>\n";	
	}
}
// 3 ------------------------------------------------------------------------------------------------
?>
	<!-- FIN OPCIONES DE Encuestas VOTADAS -->
		</td>
		<td></td>
	</tr>
</table>
<br>
<center>
<a href='./index.php'>salir</a>
<?php 
// Inclusion del pie de la pagina html.
include('./includes/pie.inc');
?>