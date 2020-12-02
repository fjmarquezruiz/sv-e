<?php 
// Inclusion de la libreria de funciones que seran necesarias.
include('./includes/funciones.inc');

// Captura de parametros de la pagina anterior, "index.php".
$login_temp = $_POST['login_entrada'];
$password_temp = $_POST['password_entrada'];

// Se establece la conexion al servidor de la base de datos.
$link=conecta("fjmarkez_es_db");

// Sentencia SQL que sirve para comprobar si el login y el password pasado son de la
// tabla 'Administradores'.
$sentencia_sql="SELECT * FROM Administradores WHERE login_administrador='".$login_temp."' AND password_administrador='".$password_temp."'";
$sql = mysql_query($sentencia_sql);
	
if ($sql == FALSE)
{
	echo "<P>Consulta SQL erronea (Administradores)</P>";
	exit;
}
else
{
	// Se ve cuantas lineas han salido de la consulta SQL, si:
	// $numfilas = 0 => no existe el usuario en la tabla 'Administradores'.
	// $numfilas != 0 => el usuario existe en la tabla 'Administradores'.
	$numfilas = mysql_num_rows($sql);
	
	if ($numfilas == 0)
	{
		// Con esta sentencia SQL se obtiene si son de la tabla 'Votantes'.
		$sql = mysql_query("SELECT * FROM Votantes WHERE login_votante='".$login_temp."' AND password_votante='".$password_temp."'");
		
		if ($sql == FALSE)
		{
			echo "<P>Consulta SQL erronea (USUARIOS)</P>";
			exit; 
		}
		else
		{
			// Se ve cuantas lineas han salido de la consulta SQL, si:
			// $numfilas = 0 => no existe el usuario en la tabla 'Votantes'.
			// $numfilas != 0 => el usuario existe en la tabla 'Votantes'.
			$numfilas = mysql_num_rows($sql);
			
			iF ($numfilas == 0)
			{
				// No pertenece ni a la tabla 'Administradores' ni a 'Votantes' entonces
				// se le redirige a la pagina "error.php".
				redirige("./error.php","");
			}
			else
			{
				// Es un votante.
				$row = mysql_fetch_row($sql);
				$id_usuario = $row[0];
				
				// Comienza la sesion.
				session_start();
				
				// Se establecen las variables de sesion que serviran para validar el usuario en
				// las paginas siguientes.
				$_SESSION['iduser']=$row[0];
				$_SESSION['tipouser']="votante";
				
				// Como es un votante se le redirecciona a la pagina donde realizar las
				// votaciones ("encuestas.php").
				redirige("./encuestas.php","");
			}
		}
	}
	else
	{
		// Es un administrador.
		$row = mysql_fetch_row($sql);
		$id_usuario = $row[0];
		
		// Comienza la sesion.
		session_start();
		
		// Se establecen las variables de sesion que serviran para validar el usuario en
		// las paginas siguientes.
		$_SESSION['iduser']=$row[0];
		$_SESSION['tipouser']="administrador";
		
		// Como es un administrador se le redirecciona a la pagina de administracion
		// ("administracion.php").
		redirige("./administracion.php","");
	}
}

// Se cierra la conexion al servidor.
desconecta($link);
?>