 <?php 
// Comienzo de la sesion.
session_start();

include('./includes/funciones.inc');

// Si no se encuentran definidas alguna de estas variables de sesion ('iduser' y 'tipouser')
// entonces se redirige al usuario hacia la pagina principal ('index.php').
if (!isset($_SESSION['iduser']) or !isset($_SESSION['tipouser']))
{
	redirige("./index.php","");
}

// Se encuentran definidas las variables de sesion, se almacenan en variables temporales
// para facilitar la codificacion.
$id = $_SESSION['iduser'];
$tipo = $_SESSION['tipouser'];

// Ahora se comprueba que el usuario es de tipo administrador, si no lo es se le redirige
// a la pagina principal ('index.php') y se descargan la variables de sesion, es decir
// desaparecen, si es se le deja continuar.
if ($tipo != "administrador")
{
	unset($_SESSION['iduser']);
	unset($_SESSION['tipouser']);
	redirige("./index.php","");
}
?>