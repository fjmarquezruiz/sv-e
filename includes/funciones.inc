<?php 
// -----------------------------------------------------------------------------------------
// Funcion a la que se le pasa el nombre de la base de datos a la que se desea conectarse
// y realiza la conexion.
// USO: conecta("nombre_base_datos");
function conecta($nombre_base_datos)
{
	// Establecer la conexion al servidor de la base de datos, para ello se le pasa en tres
	// variables los datos necesarios para conectarse:
	// 		$servidor -> el nombre DNS o la direccion IP donde se esta el servidor.
	//		$nombre -> el nombre o login del usuario que desea conectarse al servidor.
	//		$clave -> la clave o password del usuario que desea conectarse al servidor.
	$servidor="localhost";
	$nombre="root";
	$clave="";
	// 'mysql_connect' devuelve TRUE si se ha realizado la conexion o FALSE en otro caso
	$link = mysql_connect($servidor, $nombre, $clave);

	// Comprobacion que se ha establecido conexion con el servidor.
	if (!$link)
	{
		echo "<h2 align='center'>ERROR: Imposible establecer conexion con el Servidor</h3>";
		exit;
	}

	// Una vez realizada la conexion al servidor de la base de datos se procede a elegir la
	// base de datos de la cual se van a sacar los datos que se necesiten, para ello se usa
	// la funcion 'mysql_select_db' que devuelve TRUE si se ha conectado la base de datos
	// adecuadamente o FALSE en otro caso.
	$db = mysql_select_db($nombre_base_datos, $link);

	// Comprobacion que se ha establecido conexion con la base de datos dentro del servidor
	if (!$db)
	{
		echo "<h2 align='center'>ERROR: Imposible establecer conexion a la Base de Datos</h3>";
		exit;
	}
	return $link;
}
// -----------------------------------------------------------------------------------------
// Funcion que realiza la desconexion del servidor y la base de datos a la cual se ha
// conectado con la funcion 'conecta'.
// USO: desconecta();
function desconecta($link)
{
	mysql_close($link);
}
// -----------------------------------------------------------------------------------------
// Funcion que redirige hacia una pagina pasandole el nombre de esa pagina, junto con su ruta si
// hiciera falta, y una cadena de variables que pueda necesitarse en dicha pagina. Si la
// cadena es vacia entonces se redirigira hacia esa pagina sin pasarle variables.
// USO: redirige("prueba.php", "?id_usuario=12");
//		redirige("gran_error.php", "");
function redirige($pagina, $cadena)
{
	echo "<script language=\"javascript\">";
	if ($cadena == "")
	{
		echo "location.href='./".$pagina."';";
	}
	else
	{
		echo "location.href='./".$pagina.$cadena."';";
	}
	echo "</script>";
	exit;
}
// -----------------------------------------------------------------------------------------
// Funcion que muestra en la pagina el buscador de datos de la base de datos. Lleva asociado
// una funcion javascript en el archivo 'funciones.js' llamada 'valida_buscador' que se
// encarga de asegurarse que se ha introducido un criterio que buscar.
// USO: buscador("nombre_de_la_tabla_donde_buscar","codigo_accion_siguiente")
function buscador($que_tabla,$que_accion)
{
	global $campos;
	
	echo "<!-- formulario para buscador una base de datos -->\n";
	echo "<form action='adm_usuarios2.php' method='POST'>\n";
	
	echo "<input type='hidden' name='tabla' value='".$que_tabla."'>\n";
	echo "<input type='hidden' name='accion' value='".$que_accion."'>\n";
	
		// Comprobacion de los tamaños de cada fila del array bidimensional.
		// Si coinciden los tamaños se muestra por pantalla, sino no se hace nada.
		$tamagno1 = count($campos["titulo"]);
		$tamagno2 = count($campos["nombre"]);
		
		if ($tamagno1 == $tamagno2)
		{
			echo "<table border=0 cellpadding=5 cellspacing=0>\n";
			echo "<tr>\n";
			echo "<td valing=middle>\n";
			echo "Buscar:\n";
			echo "</td>\n";
			echo "<td valing=middle colspan=2>\n";
			echo "<input type=\"text\" name=\"buscar\" size=25>";
			echo "</td>\n";
			echo "<td valing=middle>\n";
			echo "Campo:\n";
			echo "</td>\n";
			echo "<td align=center valing=middle colspan=2>\n";
			echo "<select name=\"campo\" size=1>";
			for ($i=1; $i<$tamagno1; $i++)
			{
				if ($campos["titulo"][$i] != "Password 2")
				{
					echo "<option value='".$campos["nombre"][$i]."'>".$campos["titulo"][$i]."</option>";
				}
			}
			echo "</select>\n";
			echo "</td>\n";
			echo "<td>\n";
			echo "</td>\n";
			echo "<td align='center' valign='middle'>\n";
			echo "<input type='reset' value='Borrar' class='boton'>\n";
			echo "</td>\n";
			echo "<td align='center' valign='middle'>\n";
			echo "<input type='button' value='Buscar' onclick='valida_buscador(this.form)' class='boton'>\n";
			echo "</td>\n";
			echo "</tr>\n";
			echo "</table>\n";
		}
		else
		{
			echo "<h3>Las filas de los campos no coinciden</h3>\n";
		}
	
	echo "</form>\n";
	echo "<b>NOTA:</b> El simbolo que se puede usar como comodir es <b>%</b>\n";
	echo "<br>\n";
	echo "<!-- FIN formulario para buscar una base de datos -->\n";
}

// Funcion basada en la funcion 'buscador' de este archivo, pero solo para la tabla
// 'encuestas'.
// USO: buscador_encuestas($que_pagina,$que_accion)
// 'que_pagina' puede tomar los valores: 0 ó 1, 0 para ir a la pagina 'adm_encuestas2.php' y
// 1 para ir a la pagina 'adm_encuestas3.php'
function buscador_encuestas($que_pagina,$que_accion)
{
	$campos = array("titulo" => array("Codigo","Titulo","Fecha Inicio","Fecha Fin","Adminstrador"),
					"nombre" => array("Codigo_Encuesta","Titulo_Encuesta","Fecha_Inicio","Fecha_Fin","Codigo_Administrador")
					);
	switch ($que_pagina)
	{
		case 0: $que_pagina="adm_encuestas2.php";
				break;
		case 1: $que_pagina="adm_encuestas3.php";
				break;
	}

	echo "<!-- formulario para buscador una base de datos -->\n";
	echo "<form action='".$que_pagina."' method='POST'>\n";
	
	echo "<input type='hidden' name='accion' value='".$que_accion."'>\n";
			
	echo "<table border=0 cellpadding=5 cellspacing=0>\n";
	echo "<tr>\n";
		echo "<td valing=middle>\n";
		echo "Buscar:\n";
		echo "</td>\n";
		echo "<td valing=middle colspan=2>\n";
		echo "<input type=\"text\" name=\"buscar\" size=25>";
		echo "</td>\n";
		echo "<td valing=middle>\n";
		echo "Campo:\n";
		echo "</td>\n";
		echo "<td align=center valing=middle colspan=2>\n";
		echo "<select name=\"campo\" size=1>";
		
		$tamagno = count($campos["nombre"]);
		for ($i=1; $i<$tamagno; $i++)
		{
			echo "<option value='".$campos["nombre"][$i]."'>".$campos["titulo"][$i]."</option>";
		}
		
		echo "</select>\n";
		echo "</td>\n";
		echo "<td>\n";
		echo "</td>\n";
		echo "<td align='center' valign='middle'>\n";
		echo "<input type='reset' value='Borrar' class='boton'>\n";
		echo "</td>\n";
		echo "<td align='center' valign='middle'>\n";
		echo "<input type='button' value='Buscar' onclick='valida_buscador(this.form)' class='boton'>\n";
		echo "</td>\n";
	echo "</tr>\n";
	echo "</table>\n";
	
	echo "</form>\n";
	echo "<b>NOTA:</b> El simbolo que se puede usar como comodir es <b>%</b>\n";
	echo "<br>\n";
	echo "<!-- FIN formulario para buscar una base de datos -->\n";
}

// Funcion que muestra en una tabla con el contenido de tabla de datos.
// USO: muestra(tipo_muestra,que_tabla,"condicion_sql",actual_accion,siguiente_accion)
// 'tipo_muestra' puede tomar los siguientes valores:
// 		tipo_muestra = 0 -> pone tabla simple
//		tipo_muestra = 1 -> pone checkboxs, hace falta + parametros
//		tipo_muestra = 2 -> pone inputboxs, hace falta + parametros
// 'que_tabla' toma los siguientes valores:
//		que_tabla = 1  -> se muestra la tabla 'votantes'
//		que_tabla = 2  -> se muestra la tabla 'administradores'
//		que_tabla = 3  -> se muestra la tabla 'encuestas'
//		que_tabla = 4  -> se muestra la tabla 'preguntas'
//		que_tabla = 5  -> se muestra la tabla 'contestaciones'
//		que_tabla = 6  -> se muestra la tabla 'vota'
// 'condicion_sql' es una cadena de caracteres donde iria la condicion que va detras de la
// 		particula WHERE de SQL
// 'actual_accion' es para indicar la accion en la que se va a ejecutar esta funcion y
// 		'siguiente_accion' es para indicar cual sera la futura accion a la que se va desde
//		la 'actual_accion', estas dos variables sirven para codificar una funcion javascript
//		del archivo 'funciones.js' que sirve para validar el formulario que se mostraria con
//		los 'tipo_muestra' 1 y 2.
// EJEMPLOS: muestra(0,5,"",2,3);
//			 [Se muestra una tabla simple sin formulario de la tabla de datos
//			 'contestaciones', las dos ultimas variables se obvian]
//			 muestra(1,2,"Codigo_Administrador>2",2,3)
//			 [Se muestra una tabla con checkbox en un lateral, y un formulario con la funcion
//			 'valida_2_3_administradores']
function muestra($tipo_muestra,$que_tabla,$condicion_sql,$actual_accion,$siguiente_accion)
{
	global $campos;
		
	switch ($que_tabla)
	{
		case 1: $nombre_tabla="votantes";
				break;
		case 2: $nombre_tabla="administradores";
				break;
		case 3: $nombre_tabla="encuestas";
				$campos = array("titulo" => array("Codigo","Titulo","Fecha Inicio","Fecha Fin","Adminstrador"),
								"nombre" => array("Codigo_Encuesta","Titulo_Encuesta","Fecha_Inicio","Fecha_Fin","Codigo_Administrador")
								);
				break;
		case 4: $nombre_tabla="preguntas";
				break;
		case 5: $nombre_tabla="contestaciones";
				break;
		case 6: $nombre_tabla="vota";
				break;
	}
	$link=conecta("votaciones");
	
	$sentencia_sql="SELECT * FROM ".$nombre_tabla;
	if ($condicion_sql != "")
	{
		$sentencia_sql.=" WHERE (".$condicion_sql.")";
	}
	
	$sentencia_sql.=" ORDER BY ".$campos['nombre'][0];
	
	$sql = mysql_query($sentencia_sql);
		
	if (!$sql) 
	{
		echo "<P>Consulta SQL erronea (SELECT)</P>";
	}
	else
	{
		// Comprueba si el resultado de la consulta da alguna fila; en caso de TRUE continua
		// y muestra el resultado, en caso de FALSE muestra un mensaje de error.
		if ($row = mysql_fetch_row($sql))
		{
			$numcampos= mysql_num_fields($sql);
			
			// Aqui comienza el formulario de muestra.
			
			if ($tipo_muestra > 0)
			{	
				echo "<form action='".$_SERVER['PHP_SELF']."' method='POST'>\n";
				
				echo "<input type='hidden' name='tabla' value='".$que_tabla."'>\n";
				echo "<input type='hidden' name='accion' value='".$siguiente_accion."'>\n";
			}
			echo "<table border=0 cellpadding=3 cellspacing=0>\n";
			
			// Fila cabecera.
			echo "<tr valign=middle>\n";
				if ($tipo_muestra == 1)
				{
					echo "<td align=center><b>Selección</b></td>\n";
				}
				// Mostrar los nombres de los campos.
				$tamagno = count($campos["titulo"]);
					
				for ($i = 0; $i < $tamagno; $i++)
				{
					$titulo_mostrar=$campos["titulo"][$i];
					echo "<td align=center><b>".$titulo_mostrar."</b></td>\n";
				}
			echo "</tr>\n";
			
			// Mostrar los usuarios que han sido el resultado de la consulta SQL.
			// Filas de datos.
			$conta_usuarios=1;
			do
			{
				echo "<tr>\n";
					if ($tipo_muestra == 1)
					{
						echo "<td align=center>\n";
						echo "<input type='checkbox' name='usuario_".$conta_usuarios."' value='".$row[0]."' class='sinborde'>\n";
						echo "</td>\n";
					}
					echo "<td align=center valign=middle>".$row[0]."\n</td>\n";
					echo "<input type='hidden' name='".$campos["nombre"][0]."_".$conta_usuarios."' value='".$row[0]."'>\n";
					for ($i=1; $i < $numcampos; $i++) 
					{
						echo "<td align=center>\n";
						if ($tipo_muestra == 2)
						{
							echo "<input type='text' name='".$campos["nombre"][$i]."_".$conta_usuarios."' value='".$row[$i]."'>\n";
						}
						else
						{
							echo $row[$i]."\n";
						}
						echo "</td>\n";
					}
				echo "</tr>\n";
				$conta_usuarios++;
			}while ($row = mysql_fetch_row($sql));
			
			echo "</table><br>\n";
			
			if ($tipo_muestra > 0)
			{
				echo "<input type='reset' value='Borrar' class='boton'>\n";
				echo "<input type='button' value='Enviar' onclick='valida_".$actual_accion."_".$siguiente_accion."_".$nombre_tabla."(this.form);' class='boton'>\n";
				$conta_usuarios--;
				echo "<input type='hidden' name='numero_usuarios' value='".$conta_usuarios."'>\n";
				echo "</form>\n";
			}
		}
		else
		{
			echo "No hay ningun resultado<br>";
		}
			
	}
	desconecta($link);
}
?>
