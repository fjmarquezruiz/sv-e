<?php 
// Inclusion del codigo de seguridad de la administracion, si no pasa por aqui no se podra
// ver la pagina.
include('./includes/seguridad_adm.inc');

// Inclusion de la cabecera de la pagina html.
include('./includes/cabecera.inc');

// Captura de parametros de la pagina anterior, "adm_usuarios1.php".
// $id = $_POST['id'];
$tablatemp = $_POST['tabla'];
$acciontemp = $_POST['accion'];

// Asignacion en la variable '$tabla' del nombre de la tabla sobre la que se actuara en el
// formulario.
//
// Creacion de un array de dos filas por varias columnas; las filas se encuentran indexadas
// por unas claves asociativas ('titulo' y 'nombre') que indican a un array cada una, y asi
// se obtiene un array bidimensional.
//
// Este array bidimensional ('$campos') contiene el titulo del campo que aparecera en el
// formulario y el nombre que tiene en la base de datos, en este caso se ha puesto en el
// orden en que se encuentran en la base de datos para facilitar la codificacion futura.
switch ($tablatemp)
{
	case 1: $tabla = "Votantes";
			$campos = array("titulo" => array("Codigo","Login","Password","Nombre","Apellidos"),
							"nombre" => array("Codigo_Votante","Login_Votante","Password_Votante","Nombre","Apellidos"),
							"tipo" => array("hidden","text","password","password","text","text")
							);
			break;
	case 2: $tabla = "Administradores";
			$campos = array("titulo" => array("Codigo","Login","Password"),
							"nombre" => array("Codigo_Administrador","Login_Administrador","Password_Administrador"),
							"tipo" => array("hidden","text","password","password")
							);
			break;
}

// Segun la variable '$acciontemp' que se ha capturado entonces se ira a una funcion u otra
// para realizar una accion concreta.
switch($acciontemp)
{
	case 1: $accion = "añadir nuevos usuarios a ".$tabla;
			accion1();
			break;
	case 2: $accion = "modificar usuarios de ".$tabla." [1]";
			accion2();
			break;
	case 5: $accion = "modificar usuarios de ".$tabla." [2]";
			accion5();
			break;
	case 6: $accion = "modificar usuarios de ".$tabla." [3]";
			accion6();
			break;
	case 3: $accion = "eliminar usuarios de ".$tabla." [1]";
			accion3();
			break;
	case 7: $accion = "eliminar usuarios de ".$tabla." [2]";
			accion7();
			break;
	case 4: $accion = "buscar usuarios de ".$tabla;
			accion4();
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
// Funcion que sirve para añadir un usuario con los datos recibidos de la pagina
// "adm_usuarios1.php" [accion1].
function accion1()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $tabla, $tablatemp, $accion, $acciontemp, $campos;
	
	echo "<h3>".$accion."</h3>";
		
	$link=conecta("fjmarkez_es_db");
	$tamagno = count($campos["titulo"]);
	// Sentencia SQL para insertar el usuario en su tabla correspondiente.
	$sentencia_sql="INSERT INTO ".$tabla." VALUES (";
	for ($i=0; $i<$tamagno; $i++)
	{
		$sentencia_sql.="'".$_POST[$campos["nombre"][$i]]."',";
	}	
	
	// Apaño para que al introducir el parentesis la sentencia sql no acabase en "... ,)" y
	// al ejecutarse diera un error.
	$sentencia_sql[strlen($sentencia_sql)-1]=")";
	
	$sql = mysql_query($sentencia_sql);
	
	if (!$sql) 
	{
		echo "<P>Consulta SQL erronea (INSERT) o ya ha sido ejecutada antes</P>";
	}
	else
	{
		// Sentencia SQL para ver como queda la tabla correspondiente tras la insercion del
		// usuario; en verdad esta parte no haria falta hacerla.
		$sql = mysql_query("SELECT * FROM ".$tabla." ORDER BY ".$campos["nombre"][0]);
		if (!$sql) 
		{
			echo "<P>Consulta SQL erronea (SELECT) o ya ha sido ejecutada antes</P>";
		}
		else
		{
			$numcampos= mysql_num_fields($sql);
			echo "<table border=0 cellpadding=3 cellspacing=1>\n";
			echo "<tr valign=middle>\n";
			// Muestra los nombres de los campos
			for ($i = 0; $i < $numcampos; $i++)
			{
				echo "<td align=center><b>".mysql_field_name($sql, $i)."</b></td>\n";
			}
			echo "</tr>\n";

			while ($row = mysql_fetch_row($sql)) 
			{
				echo "<tr>\n";
				for ($i=0; $i < $numcampos; $i++) 
				{
					echo "<td align=center>".$row[$i]."\n</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table>";
		}
	}
	desconecta($link);
	
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a>";
	
}
// -----------------------------------------------------------------------------------------
// Funcion para mostrar y seleccionar los usuarios a modificar segun el criterio pasado desde
// "adm_usuarios1.php" [accion2].
function accion2()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $tabla, $tablatemp, $accion, $acciontemp, $campos;
	
	// Captura de los valores pasados por la pagina "adm_usuarios1.php".
	$buscartemp = $_POST['buscar'];
	$campotemp = $_POST['campo'];
		
	echo "<h3>".$accion."</h3><br>";
	
	// Parte de la sentencia SQL para hacer una seleccion segun el criterio pasado.
	$condicion_sql=$campotemp." LIKE '%".$buscartemp."%'";
	
	// 'muestra' es una funcion del archivo "funciones.inc", en este caso mostrara una tabla
	// con checkboxs de la tabla '$tablatemp" en un formulario que seria mandado a
	// "adm_usuarios2.php" con [accion5].
	muestra(1,$tablatemp,$condicion_sql,2,5);
	
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a> | <a href='javascript:history.go(-1)'>volver a busqueda</a><br>\n";
	
}
// -----------------------------------------------------------------------------------------
// Funcion que muestra los usuarios elegidos en "adm_usuarios2.php" [accion2] para ser
// modificados.
function accion5()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $tabla, $tablatemp, $accion, $acciontemp, $campos, $HTTP_POST_VARS;
	
	echo "<h3>".$accion."</h3><br>";
	
	// Creacion de la parte de la sentencia SQL con las usuarios seleccionados para
	// modificar.
	// Se utiliza en esta parte la variable del PHP '$HTTP_POST_VARS' que es un array donde
	// se encuentran todas las variables que se pasan, y tambien se usa la funcion 'strstr'
	// que se usa para saber si una cadena es subcadena de otra.
	$usuarios_a_modificar="";
	while (list($key, $value) = each(${"HTTP_POST_VARS"}))
	{      
		if (strstr($key,"usuario_")==TRUE)
		{
			//echo ">> Este era un usuario<br>";
			$usuarios_a_modificar.="(".$campos["nombre"][0]." = ".$value.") OR ";
		}
	}
	
	if ($usuarios_a_modificar != "")
	{
		// Apaño para quitar " OR " del final de la cadena 'usuarios_a_modificar'.
		$usuarios_a_modificar=substr($usuarios_a_modificar,0,strlen($usuarios_a_modificar)-4);
		// 'muestra' es una funcion del archivo "funciones.inc", en este caso mostrara una
		// tabla con inputboxs de la tabla '$tablatemp" en un formulario que seria mandado a
		// "adm_usuarios2.php" con [accion6].
		muestra(2,$tablatemp,$usuarios_a_modificar,5,6);
		
	}
	else
	{
		echo "No se ha seleccionado a ningun usuario<br>";
	}
	
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a> | <a href='javascript:history.go(-1)'>volver a resultado</a><br>\n";
}

// -----------------------------------------------------------------------------------------
// Funcion que realiza la modificacion de los usuarios seleccionados en en "adm_usuarios.php"
// [accion2] con los datos de [accion5].
function accion6()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $tabla, $tablatemp, $accion, $acciontemp, $campos, $HTTP_POST_VARS;
	
	echo "<h3>".$accion."</h3><br>";
	
	// Captura de los valores pasados por la pagina "adm_usuarios2.php" [accion5].
	$cantidad_usuarios=$_POST["numero_usuarios"];
	$cantidad_campos=count($campos["nombre"]);
	
	// Creacion de la sentencia SQL para modificar (UPDATE) los usuarios.
	$sentencia_sql="";
		
	for ($i=1;$i<=$cantidad_usuarios;$i++)
	{
		// Creacion de la sentencia SQL que se ejecutara para actualizar
		$sentencia_sql.="UPDATE ".$tabla." SET ";
		
		for ($j=1;$j<$cantidad_campos;$j++)
		{
			$nombre_campo=$campos["nombre"][$j];
			$nombre_campo_recibido=$nombre_campo."_".$i;
			$sentencia_sql.=$nombre_campo." = '".$_POST[$nombre_campo_recibido]."', ";
		}
		$sentencia_sql=substr($sentencia_sql,0,strlen($sentencia_sql)-2);
		
		$nombre_campo=$campos["nombre"][0];
		$nombre_campo_recibido=$nombre_campo."_".$i;
		
		$sentencia_sql.=" WHERE ".$nombre_campo." = ".$_POST[$nombre_campo_recibido];
		
		// Ejecucion de la sentencia SQL
		$link=conecta("fjmarkez_es_db");
		
		$sql = mysql_query($sentencia_sql);
		
		if (!$sql) 
		{
			echo "<P>Consulta SQL erronea (UPDATE".$i.")</P>";
		}
		else
		{
			echo "<P>El usuario ".$i." ha sido actualizado</P>";
		}
		
		desconecta($link);
		$sentencia_sql="";
	}
	
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a><br>\n";
}
// -----------------------------------------------------------------------------------------
// Funcion para mostrar y seleccionar los usuarios a eliminar segun el criterio pasado desde
// "adm_usuarios1.php" [accion3].
function accion3()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $tabla, $tablatemp, $accion, $acciontemp, $campos;
	
	// Captura de los valores pasados por la pagina "adm_usuarios1.php" [accion3].
	$buscartemp = $_POST['buscar'];
	$campotemp = $_POST['campo'];
	
	echo "<h3>".$accion."</h3><br>";
	
	// Parte de la sentencia SQL para hacer una seleccion segun el criterio pasado.
	$condicion_sql=$campotemp." LIKE '%".$buscartemp."%'";
	
	// 'muestra' es una funcion del archivo "funciones.inc", en este caso mostrara una tabla
	// con checkboxs de la tabla '$tablatemp" en un formulario que seria mandado a
	// "adm_usuarios2.php" con [accion7].
	muestra(1,$tablatemp,$condicion_sql,3,7);
	
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a> | <a href='javascript:history.go(-1)'>volver a busqueda</a><br>\n";

}
// -----------------------------------------------------------------------------------------
// Funcion que realiza la eliminacion de los usuarios seleccionados en "adm_usuarios2.php"
// [accion3] de su tabla.
function accion7()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $tabla, $tablatemp, $accion, $acciontemp, $campos, $HTTP_POST_VARS;
	
	echo "<h3>".$accion."</h3><br>";
	
	// Creacion de la parte de la sentencia SQL con las usuarios seleccionados para
	// eliminar.
	// Se utiliza en esta parte la variable del PHP '$HTTP_POST_VARS' que es un array donde
	// se encuentran todas las variables que se pasan, y tambien se usa la funcion 'strstr'
	// que se usa para saber si una cadena es subcadena de otra.
	$usuarios_a_eliminar="";
	while (list($key, $value) = each(${"HTTP_POST_VARS"}))
	{      
		if (strstr($key,"usuario_")==TRUE)
		{
			$usuarios_a_eliminar.="(".$campos["nombre"][0]." = ".$value.") OR ";
		}
	}
	
	if ($usuarios_a_eliminar != "")
	{
		// Apaño para quitar " OR " del final de la cadena 'usuarios_a_modificar'.
		$usuarios_a_eliminar=substr($usuarios_a_eliminar,0,strlen($usuarios_a_eliminar)-4);
		
		// Sentencia SQL para realizar la eliminacion de los usuarios elegidos.
		$sentencia_sql="DELETE FROM ".$tabla." WHERE ".$usuarios_a_eliminar;
		
		// Ejecucion de la sentencia SQL
		$link=conecta("fjmarkez_es_db");
		
		$sql = mysql_query($sentencia_sql);
		
		if (!$sql) 
		{
			echo "<P>Consulta SQL erronea (DELETE)</P>";
		}
		else
		{
			echo "<P>Se ha producido la eliminacion</P>";
		}
		
		desconecta($link);
	}
	else
	{
		echo "No se ha seleccionado nada<br>\n";
	}
	
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a><br>\n";	
	
}
// -----------------------------------------------------------------------------------------
// Funcion que muestra los usuarios segun el criterio pasado desde "adm_usuarios1.php"
// [accion4].
function accion4()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $tabla, $tablatemp, $accion;
	
	// Captura de los valores pasados por la pagina "adm_usuarios1.php" [accion4].
	$buscartemp = $_POST['buscar'];
	$campotemp = $_POST['campo'];
	
	echo "<h3>".$accion."</h3><br>";
	
	// Parte de la sentencia SQL para hacer una seleccion segun el criterio pasado.
	$condicion_sql=$campotemp." LIKE '%".$buscartemp."%'";
	
	// 'muestra' es una funcion del archivo "funciones.inc", en este caso mostrara una tabla
	// simple de la tabla '$tablatemp" segun la condicion dada.
	muestra(0,$tablatemp,$condicion_sql,0,0);
	
	echo "<br>\n";
	echo "<a href='./index.php'>salir</a> | <a href='./administracion.php'>administracion</a> | <a href='javascript:history.go(-1)'>volver a busqueda</a><br>\n";
}

?>
<?php 
include('./includes/pie.inc');
?>