<?php 
// Inclusion de las clases para almacenar temporalmente la encuesta cuando se va a añadir.
include "./includes/clases.inc";

// Inclusion del codigo de seguridad de la administracion, si no pasa por aqui no se podra
// ver la pagina.
include('./includes/seguridad_adm.inc');

// Inclusion de la cabecera de la pagina html.
include('./includes/cabecera.inc');

// Captura de parametros de la pagina anterior, "administracion.php".
$acciontemp = $_POST['accion'];

// Segun la variable '$acciontemp' que se ha capturado entonces se ira a una funcion u otra
// para realizar una accion concreta.
switch($acciontemp)
{
	case 1: $accion = "añadir Encuestas";
			accion1();
			break;
	case 2: $accion = "modificar Encuestas";
			accion2();
			break;
	case 3: $accion = "eliminar Encuestas";
			accion3();
			break;
	case 4: $accion = "buscar Encuestas";
			accion4();
			break;
	case 5: $accion = "ver resultados";
			accion5();
			break;
	default: error();
			 break;
}
// -----------------------------------------------------------------------------------------
// Si no esta contemplado ese valor de la variable '$acciontemp' muestra este mensaje de
// error.
function error()
{
	echo "<h3>Aun no se ha implementado esta opcion,<br>proximamente estara disponible.<br>GRACIAS.</h3><br>";
	
	echo "<a href='./administracion.php'>volver a administracion</a><br>\n";
}
// -----------------------------------------------------------------------------------------
// Funcion que muestra el formulario para añadir los primeros datos de la encuesta, aquellos
// que iran a la tabla 'Encuestas'.
function accion1()
{
	// Lo primero que se hace es ver si la variable de sesion 'la_encuesta' se encuentra
	// ya definida, es decir, en memoria, si es asi se destruye.
	if (isset($_SESSION['la_encuesta']))
	{
		echo "<p><b>Ya existe una encuesta en memoria... destruyendola</b></p>";
		unset($_SESSION['la_encuesta']);
	}
	
	// Importacion a la funcion de las variable globales que seran usadas.
	global $id, $accion, $acciontemp;
	
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	// Obtencion de la fecha actual en las variables 'anyo_actual', 'mes_actual' y
	// 'dia_actual'.
	list($anyo_actual, $mes_actual, $dia_actual) = split('[/.-]', date("Y-n-j"));
					
	echo "<h3>".$accion."</h3><br>";

	echo "<!-- formulario para añadir una base de datos -->\n";	

	echo "<form action='adm_encuestas2.php' name='Formulario' method='POST'>\n";
	
	// Campo oculto con la siguiente accion a realizar, [accion1] en la pagina
	// "adm_encuestas2.php".
	echo "<input type='hidden' name='accion' value='".$acciontemp."'>\n";
	echo "<table border=0 cellpadding=5 cellspacing=0>\n";
	
	echo "<tr>\n";
		echo "<td valign=middle>\n";
		echo "Titulo\n";
		echo "</td>";
		echo "<td valign=middle colspan=2>\n";
		echo "<input type='text' name='Titulo_Encuesta' size='25'>\n";
		echo "</td>";
	echo "</tr>\n";	
	echo "<tr>\n";
		echo "<td valign=middle>\n";
		echo "Fecha Inicio\n";
		echo "</td>";
		echo "<td valign=middle colspan=2>\n";
		echo "<select name='Dia_Inicio' size=1>\n";
		for ($i=1; $i<=31; $i++)
		{
			// Si la variable 'i' es igual al dia actual, se selecciona.
			if ($i == $dia_actual)
			{
				echo "<option value='".$i."' selected>".$i."</option>";
			}
			else
			{
				echo "<option value='".$i."'>".$i."</option>";
			}
		}
		echo "</select>\n";
		echo "<select name='Mes_Inicio' size=1 onchange='asignaDias(\"_Inicio\")'>\n";
		for ($i=0; $i<count($meses); $i++)
		{
			// Si la variable 'i' es igual al mes actual menos 1, se selecciona.
			if ($i == ($mes_actual-1))
			{
				echo "<option value='".($i+1)."' selected>".$meses[$i]."</option>";
			}
			else
			{
				echo "<option value='".($i+1)."'>".$meses[$i]."</option>";
			}
		}
		echo "</select>\n";
		echo "<select name='Anyo_Inicio' size=1 onchange='asignaDias(\"_Inicio\")'>\n";
		for ($i=2000; $i<=2050; $i++)
		{
			// Si la variable 'i' es igual al año actual, se selecciona.
			if ($i == $anyo_actual)
			{
				echo "<option value='".$i."' selected>".$i."</option>";
			}
			else
			{
				echo "<option value='".$i."'>".$i."</option>";
			}
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
		for ($i=1; $i<=31; $i++)
		{
			// Si la variable 'i' es igual al dia actual, se selecciona.
			if ($i == $dia_actual)
			{
				echo "<option value='".$i."' selected>".$i."</option>";
			}
			else
			{
				echo "<option value='".$i."'>".$i."</option>";
			}
		}
		echo "</select>\n";
		echo "<select name='Mes_Fin' size=1 onchange='asignaDias(\"_Fin\")'>\n";
		for ($i=0; $i<count($meses); $i++)
		{
			// Si la variable 'i' es igual al mes actual menos uno, se selecciona.
			if ($i == ($mes_actual-1))
			{
				echo "<option value='".($i+1)."' selected>".$meses[$i]."</option>";
			}
			else
			{
				echo "<option value='".($i+1)."'>".$meses[$i]."</option>";
			}
		}
		echo "</select>\n";
		echo "<select name='Anyo_Fin' size=1 onchange='asignaDias(\"_Fin\")'>\n";
		for ($i=2000; $i<=2050; $i++)
		{
			// Si la variable 'i' es igual al año actual, se selecciona.
			if ($i == $anyo_actual)
			{
				echo "<option value='".$i."' selected>".$i."</option>";
			}
			else
			{
				echo "<option value='".$i."'>".$i."</option>";
			}
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
		echo "<input type='button' value='Enviar' onclick='valida_".$acciontemp."_Encuestas(this.form)' class='boton'>\n";
		echo "</td>\n";
		echo "</tr>\n";
	echo "</table>\n";
	echo "</form>\n";
}

// -----------------------------------------------------------------------------------------
// Funcion que muestra el formulario de opciones para modificar Encuestas. En la actualidad
// solo se encuentra codificada la primera opcion. Estas opciones son enviadas a la pagina
// "adm_encuestas3.php"
function accion2()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $accion;
	
	echo "<h3>".$accion."</h3><br>";
	?>
	<table border=0 width=100% cellpadding=5 cellspacing=0 align=center>
		<tr>
			<td>
			</td>
			<td width=27% class="conborde">
			<!-- OPCIONES DE USUARIOS -->
			<form action="./adm_encuestas3.php" method="POST">
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
						<option value="1">cambiar datos encuesta</option>
						<option value="2">añadir pregunta</option>
						<option value="3">modificar pregunta</option>
						<option value="4">eliminar preguna</option>
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
			<!-- FIN OPCIONES DE USUARIOS -->
			</td>
			<td>
			</td>
		</tr>
	</table>
<?php 
}

// -----------------------------------------------------------------------------------------
// Funcion que muestra el buscador para eliminar una o varias Encuestas de su tabla.
function accion3()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $accion;
	
	echo "<h3>".$accion."</h3><br>";
	
	// A la funcion 'buscador_Encuestas' se le pasa la tabla donde se va a buscar y la
	// siguente accion a realizar en la pagina "adm_encuestas2.php", en este caso [accion3].
	buscador_Encuestas(0,3);
}

// -----------------------------------------------------------------------------------------
// Funcion que muestra el buscador para buscar una o varias Encuestas de su tabla.
function accion4()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $accion;
	
	echo "<h3>".$accion."</h3><br>";
	
	// A la funcion 'buscador_Encuestas' se le pasa la tabla donde se va a buscar y la
	// siguente accion a realizar en la pagina "adm_encuestas2.php", en este caso [accion4].
	buscador_Encuestas(0,4);
	
}

// -----------------------------------------------------------------------------------------
// Funcion que muestra el buscador para mostrar los resultados de una encuesta, para pasarla
// a "adm_encuestas3.php" [accion7].
function accion5()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $accion;
	
	echo "<h3>".$accion."</h3><br>";

	$fecha_actual = date("Ymd");
	
	// Sentencia SQL que muestra todas la Encuestas disponibles y que han sido votadas,
	// es decir, aparecen en la tabla "Vota".
	$sentencia_sql = "SELECT DISTINCT E.Codigo_Encuesta, E.Titulo_Encuesta FROM Encuestas AS E, Vota as V WHERE (E.Fecha_Inicio <= ".$fecha_actual.") AND (E.Codigo_Encuesta = V.Codigo_Encuesta) ORDER BY E.Titulo_Encuesta";
	$link=conecta("fjmarkez_es_db");
	$sql = mysql_query($sentencia_sql);
	if (!$sql) 
	{
		echo "<P>Consulta SQL erronea (SELECT)</P>";
	}
	else
	{
		if ($row = mysql_fetch_row($sql))
		{
			echo "<form action='./adm_encuestas3.php' method='POST'>\n";
			echo "<input type='hidden' name='accion' value='7'>\n";
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
					echo "<option value='".$row[0]."'>".$row[1]."</option>\n";
				}while ($row = mysql_fetch_row($sql));
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
				echo "<td align=center valign=middle>\n";
				echo "<input type='submit' value='Ver Resultados' class='boton'>\n";
				echo "</td>\n";
			echo "</tr>\n";
			echo "</table>\n";
			echo "</form>\n";
		}
		else
		{
			echo "No ha comenzado ningunga encuesta<br>";
		}
	}
	desconecta($link);
}
?>

<br>
<a href='./index.php'>salir</a> | <a href="./administracion.php">administracion</a>
<?php 
// Inclusion del pie de la pagina html.
include('./includes/pie.inc');
?>