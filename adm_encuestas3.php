<?php 
// Inclusion del codigo de seguridad de la administracion, si no pasa por aqui no se podra
// ver la pagina.
include('./includes/seguridad_adm.inc');

// Inclusion de la cabecera de la pagina html.
include('./includes/cabecera.inc');

// Captura de parametros de la pagina anterior, "adm_encuestas1.php" o "adm_encuestas3.php".
$acciontemp = $_POST['accion'];

// Segun la variable '$acciontemp' que se ha capturado entonces se ira a una funcion u otra
// para realizar una accion concreta.
switch($acciontemp)
{
	case 1: $accion = "cambiar los datos de la encuesta [1]";
			accion1();
			break;
	case 5: $accion = "cambiar los datos de la encuesta [2]";
			accion5();
			break;
	case 6: $accion = "cambiar los datos de la encuesta [3]";
			accion6();
			break;
	case 7: $accion = "resultados de la encuesta";
			accion7();
			break;
	default: error();
			 break;
}
// -----------------------------------------------------------------------------------------
// Si no esta contemplado ese valor de la variable '$acciontemp' muestra este mensaje de
// error.
function error()
{
	echo "<h3>aun no se ha implementado esta opcion,<br>proximamente estara disponible.<br>GRACIAS.</h3><br>";
	
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a> | <a href='javascript:history.go(-1)'>volver a modificar</a><br>\n";	
}

// -----------------------------------------------------------------------------------------
// Funcion que muestra todas aquellas Encuestas que son susceptibles de sufrir cambios, las
// que aun no han comenzado. datos de la encuesta (1).
function accion1()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $accion;
	
	echo "<h3>".$accion."</h3><br>";
	
	echo "Elige una encuesta, solo aparecen aquellas Encuestas que no han comenzado a fecha de hoy.";
	
	// Array que contiene los nombre de los campos en la tabla "Encuestas" y como se
	// mostraran.
	$campos = array("titulo" => array("Codigo","Titulo","Fecha Inicio","Fecha Fin","Adminstrador"),
					"nombre" => array("Codigo_Encuesta","Titulo_Encuesta","Fecha_Inicio","Fecha_Fin","Codigo_Administrador")
					);
	
	// Esta pagina con este formulario se envia a si misma los datos, para ello usa la
	// variable de servidor 'PHP_SELF' que continene el nombre de la pagina que se esta
	// visitando actualmente, "adm_encuestas3.php" con [accion5].
	echo "<!-- formulario para buscador una base de datos -->\n";
	echo "<form action='".$_SERVER['PHP_SELF']."' method='POST'>\n";
	
	echo "<input type='hidden' name='accion' value='5'>\n";
	
	echo "<table border=0 cellpadding=5 cellspacing=0>\n";
	echo "<tr>\n";
		echo "<td valing=middle>\n";
		echo "Encuesta:\n";
		echo "</td>\n";
		echo "<td align=center valing=middle colspan=2>\n";
		
		// La funcion 'date' da la fecha y hora actual segun la cadena que formato que
		// se le pase, en este caso devuelve la fecha en formato 19990101
		$fecha_actual=date("Ymd");
		
		// Sentencia SQL que muestra aquellas Encuestas que aun no han comenzado.
		$sentencia_sql="SELECT Codigo_Encuesta, Titulo_Encuesta, Fecha_Inicio FROM Encuestas WHERE (Fecha_Inicio > ".$fecha_actual.") ORDER BY Codigo_Encuesta";
		
		$link=conecta("fjmarkez_es_db");
		
		$sql = mysql_query($sentencia_sql);
		
		if (!$sql) 
		{
			desconecta($link);
			echo "<P>Consulta SQL erronea (SELECT)</P>";
		}
		else
		{
						
			echo "<select name=\"que_encuesta\" size=1>";
			while ($row = mysql_fetch_row($sql)) 
			{
				echo "<option value='".$row[0]."'>".$row[1]."</option>\n";
			}
			echo "</select>\n";
			desconecta($link);
		}
				
				
		echo "</td>\n";
		echo "<td>\n";
		echo "</td>\n";
		echo "<td align='center' valign='middle'>\n";
		echo "<input type='reset' value='Borrar' class='boton'>\n";
		echo "</td>\n";
		echo "<td align='center' valign='middle'>\n";
		echo "<input type='submit' value='Modificar' class='boton'>\n";
		echo "</td>\n";
	echo "</tr>\n";
	echo "</table>\n";
	
	echo "</form>\n";
	echo "<!-- FIN formulario para buscar una base de datos -->\n";
	
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a> | <a href='javascript:history.go(-1)'>modificacion de Encuestas</a><br>\n";	
}

// -----------------------------------------------------------------------------------------
// Esta funcion recibe la encuesta seleccionada para modificar sus datos desde la pagina
// "adm_encuestas3.php" [accion1].
function accion5()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $accion;

	echo "<h3>".$accion."</h3><br>";
	
	// Captura de las variables pasadas desde la pagina "adm_encuestas3.php".
	$que_encuesta = $_POST['que_encuesta'];
	$que_accion = $_POST['accion'];
		
	// Sentencia SQL que muestra los datos de la encuesta seleccionada.
	$sentencia_sql="SELECT * FROM Encuestas WHERE (Codigo_Encuesta = ".$que_encuesta.")";
	
	$link=conecta("fjmarkez_es_db");
	
	$sql = mysql_query($sentencia_sql);
	
	if (!$sql) 
	{
		desconecta($link);
		echo "<P>Consulta SQL erronea (SELECT)</P>";
	}
	else
	{
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		
		while ($row = mysql_fetch_row($sql)) 
		{
			echo "<form action='adm_encuestas3.php' name='Formulario' method='POST'>\n";
			echo "<input type='hidden' name='accion' value='6'>\n";
			echo "<input type='hidden' name='Codigo_Encuesta' value='".$que_encuesta."'>\n";
			echo "<table border=0 cellpadding=5 cellspacing=0>\n";
			echo "<tr>\n";
				echo "<td valign=middle>\n";
				echo "Titulo\n";
				echo "</td>";
				echo "<td valign=middle colspan=2>\n";
				echo "<input type='text' name='Titulo_Encuesta' size='25' value='".$row[1]."'>\n";
				echo "</td>";
			echo "</tr>\n";	
			echo "<tr>\n";
				echo "<td valign=middle>\n";
				echo "Fecha Inicio\n";
				echo "</td>";
				echo "<td valign=middle colspan=2>\n";
				echo "<select name='Dia_Inicio' size=1>\n";
				
				list($anyo, $mes, $dia) = split('[/.-]', $row[2]);
				
				for ($i=1; $i<=31; $i++)
				{
					if ($i == $dia)
					{
						echo "<option value='".$i."' selected>";
					}
					else
					{
						echo "<option value='".$i."'>";
					}
					echo $i."</option>";
				}
				echo "</select>\n";
				echo "<select name='Mes_Inicio' size=1 onchange='asignaDias(\"_Inicio\")'>\n";
				for ($i=1; $i<=count($meses); $i++)
				{
					
					if ($i == $mes)
					{
						echo "<option value='".$i."' selected>";
					}
					else
					{
						echo "<option value='".$i."'>";
					}
					echo $meses[$i-1]."</option>";
				}
				echo "</select>\n";
				echo "<select name='Anyo_Inicio' size=1 onchange='asignaDias(\"_Inicio\")'>\n";
				for ($i=2000; $i<=2050; $i++)
				{
					if ($i == $anyo)
					{
						echo "<option value='".$i."' selected>";
					}
					else
					{
						echo "<option value='".$i."'>";
					}
					echo $i."</option>";
				}
				echo "</select>\n";
				echo "<input type='hidden' name='Fecha_Inicio' value='0'>\n";
				echo "</td>";
			echo "</tr>\n";	
			echo "<tr>\n";
				echo "<td valign=middle>\n";
				echo "Fecha Fin\n";
				echo "</td>";
				echo "<td valign=middle colspan=2>\n";
				echo "<select name='Dia_Fin' size=1>\n";
				
				list($anyo, $mes, $dia) = split('[/.-]', $row[3]);
				
				for ($i=1; $i<=31; $i++)
				{
					if ($i == $dia)
					{
						echo "<option value='".$i."' selected>";
					}
					else
					{
						echo "<option value='".$i."'>";
					}
					echo $i."</option>";
				}
				echo "</select>\n";
				echo "<select name='Mes_Fin' size=1 onchange='asignaDias(\"_Fin\")'>\n";
				for ($i=1; $i<=count($meses); $i++)
				{
					
					if ($i == $mes)
					{
						echo "<option value='".$i."' selected>";
					}
					else
					{
						echo "<option value='".$i."'>";
					}
					echo $meses[$i-1]."</option>";
				}
				echo "</select>\n";
				echo "<select name='Anyo_Fin' size=1 onchange='asignaDias(\"_Fin\")'>\n";
				for ($i=2000; $i<=2050; $i++)
				{
					if ($i == $anyo)
					{
						echo "<option value='".$i."' selected>";
					}
					else
					{
						echo "<option value='".$i."'>";
					}
					echo $i."</option>";
				}
				echo "</select>\n";
				echo "<input type='hidden' name='Fecha_Fin' value='0'>\n";
				echo "</td>";
			echo "</tr>\n";
			echo "</table>\n";
			
			echo "<table border=0 cellpadding=5 cellspacing=0>\n";
			echo "<tr>\n";
				echo "<td>\n";
				echo "</td>\n";
				echo "<td align='center' valign='middle'>\n";
				echo "<input type='reset' value='Borrar' class='boton'>\n";
				echo "</td>\n";
				echo "<td align='center' valign='middle'>\n";
				echo "<input type='button' value='Enviar' onclick='valida_1_Encuestas(this.form)' class='boton'>\n";
				echo "</td>\n";
				echo "</tr>\n";
			echo "</table>\n";
			echo "</form>\n";
		}
	}
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a> | <a href='javascript:history.go(-1)'>lista de Encuestas a modificar</a><br>\n";	
}

// -----------------------------------------------------------------------------------------
// Funcion que efectua la modificacion de los datos de la encuesta elegida en
// "adm_encuestas3.php" [accion1] con los datos que se le han pasado desde [accion5].
function accion6()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $accion;
	
	echo "<h3>".$accion."</h3><br>";
	
	// Sentencia SQL para realizar la modificacion (UPDATE) de la tabla seleccionada con
	// los datos enviados desdes "adm_encuestas3.php".
	$sentencia_sql="UPDATE Encuestas SET ";
	$sentencia_sql.="Titulo_Encuesta = '".$_POST['Titulo_Encuesta']."', ";
	$sentencia_sql.="Fecha_Inicio = '".$_POST['Fecha_Inicio']."', ";
	$sentencia_sql.="Fecha_Fin = '".$_POST['Fecha_Fin']."', ";
	$sentencia_sql.="Codigo_Administrador = ".$_SESSION['iduser']." ";
	$sentencia_sql.="WHERE Codigo_Encuesta = ".$_POST['Codigo_Encuesta'];
			
	// Ejecucion de la sentencia SQL.
	$link=conecta("fjmarkez_es_db");
	$sql = mysql_query($sentencia_sql);
	desconecta($link);
	
	if (!$sql) 
	{
		echo "<P>Consulta SQL erronea (UPDATE)</P>";
	}
	else
	{
		echo "<P>La encuesta \"".$_POST['Titulo_Encuesta']."\" se ha actualizado</P>";
	}

	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a><br>\n";	
}
// -----------------------------------------------------------------------------------------
// Funcion que muestra los resultados de la encuesta seleccionada en "adm_encuestas1.php"
// [accion5].
function accion7()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $accion;
	
	echo "<h3>".$accion."</h3><br>";
	
	// Captura de los valores pasados por la pagina "adm_encuestas1.php" [accion5].
	$que_encuesta=$_POST['que_encuesta'];
	
	// 1 ------------------------------------------------------------------------------------------------
	// Sentencia SQL que muestra los datos de la tabla "Encuestas" de la encuesta
	// seleccionada.
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
				echo "<h4>encuesta \"".$row1[0]."\"</h4>\n";
			}while ($row1 = mysql_fetch_row($sql1));
			desconecta($link1);
	// 2 ------------------------------------------------------------------------------------------------
			// Sentencia SQL que muestra las Preguntas de la tabla "Preguntas" de la encuesta
			// seleccionada.
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
					echo "<form action='./Vota.php' method='POST'>\n";
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
						$sentencia_sql = "SELECT SUM(Cantidad_Votos) FROM Contestaciones WHERE Codigo_Encuesta = ".$que_encuesta." AND Codigo_Pregunta = ".$que_pregunta;
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
								$total_votos=$row3[0];
								
	// 4 ------------------------------------------------------------------------------------------------
								// Sentencia que hace que se muestre las Contestaciones de las
								// Preguntas de la encuesta y para hallar la estadistica de ellas.
								$sentencia_sql = "SELECT Codigo_Opcion,Titulo_Opcion,Cantidad_Votos FROM Contestaciones WHERE Codigo_Encuesta = ".$que_encuesta." AND Codigo_Pregunta = ".$que_pregunta;
								$link4=conecta("fjmarkez_es_db");
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
	echo "<form action='adm_encuestas1.php' name='Formulario' method='POST'>\n";
	echo "<input type='hidden' name='accion' value='5'>\n";
	echo "</form>\n";
		
echo "<br>\n";
echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a> | <a href='javascript:document.Formulario.submit()'>ver resultados</a><br>\n";
}

// -----------------------------------------------------------------------------------------
?>

<?php 
// Inclusion del pie de la pagina html.
include('./includes/pie.inc');
?>