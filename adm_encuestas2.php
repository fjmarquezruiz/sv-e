<?php 
// Inclusion de las clases para almacenar temporalmente la encuesta cuando se va a añadir.
include "./includes/clases.inc";

// Inclusion del codigo de seguridad de la administracion, si no pasa por aqui no se podra
// ver la pagina.
include('./includes/seguridad_adm.inc');

// Inclusion de la cabecera de la pagina html.
include('./includes/cabecera.inc');

// Captura de parametros de la pagina anterior, "adm_encuestas1.php" o "adm_encuestas2.php".
$acciontemp = $_POST['accion'];

// Segun la variable '$acciontemp' que se ha capturado entonces se ira a una funcion u otra
// para realizar una accion concreta.
switch($acciontemp)
{
	case 1: $accion = "añadir encuestas";
			accion1();
			break;
	case 3: $accion = "eliminar encuestas [1]";
			accion3();
			break;
	case 4: $accion = "buscar encuestas";
			accion4();
			break;
	case 5: $accion = "añadir pregunta";
			accion5();
			break;
	case 6: $accion = "añadir opciones (1)";
			accion6();
			break;
	case 7: $accion = "añadir opciones (2)";
			accion7();
			break;
	case 8: $accion = "eliminar encuestas [2]";
			accion8();
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
// Funcion que crea la variable de sesion donde se almacena temporalmente los datos,
// preguntas y respuestas de la encuesta que se va a añadir.
function accion1()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $id, $accion;
	
	echo "<h3>".$accion."</h3><br>";
		
	// Si no esta declarada la variable de sesion 'la_encuesta', se declara y de tipo de la
	// clase CEncuesta.
	if (!isset($_SESSION['la_encuesta']))
	{
		// Sentencia SQL que busca el ultimo 'codigo_encuesta' insertado en la tabla.
		// "Encuestas".
		$sentencia_sql="SELECT * FROM encuestas ORDER BY Codigo_Encuesta";
		
		// Ejecucion de la sentencia SQL.
		$link=conecta("votaciones");
		
		$sql = mysql_query($sentencia_sql);
		
		if (!$sql) 
		{
			echo "<P>Consulta SQL erronea (SELECT)</P>";
		}
		else
		{
			$ultimo_codigo=0;
			while ($row = mysql_fetch_row($sql)) 
			{
				$ultimo_codigo=$row[0];
			}
		}
		
		desconecta($link);
		
		// Creacion del objeto 'la_encuesta' de clase CEncuesta con los valores pasados desde
		// "adm_encuestas1.php" [accion1].
		$ultimo_codigo++;
	    $_SESSION['la_encuesta'] = new CEncuesta($ultimo_codigo,$_POST['Titulo_Encuesta'],$_POST['Fecha_Inicio'],$_POST['Fecha_Fin'],$id);
	    	       
	    echo "<h4>La encuesta: \"".$_SESSION['la_encuesta']->titulo_encuesta."\" ha sido creada</h4>";
	  	
	    // Sentencia SQL que inserta 'la_encuesta' en la tabla "Encuestas".
	    
    	$sentencia_sql="INSERT INTO encuestas VALUES (";
    	$sentencia_sql.="'".$ultimo_codigo."',";
    	$sentencia_sql.="'".$_POST['Titulo_Encuesta']."',";
    	$sentencia_sql.="'".$_POST['Fecha_Inicio']."',";
    	$sentencia_sql.="'".$_POST['Fecha_Fin']."',";
    	$sentencia_sql.="'".$id."')";
			
    	
    	$link=conecta("votaciones");
    	
		$sql = mysql_query($sentencia_sql);
		
		if (!$sql) 
		{
			echo "<P>Consulta SQL erronea (INSERT)</P>";
		}
		
		desconecta($link);
		
		// Si se quiere añadir preguntas a la encuesta recien creada se va a
		// "adm_encuestas2.php" [accion5].
    	echo "<form action='adm_encuestas2.php' name='Formulario' method='POST'>\n";
    	echo "<input type='hidden' name='accion' value='5'>\n";
		echo "</form>\n";
		echo "<a href='javascript:document.Formulario.submit()'>añadir preguntas</a><br>\n";
 	    	
	} 
	else
	{
		echo "<p>La encuesta ya existe</p>";
	}
	
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a><br>\n";	
}

// -----------------------------------------------------------------------------------------
// Funcion para mostrar y seleccionar los encuestas a eliminar segun el criterio pasado desde
// "adm_encuestas1.php" [accion3].
function accion3()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	$buscartemp = $_POST['buscar'];
	$campotemp = $_POST['campo'];
	
	echo "<h3>Eliminar encuestas</h3><br>";
	
	// Parte de la sentencia SQL para hacer una seleccion segun el criterio pasado.
	$condicion_sql=$campotemp." LIKE '%".$buscartemp."%'";
	
	// 'muestra' es una funcion del archivo "funciones.inc", en este caso mostrara una tabla
	// con checkboxs de la tabla "Encuestas" en un formulario que seria mandado a
	// "adm_encuestas2.php" con [accion8].
	muestra(1,3,$condicion_sql,3,8);
	
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a> | <a href='javascript:history.go(-1)'>volver a busqueda</a><br>\n";
}

// -----------------------------------------------------------------------------------------
// Funcion que muestra las encuestas segun el criterio pasado desde "adm_encuestas1.php"
// [accion4].
function accion4()
{
	// Captura de los valores pasados por la pagina "adm_encuestas2.php" [accion4].
	$buscartemp = $_POST['buscar'];
	$campotemp = $_POST['campo'];
	
	// Importacion a la funcion de las variable globales que seran usadas.
	global $accion;
	
	echo "<h3>".$accion."</h3><br>";
	
	// Parte de la sentencia SQL para hacer una seleccion segun el criterio pasado. Queda
	// por codificar la busqueda de encuestas entre dos fechas...
	$condicion_sql=$campotemp." LIKE '%".$buscartemp."%'";
	
	// 'muestra' es una funcion del archivo "funciones.inc", en este caso mostrara una tabla
	// simple de la tabla "Encuestas" segun la condicion dada.
	muestra(0,3,$condicion_sql,0,0);
	
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a> | <a href='javascript:history.go(-1)'>volver a busqueda</a><br>\n";
}

// -----------------------------------------------------------------------------------------
// Funcion que muestra el formulario para añadir preguntas a la encuesta recien creada en
// "adm_encuestas2.php" [accion1].
function accion5()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $acciontemp, $accion;
	
	echo "<h3>".$accion."</h3><br>";
	
	// Se comprueba que esta creada la variable de sesion 'la_encuesta', si es asi se
	// muestra el formulario.
	if (isset($_SESSION['la_encuesta']))
	{
		echo "<h4>Encuesta: \"".$_SESSION['la_encuesta']->titulo_encuesta."\"</h4>";
		// Formulario para añadir preguntas de la encuesta, se redirigira a
		// "adm_encuestas2.php" [accion6].
		echo "<form action='adm_encuestas2.php' name='Formulario' method='POST'>\n";

		echo "<input type='hidden' name='accion' value='6'>\n";
		echo "<table border=0 cellpadding=5 cellspacing=0>\n";
		
		echo "<tr>\n";
			echo "<th valign=middle colspan=3>\n";
			// Obtiene el valor de la variable 'contador_preguntas' del objeto 'la_encuesta'.
			$pregunta_numero=$_SESSION['la_encuesta']->contador_preguntas;
			$pregunta_numero++;
			echo "Pregunta nº ".$pregunta_numero;
			echo "</th>";
		echo "</tr>\n";	
		
		echo "<tr>\n";
			echo "<td valign=middle>\n";
			echo "Titulo Pregunta\n";
			echo "</td>";
			echo "<td valign=middle colspan=2>\n";
			echo "<input type='text' name='Titulo_Pregunta' size='25'>\n";
			echo "</td>";
		echo "</tr>\n";	
		echo "<tr>\n";
			echo "<td valign=middle>\n";
			echo "Nº Posibles Contestaciones<br>\n";
			echo "(minimo 2)\n";
			echo "</td>";
			echo "<td valign=middle colspan=2>\n";
			echo "<input type='text' name='Numero_Contestaciones' size='5'>\n";
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
			echo "<input type='button' value='Enviar' onclick='valida_".$acciontemp."_encuestas(this.form)' class='boton'>\n";
			echo "</td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		echo "</form>\n";
	}
	else
	{
		echo "<h3>La encuesta no existe</h3>";
	}
	
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a><br>\n";
}
// -----------------------------------------------------------------------------------------
// Funcion que añade al objeto-variable de sesion 'la_encuesta' la pregunta con los valores
// de "adm_encuestas2.php" [accion5] y los inserta en la tabla "Preguntas".
function accion6()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $acciontemp, $accion;
	
	echo "<h3>".$accion."</h3><br>";
	
	// Se comprueba que esta creada la variable de sesion 'la_encuesta', si es asi se
	// muestra el formulario y se realiza la insercion.
	if (isset($_SESSION['la_encuesta']))
	{
		$numero_pregunta = $_SESSION['la_encuesta']->contador_preguntas;
		$numero_pregunta++;
		
		$_SESSION['la_encuesta']->new_pregunta($numero_pregunta,$_POST['Titulo_Pregunta']);
				
		$numero_pregunta = $_SESSION['la_encuesta']->contador_preguntas;
		
		// Sentencia SQL para la insercion de la pregunta en la tabla "Preguntas".
    	$sentencia_sql="INSERT INTO preguntas VALUES (";
    	$sentencia_sql.=$_SESSION['la_encuesta']->codigo_encuesta.",";
    	$sentencia_sql.=$numero_pregunta.",";
    	$sentencia_sql.="'".$_POST['Titulo_Pregunta']."')";
    	
    	$link=conecta("votaciones");
    	
		$sql = mysql_query($sentencia_sql);
		
		desconecta($link);
		
		if (!$sql) 
		{
			echo "<P>Consulta SQL erronea (INSERT)</P>";
		}
		else
		{
			// La pregunta ha sido insertado con exito, ahora se muestra el formulario de
			// las opciones de la pregunta.
			
			echo "<h4>Encuesta: \"".$_SESSION['la_encuesta']->titulo_encuesta."\"</h4>\n";
			echo "<b> Pregunta nº ".$numero_pregunta.": \"".$_SESSION['la_encuesta']->preguntas[$numero_pregunta]->titulo_pregunta."\"</b><p>\n";
			
			echo "<b> Contestaciones: </b>\n";
			
			// Formulario para añadir opciones a las preguntas de la encuesta, se dirigira
			// a "adm_encuestas2.php" [accion7].
			echo "<form action='adm_encuestas2.php' name='Formulario' method='POST'>\n";

			echo "<input type='hidden' name='accion' value='7'>\n";
			echo "<input type='hidden' name='Numero_Contestaciones' value='".$_POST['Numero_Contestaciones']."'>\n";
			echo "<table border=0 cellpadding=5 cellspacing=0>\n";
			for ($i=1; $i<=$_POST['Numero_Contestaciones']; $i++)
			{
				echo "<tr>\n";
				echo "<td valign=middle>\n";
				echo $i."\n";
				echo "</td>";
				echo "<td valign=middle colspan=2>\n";
				echo "<input type='text' name='Opcion_".$i."' size='25'>\n";
				echo "</td>";
				echo "</tr>\n";
			}
			echo "</table>\n";
			
			echo "<table border=0 cellpadding=5 cellspacing=0>\n";
			echo "<tr>\n";
				echo "<td>\n";
				echo "</td>\n";
				echo "<td align='center' valign='middle'>\n";
				echo "<input type='reset' value='Borrar' class='boton'>\n";
				echo "</td>\n";
				echo "<td align='center' valign='middle'>\n";
				echo "<input type='button' value='Enviar' onclick='valida_".$acciontemp."_encuestas(this.form)' class='boton'>\n";
				echo "</td>\n";
			echo "</tr>\n";
			
			echo "</table>\n";
			echo "</form>\n";
		}
	}
	else
	{
		echo "<h3>La encuesta no existe</h3>";
	}
	
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a><br>\n";
}

// -----------------------------------------------------------------------------------------
// Funcion que añade las contestacions de la pregunta a la tabla "Contestaciones".
function accion7()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $acciontemp, $accion;
	
	echo "<h3>".$accion."</h3><br>";
	
	// Se comprueba que esta creada la variable de sesion 'la_encuesta', si es asi se
	// muestra el formulario.
	if (isset($_SESSION['la_encuesta']))
	{
		// Flag que sirve para mostrar un mensaje en el caso de que se hayan introducido
		// correctamente todas las contestaciones.
		$flag = true;
		
		$numero_pregunta = $_SESSION['la_encuesta']->contador_preguntas;
		
		echo "<h4>Encuesta: \"".$_SESSION['la_encuesta']->titulo_encuesta."\"</h4>\n";
		echo "<b> Pregunta nº ".$numero_pregunta.": \"".$_SESSION['la_encuesta']->preguntas[$numero_pregunta]->titulo_pregunta."\"</b><p>\n";
				
		for ($i=1; $i<=$_POST['Numero_Contestaciones']; $i++)
		{
			$la_contestacion = $_POST['Opcion_'.$i];
			
			// Sentencia SQL para la insercion de las opciones (contestaciones) de las
			// preguntas en la tabla "Contestaciones".
	    	$sentencia_sql="INSERT INTO contestaciones VALUES (";
	    	$sentencia_sql.=$_SESSION['la_encuesta']->codigo_encuesta.",";
	    	$sentencia_sql.=$numero_pregunta.",";
	    	$sentencia_sql.=$i.",";
	    	$sentencia_sql.="\"".$la_contestacion."\",";
	    	$sentencia_sql.="0)";
	    	
	    	$link=conecta("votaciones");
	    	
			$sql = mysql_query($sentencia_sql);
			
			desconecta($link);
			
			if (!$sql)
			{
				$flag = false;
				echo "la contestacion $i NO ha sido añadida<br>\n";
			}
			else
			{
				$_SESSION['la_encuesta']->new_opcion($numero_pregunta,$i,$la_contestacion);
			}
		}
		
		if ($flag)
		{
			// Estas sentencias comentadas sirven en la depuracion del codigo para ver si se
			// estan introduciendo y pasando bien los datos. Son llamadas a funciones del
			// objeto 'la_encuesta' que muestran por pantalla todos los datos contenidos en
			// el y en los objetos que de el dependan: de clase CPregunta y de clase COpcion.
			
			//$_SESSION['la_encuesta']->view_datos();
			//$_SESSION['la_encuesta']->view_preguntas();

			echo "la pregunta y sus posibles contestaciones han sido añadidas<br>\n";
		}		    	
		
		// Si se quiere añadir preguntas a la encuesta se va a "adm_encuestas2.php"
		// [accion5].
		echo "<form action='adm_encuestas2.php' name='Formulario' method='POST'>\n";
	    echo "<input type='hidden' name='accion' value='5'>\n";
		echo "</form>\n";
		echo "<a href='javascript:document.Formulario.submit()'>añadir + preguntas</a><br>\n";
			
	}
	else
	{
		echo "<h3>La encuesta no existe</h3>";
	}
	
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a><br>\n";
}

// -----------------------------------------------------------------------------------------
// Funcion que realiza la eliminacion de las encuestas seleccionadas en "adm_encuestas2.php"
// [accion3] de su tabla y de todas las tablas donde se encuentre los codigos de las
// encuestas a eliminar.
function accion8()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $acciontemp, $accion, $HTTP_POST_VARS;
	
	echo "<h3>".$accion."</h3><br>";
	
	// Creacion de la parte de la sentencia SQL con las usuarios seleccionados para
	// eliminar.
	// Se utiliza en esta parte la variable del PHP '$HTTP_POST_VARS' que es un array donde
	// se encuentran todas las variables que se pasan, y tambien se usa la funcion 'strstr'
	// que se usa para saber si una cadena es subcadena de otra.
	$encuestas_a_eliminar="";
	while (list($key, $value) = each(${"HTTP_POST_VARS"}))
	{      
		if (strstr($key,"usuario_")==TRUE)
		{
			$encuestas_a_eliminar.="(Codigo_Encuesta = ".$value.") OR ";
		}
	}
	
	if ($encuestas_a_eliminar != "")
	{
		
		// Apaño para quitar " OR " del final de la cadena 'usuarios_a_modificar'.
		$encuestas_a_eliminar=substr($encuestas_a_eliminar,0,strlen($encuestas_a_eliminar)-4);
		
		// Sentencia SQL para eliminacion de la tabla "Encuestas".
		$sentencia_sql="DELETE FROM encuestas WHERE ".$encuestas_a_eliminar;
		
		// Ejecucion de la sentencia SQL.
		$link=conecta("votaciones");
		
		$sql = mysql_query($sentencia_sql);
		
		desconecta($link);
		
		if (!$sql) 
		{
			echo "<P>Consulta SQL erronea (DELETE encuestas)</P>";
		}
		else
		{
			echo "<P>Se ha producido la eliminacion en la tabla 'encuestas'</P>";
			
			// Sentencia SQL para la eliminacion de la tabla "Preguntas".
			$sentencia_sql="DELETE FROM preguntas WHERE ".$encuestas_a_eliminar;
		
			// Ejecucion de la sentencia SQL.
			$link=conecta("votaciones");
			
			$sql = mysql_query($sentencia_sql);
			
			desconecta($link);
			
			if (!$sql) 
			{
				echo "<P>Consulta SQL erronea (DELETE preguntas)</P>";
			}
			else
			{
				echo "<P>Se ha producido la eliminacion en la tabla 'preguntas'</P>";
				
				// Sentencia SQL para la eliminacion en la tabla "Contestaciones".
				$sentencia_sql="DELETE FROM contestaciones WHERE ".$encuestas_a_eliminar;
		
				// Ejecucion de la sentencia SQL.
				$link=conecta("votaciones");
				
				$sql = mysql_query($sentencia_sql);
				
				desconecta($link);
				
				if (!$sql) 
				{
					echo "<P>Consulta SQL erronea (DELETE contestaciones)</P>";
				}
				else
				{
					echo "<P>Se ha producido la eliminacion en la tabla 'Contestaciones'</P>";
					muestra(0,3,"",0,0);
				}
			}
		}
	}
	else
	{
		echo "No se ha seleccionado nada<br>\n";
	}
	
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a><br>\n";	
}
?>

<?php 
// Inclusion del pie de la pagina html.
include('./includes/pie.inc');
?>