<?php 
// Inclusion del codigo de seguridad de la administracion, si no pasa por aqui no se podra
// ver la pagina.
include('./includes/seguridad_adm.inc');

// Inclusion de la cabecera de la pagina html.
include('./includes/cabecera.inc');

// Captura de parametros de la pagina anterior, "administracion.php".
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
	case 1: $tabla = "votantes";
			$campos = array("titulo" => array("Codigo","Login","Password","Password 2","Nombre","Apellidos"),
							"nombre" => array("Codigo_Votante","Login_Votante","Password_Votante","Password_Votante2","Nombre","Apellidos"),
							"tipo" => array("hidden","text","password","password","text","text")
							);
			break;
	case 2: $tabla = "administradores";
			$campos = array("titulo" => array("Codigo","Login","Password","Password 2"),
							"nombre" => array("Codigo_Administrador","Login_Administrador","Password_Administrador","Password_Administrador2"),
							"tipo" => array("hidden","text","password","password")
							);
			break;
}

// Segun la variable '$acciontemp' que se ha capturado entonces se ira a una funcion u otra
// para realizar una accion concreta.
switch($acciontemp)
{
	case 1: $accion = "añadir usuarios a ".$tabla;
			accion1();
			break;
	case 2: $accion = "modificar usuarios de ".$tabla;
			accion2();
			break;
	case 3: $accion = "eliminar usuarios de ".$tabla;
			accion3();
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
}

// -----------------------------------------------------------------------------------------
// Funcion que muestra el formulario para añadir un usuario (votante o administrador) a su
// tabla.
function accion1()
{
	// Importacion a la funcion de las variable globales que seran usadas.
	global $tabla, $tablatemp, $accion, $acciontemp, $campos;
	
	echo "<h3>".$accion."</h3><br>";
	
	echo "<!-- formulario para añadir una base de datos -->\n";
	echo "<form action='adm_usuarios2.php' method=POST>\n";
		
		// Campos ocultos en los que se pasara a  "adm_usuarios2.php" la tabla donde tiene
		// que insertar los datos del usuario y la accion que se tiene que ejecutar
		// [accion 1]
		echo "<input type='hidden' name='tabla' value='".$tablatemp."'>\n";
		echo "<input type='hidden' name='accion' value='".$acciontemp."'>\n";
		
		// Sentencia SQL para averiguar el codigo de usuario que tendra el que se va a
		// añadir.
		$link=conecta("votaciones");
		
		$sentencia_sql="SELECT * FROM ".$tabla;
		$sql = mysql_query($sentencia_sql);
		if (!$sql) 
		{
			echo "<P>Consulta SQL erronea (SELECT)</P>";
		}
		else
		{
			$valorID = 0;
			while ($row = mysql_fetch_row($sql)) 
			{
				if ($valorID < $row[0])
				{
					$valorID = $row[0];
				}
			}
			$valorID++;
		}
		
		desconecta($link);
		
		// Comprobacion de los tamaños de cada fila del array bidimensional.
		// Si coinciden los tamaños se muestra por pantalla, sino no se hace nada.
		$tamagno1 = count($campos["titulo"]);
		$tamagno2 = count($campos["nombre"]);
		
		if ($tamagno1 == $tamagno2)
		{
			echo "<input type='".$campos["tipo"][0]."' name='".$campos["nombre"][0]."' value='".$valorID."'>\n";
			echo "<table border=0 cellpadding=5 cellspacing=0 align=center>\n";
			for ($i=1; $i<$tamagno1; $i++)
			{
				echo "<tr>\n";
				echo "<td valign=middle>\n";
				echo $campos["titulo"][$i];
				echo "</td>";
				echo "<td valign=middle colspan=2>\n";
				echo "<input type='".$campos["tipo"][$i]."' name='".$campos["nombre"][$i]."' size='25'>";
				echo "</td>";
				echo "</tr>\n";
			}
			echo "<tr>\n";
			echo "<td>\n";
			echo "</td>\n";
			echo "<td align='center' valign='middle'>\n";
			echo "<input type='reset' value='Borrar' class='boton'>\n";
			echo "</td>\n";
			echo "<td align='center' valign='middle'>\n";
			echo "<input type='button' value='Enviar' onclick='valida_".$acciontemp."_".$tabla."(this.form)' class='boton'>\n";
			echo "</td>\n";
			echo "</tr>\n";
			echo "</table>\n";
		}
		else
		{
			echo "<p>Las filas de los campos no coinciden</p>\n";
		}
			
		
	echo "</form>\n";
	echo "<!-- FIN formulario para añadir una base de datos -->\n";
}

// -----------------------------------------------------------------------------------------
// Funcion que muestra el buscador para modificar uno o varios usuarios (votantes o
// administradores) de su tabla.
function accion2()
{
	// Importacion a la funcion de las variable globales que seran usadas 
	global $tabla, $tablatemp, $accion, $acciontemp;
	echo "<h3>".$accion."</h3><br>";
	
	// A la funcion 'buscador' se le pasa la tabla donde se va a buscar y la siguente accion
	// a realizar en la pagina "adm_usuarios2.php", en este caso [accion 2]
	buscador($tablatemp, $acciontemp);
}

// -----------------------------------------------------------------------------------------
// Funcion que muestra el buscador para eliminar uno o varios usuarios (votantes o
// administradores) de su tabla.
function accion3()
{
	// Importacion a la funcion de las variable globales que seran usadas 
	global $tabla, $tablatemp, $accion, $acciontemp;
	echo "<h3>".$accion."</h3><br>";

	// A la funcion 'buscador' se le pasa la tabla donde se va a buscar y la siguente accion
	// a realizar en la pagina "adm_usuarios2.php", en este caso [accion 3]
	buscador($tablatemp, $acciontemp);
}

// -----------------------------------------------------------------------------------------
// Funcion que muestra el buscador para buscar uno o varios usuarios (votantes o
// administradores).
function accion4()
{
	// Importacion a la funcion de las variable globales que seran usadas 
	global $tabla, $tablatemp, $accion, $acciontemp;
	echo "<h3>".$accion."</h3><br>";

	// A la funcion 'buscador' se le pasa la tabla donde se va a buscar y la siguente accion
	// a realizar en la pagina "adm_usuarios2.php", en este caso [accion 4]
	buscador($tablatemp, $acciontemp);
}

?>

<br>
<a href='./index.php'>salir</a> | <a href="./administracion.php">administracion</a>

<?php 
// Inclusion del pie de la pagina html.
include('./includes/pie.inc');
?>