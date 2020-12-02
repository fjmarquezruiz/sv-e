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

// Captura de las variables necesarias que vienen de "encuestas.php"
$que_encuesta=$_POST['que_encuesta'];

// 1 ------------------------------------------------------------------------------------------------
// Sentencia SQL para mostrar la encuesta que se ha seleccionado.
$sentencia_sql = "SELECT Titulo_Encuesta FROM Encuestas WHERE Codigo_Encuesta = ".$que_encuesta;
$link1=conecta("fjmarkez_es_db");
$sql1 = mysql_query($sentencia_sql);
if (!$sql1) 
{
	desconecta($link1);
	echo $sentencia_sql."<br>";
	echo "<P>Consulta SQL erronea (SELECT 1)</P>";
}
else
{
	if ($row1 = mysql_fetch_row($sql1))
	{
		do
		{
			echo "<h3>Encuesta \"".$row1[0]."\"</h3>\n";
		}while ($row1 = mysql_fetch_row($sql1));
		desconecta($link1);
// 2 ------------------------------------------------------------------------------------------------
		// Sentencia SQL que muestra las Preguntas de la encuesta elegida.
		$sentencia_sql = "SELECT Codigo_Pregunta,Titulo_Pregunta FROM Preguntas WHERE Codigo_Encuesta = ".$que_encuesta;
		$enlace2=conecta("fjmarkez_es_db");
		$sql2 = mysql_query($sentencia_sql);
		if (!$sql2) 
		{
			desconecta($enlace2);
			echo $sentencia_sql."<br>";
			echo "<P>Consulta SQL erronea (SELECT 2)</P>";
		}
		else
		{
			if ($row2 = mysql_fetch_row($sql2))
			{
				echo "<form action='./vota.php' method='POST'>\n";
				echo "<table border=0 cellpadding=2 cellspacing=0 align=center>\n";
				$cuantas_Preguntas = 0;
				do
				{
					$que_pregunta = $row2[0];
					echo "<tr>\n";
						echo "<td align=left valign=middle colspan=2><b>\n";
						
						echo $que_pregunta.") ".$row2[1]."<br>\n";
						
						echo "</b></td>\n";
					echo "</tr>\n";
					$cuantas_Preguntas++;
					echo "<ul>\n";
// 3 ------------------------------------------------------------------------------------------------
					// Sentencia SQL para que muestre las Contestaciones de las Preguntas de
					// encuesta elegida.
					$sentencia_sql = "SELECT Codigo_Opcion,Titulo_Opcion FROM Contestaciones WHERE Codigo_Encuesta = ".$que_encuesta." AND Codigo_Pregunta = ".$que_pregunta;
					$link3=conecta("fjmarkez_es_db");
					$sql3 = mysql_query($sentencia_sql);
					if (!$sql3) 
					{
						desconecta($link3);
						echo $sentencia_sql."<br>";
						echo "<P>Consulta SQL erronea (SELECT 3)</P>";
					}
					else
					{
						if ($row3 = mysql_fetch_row($sql3))
						{
							do
							{
								$que_contestacion = $row3[0];
								echo "<tr>\n";
									echo "<td align=left valign=middle>\n";
									echo "<li>".$row3[1]."<br>";
									echo "</td>\n";
									echo "<td align=center valign=middle>\n";
									echo "<input type='radio' name='pregunta".$que_pregunta."' value=".$que_contestacion." class='sinborde'>";
									echo "</td>\n";
								echo "</tr>\n";
							}while ($row3 = mysql_fetch_row($sql3));
						}
						else
						{
							echo "<P>No hay ningun resultado (SELECT 3)</P>";
						}
						desconecta($link3);
					}
// 3 ------------------------------------------------------------------------------------------------
				echo "</ul>\n";
				}while ($row2 = mysql_fetch_row($sql2));
				// Asignacion en unos campos ocultos de la encuesta que ha sidio elegida y
				// de cuantas Preguntas tiene dicha encuesta, que seran necesarias para la
				// pagina "Vota.php".
				echo "<input type='hidden' value=".$cuantas_Preguntas." name='cuantas_Preguntas'>\n";
				echo "<input type='hidden' value=".$que_encuesta." name='que_encuesta'>\n";
				echo "</tr>\n";
				echo "</table>\n";
				
				echo "<table border=0 cellpadding=2 cellspacing=0 align=center>\n";
				echo "<tr>\n";
					echo "<td align=center valign=middle width=50%>\n";
					echo "<input type='reset' value='Borrar' class='boton'>\n";
					echo "</td>\n";
					echo "<td align=center valign=middle width=50%>\n";
					echo "<input type='button' value='Votar' class='boton' onclick='valida_encuesta(this.form)'>\n";
					echo "</td>\n";
				echo "</tr>\n";
				echo "</table>\n";
				echo "</form>\n";
			}
			else
			{
				echo "<P>No hay ningun resultado (SELECT 2)</P>";
				desconecta($enlace2);
			}
			
		}
// 2 ------------------------------------------------------------------------------------------------
	}
	else
	{
		desconecta($link1);
		echo "<P>No hay ningun resultado (SELECT 1)</P>";
	}
}
// 1 ------------------------------------------------------------------------------------------------
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./encuestas.php'>Encuestas</a><br>\n";	
?>
<?php
// Inclusion del pie de la pagina html.
include('./includes/pie.inc');
?>