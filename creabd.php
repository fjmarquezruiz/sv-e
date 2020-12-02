<?php 
// Inclusion de la cabecera de la pagina html.
include('./includes/cabecera.inc');
// Script para la creacion de una base de datos en MySQL

// Lo primero que se hace es establecer conexion con el servidor, para ello se le pasa en
// las siguientes variables el nombre del servidor ('servidor'), el login ('nombre') y el
// password ('clave').
$servidor="localhost";
$nombre="";
$clave="";

// Se conecta con el servidor.
$link = @mysql_connect($servidor, $nombre, $clave);

// Comprobacion que se ha establecido conexion con el servidor, si no es asi entonces se
// sale y se muestra un mensaje de error.
if (! $link)
{
	echo "<h3>Imposible establecer conexion con el servidor</h3>";
	include ('./includes/pie.inc');
	exit;
}

?>
<script language=javascript>
<!-- 
function crea(form)
{
	<?
	$basedatos = "Votaciones";
	$mensaje = "";
	
	// Obtencion de una lista de las bases de datos del servidor.
	$db = mysql_list_dbs();
	
	// Cuantas bases de datos hay.
	$num_bd = mysql_num_rows($db);

	//Comprobacion si la base de datos que se quiere crear existe o no.
	$existe = "NO" ;

	for ($i=0; $i<$num_bd; $i++)
	{
		if (mysql_dbname($db, $i) == $basedatos)
		{
			$existe = "SI" ;
			break;
		}
	}

	// Si no existe se crea.
	if ($existe == "NO")
	{
		// Manera 1
		if (! mysql_create_db($basedatos, $link))
		{
			echo "<h3>Imposible crear base de datos \"$basedatos\"</h3>";
			include ('./includes/pie.inc');
			exit;
		}
		else
		{
			$mensaje .= "Base de datos \"$basedatos\" creada con exito. ";
		}
		// Manera 2 
		/*
		if (! mysql_query("CREATE DATABASE $basedatos", $link))
		{
			echo "<h3>Imposible crear base de datos \"$basedatos\"</h3>";
			include ('./includes/pie.inc');
			exit;
		}
		*/	
	}
	else
	{
		$mensaje .= "La base de datos \"$basedatos\" existe. ";
	}
	// -------------------------------------------------------------------------------------
	// Creacion de la tabla 'Votantes'
	$nombre_tabla = "Votantes";
	$sentencia_sql = "CREATE TABLE $nombre_tabla (";
	$sentencia_sql .= "Codigo_Votante SMALLINT UNSIGNED NOT NULL, ";
	$sentencia_sql .= "Login_Votante VARCHAR(15), ";
	$sentencia_sql .= "Password_Votante VARCHAR(15), ";
	$sentencia_sql .= "Nombre VARCHAR(25), ";
	$sentencia_sql .= "Apellidos VARCHAR(25), ";
	$sentencia_sql .= "PRIMARY KEY (Codigo_Votante) ) ";

	if (@mysql_db_query($basedatos, $sentencia_sql, $link))
	{
		$mensaje .= "La tabla \"$nombre_tabla\" se ha creado con éxito. ";
	}
	else
	{
		$mensaje .= "No se ha podido crear la tabla \"$nombre_tabla\". ";
	}
	// -------------------------------------------------------------------------------------
	// Creacion de la tabla 'Administradores'
	$nombre_tabla = "Administradores";
	$sentencia_sql = "CREATE TABLE $nombre_tabla (";
	$sentencia_sql .= "Codigo_Administrador SMALLINT UNSIGNED NOT NULL, ";
	$sentencia_sql .= "Login_Administrador VARCHAR(15), ";
	$sentencia_sql .= "Password_Administrador VARCHAR(15), ";
	$sentencia_sql .= "PRIMARY KEY (Codigo_Administrador) ) ";

	if (@mysql_db_query($basedatos, $sentencia_sql, $link))
	{
		$mensaje .= "La tabla \"$nombre_tabla\" se ha creado con éxito. ";
	}
	else
	{
		$mensaje .= "No se ha podido crear la tabla \"$nombre_tabla\". ";
	}
	// -------------------------------------------------------------------------------------
	// Creacion de la tabla 'Encuestas'
	$nombre_tabla = "Encuestas";
	$sentencia_sql = "CREATE TABLE $nombre_tabla (";
	$sentencia_sql .= "Codigo_Encuesta SMALLINT UNSIGNED NOT NULL, ";
	$sentencia_sql .= "Titulo_Encuesta TINYTEXT, ";
	$sentencia_sql .= "Fecha_Inicio DATE, ";
	$sentencia_sql .= "Fecha_Fin DATE, ";
	$sentencia_sql .= "Codigo_Administrador SMALLINT UNSIGNED, ";
	$sentencia_sql .= "PRIMARY KEY (Codigo_Encuesta), ";
	$sentencia_sql .= "FOREIGN KEY (Codigo_Administrador) REFERENCES Administradores ON DELETE SET NULL) ";

	if (@mysql_db_query($basedatos, $sentencia_sql, $link))
	{
		$mensaje .= "La tabla \"$nombre_tabla\" se ha creado con éxito. ";
	}
	else
	{
		$mensaje .= "No se ha podido crear la tabla \"$nombre_tabla\". ";
	}
	// -------------------------------------------------------------------------------------
	// Creacion de la tabla 'Preguntas'
	$nombre_tabla = "Preguntas";
	$sentencia_sql = "CREATE TABLE $nombre_tabla (";
	$sentencia_sql .= "Codigo_Encuesta SMALLINT UNSIGNED NOT NULL, ";
	$sentencia_sql .= "Codigo_Pregunta SMALLINT UNSIGNED NOT NULL, ";
	$sentencia_sql .= "Titulo_Pregunta TINYTEXT, ";
	$sentencia_sql .= "PRIMARY KEY (Codigo_Pregunta, Codigo_Encuesta))";

	if (@mysql_db_query($basedatos, $sentencia_sql, $link))
	{
		$mensaje .= "La tabla \"$nombre_tabla\" se ha creado con éxito. ";
	}
	else
	{
		$mensaje .= "No se ha podido crear la tabla \"$nombre_tabla\". ";
	}
	// -------------------------------------------------------------------------------------
	// Creacion de la tabla 'Contestaciones'
	$nombre_tabla = "Contestaciones";
	$sentencia_sql = "CREATE TABLE $nombre_tabla (";
	$sentencia_sql .= "Codigo_Encuesta SMALLINT UNSIGNED NOT NULL, ";
	$sentencia_sql .= "Codigo_Pregunta SMALLINT UNSIGNED NOT NULL, ";
	$sentencia_sql .= "Codigo_Opcion SMALLINT UNSIGNED NOT NULL, ";
	$sentencia_sql .= "Titulo_Opcion TEXT, ";
	$sentencia_sql .= "Cantidad_Votos SMALLINT UNSIGNED, ";
	$sentencia_sql .= "PRIMARY KEY (Codigo_Opcion, Codigo_Encuesta, Codigo_Pregunta)) ";

	if (@mysql_db_query($basedatos, $sentencia_sql, $link))
	{
		$mensaje .= "La tabla \"$nombre_tabla\" se ha creado con éxito. ";
	}
	else
	{
		$mensaje .= "No se ha podido crear la tabla \"$nombre_tabla\". ";
	}
	// -------------------------------------------------------------------------------------
	// Creacion de la tabla 'Vota'
	$nombre_tabla = "Vota";
	$sentencia_sql = "CREATE TABLE $nombre_tabla (";
	$sentencia_sql .= "Codigo_Votante SMALLINT UNSIGNED NOT NULL, ";
	$sentencia_sql .= "Codigo_Encuesta SMALLINT UNSIGNED NOT NULL, ";
	$sentencia_sql .= "FOREIGN KEY (Codigo_Votante) REFERENCES Votantes ON DELETE CASCADE, ";
	$sentencia_sql .= "FOREIGN KEY (Codigo_Encuesta) REFERENCES Encuestas ON DELETE CASCADE)";
	

	if (@mysql_db_query($basedatos, $sentencia_sql, $link))
	{
		$mensaje .= "La tabla \"$nombre_tabla\" se ha creado con éxito. ";
	}
	else
	{
		$mensaje .= "No se ha podido crear la tabla \"$nombre_tabla\". ";
	}
	// -------------------------------------------------------------------------------------
	// Una vez creadas todas las tablas se procede a crear un primer usuario administrador
	// para que se pueda entrar a administrar y a crear los primeros usuarios (Votantes y
	// Administradores). 
	// Este usuario tiene como login 'administrador' y password 'administrador', su numero
	// codigo de administrador es el 1.
	$nombre_tabla = "Administradores";
	$sentencia_sql = "INSERT INTO $nombre_tabla VALUES (";
    $sentencia_sql .= "1, ";
    $sentencia_sql .= "'administrador', ";
    $sentencia_sql .= "'administrador' )";
    
    $sql = mysql_query($sentencia_sql);
	
	if (!$sql) 
	{
		$mensaje .= "Error al insertar el usuario \"administrador\". ";
	}
	else
	{
		$mensaje .= "IMPORTANTE: Se ha insertado el usuario \"administrador\". ";
	}
	// -------------------------------------------------------------------------------------
	// Mostrar los mensajes que hayan salido.
	echo "form.el_texto.value='$mensaje';";	

?>
}
//-->
</script>

<h4>crear la base de datos y las tablas?</h4>

<form name='formulario' method=POST>
<table border=0 cellpadding=5 cellspacing=0 align=center>
	<tr>
		<td align=center valign=middle>
	<!--<input type='text' name='el_texto' value='' readonly style="text-align:center;">-->
	<b>mensajes</b><br>
	<textarea name='el_texto' readonly cols=65 rows=5>
	</textarea>
		</td>
	</tr>
	<tr>
		<td align=center valign=middle>
	<input type="button" value="Crear" onclick="crea(this.form)" class="boton">
		</td>
	</tr>
</table>
</form>

<a href='./index.php'>salir</a>

<?php
// Inclusion del pie de la pagina html.
include ('./includes/pie.inc');
?>
