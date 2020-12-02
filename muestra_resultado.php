<?php 
// Inclusion del codigo de seguridad de los votantes, si no pasa por aqui no se podra
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

// Captura de las variables necesarias que vienen de la pagina "encuestas.php".
$que_encuesta=$_POST['que_encuesta'];

// 1 ------------------------------------------------------------------------------------------------
// Creacion y ejecucion de la sentencia SQL que va a mostrar la encuesta que ha sido elegida
$sentencia_sql = "SELECT Titulo_Encuesta FROM encuestas WHERE Codigo_Encuesta = ".$que_encuesta;
$link1=conecta("votaciones");
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
		// Creacion de la sentencia SQL, y su ejecucion, que muestra las preguntas asociadas
		// a la encuesta elegida.
		$sentencia_sql = "SELECT Codigo_Pregunta,Titulo_Pregunta FROM preguntas WHERE Codigo_Encuesta = ".$que_encuesta;
		$enlace2=conecta("votaciones");
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
				do
				{
					$que_pregunta = $row2[0];
					echo "<tr>\n";
						echo "<td align=left valign=middle colspan=2><b>\n";
						echo $que_pregunta.") ".$row2[1]."<br>\n";
						echo "</b></td>\n";
					echo "</tr>\n";
					echo "<ul>\n";
// 3 ------------------------------------------------------------------------------------------------
					// Sentencia SQL que calcula la suma total de votos realizados, esta 
					// sentencia es necesaria para realizar la estadistica de la encuesta.
					$sentencia_sql = "SELECT SUM(Cantidad_Votos) FROM contestaciones WHERE Codigo_Encuesta = ".$que_encuesta." AND Codigo_Pregunta = ".$que_pregunta;
					$link3=conecta("votaciones");
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
							$total_votos=$row3[0];
							
// 4 ------------------------------------------------------------------------------------------------
							// Sentencia que hace que se muestre las contestaciones de las
							// preguntas de la encuesta y para hallar la estadistica de ellas.
							$sentencia_sql = "SELECT Codigo_Opcion,Titulo_Opcion,Cantidad_Votos FROM contestaciones WHERE Codigo_Encuesta = ".$que_encuesta." AND Codigo_Pregunta = ".$que_pregunta;
							$link4=conecta("votaciones");
							$sql4 = mysql_query($sentencia_sql);
							if (!$sql4) 
							{
								desconecta($link4);
								echo $sentencia_sql."<br>";
								echo "<P>Consulta SQL erronea (SELECT 4)</P>";
							}
							else
							{
								if ($row4 = mysql_fetch_row($sql4))
								{
									do
									{
										echo "<tr>\n";
											echo "<td align=left valign=middle>\n";
											echo "<li>".$row4[1]."<br>";
											echo "</td>\n";
											echo "<td align=right valign=middle>\n";
											
											// Calculo del tanto por ciento de votos
											// obtenidos para la contestacion actual.
											$cuantos_votos=$row4[2];
											echo round(($cuantos_votos * 100)/$total_votos)." %";
										
											echo "</td>\n";
										echo "</tr>\n";
									}while ($row4 = mysql_fetch_row($sql4));
								}
								else
								{
									echo "<P>No hay ningun resultado (SELECT 4)</P>";
								}
								desconecta($link4);
							}
// 4 ------------------------------------------------------------------------------------------------
						}
						else
						{
							echo "<P>No hay ningun resultado (SELECT 3)</P>";
						}
						//desconecta($link3);
					}
// 3 ------------------------------------------------------------------------------------------------										
				echo "</ul>\n";
				}while ($row2 = mysql_fetch_row($sql2));
				echo "</tr>\n";
				
				echo "<tr>\n";
					echo "<td align=left valign=middle>\n";
					echo "<b>Total Votos:</b><br>";
					echo "</td>\n";
					echo "<td align=right valign=middle>\n";
					echo "<b>".$total_votos."</b>";
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
echo "<a href='./index.php'>salir</a> | <a href='./encuestas.php'>encuestas</a><br>\n";	
?>

<?php 
// Inclusion del pie de la pagina html.
include('./includes/pie.inc');
?>