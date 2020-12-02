<?php 
// Inclusion del codigo de seguridad de los Votantes, si no pasa por aqui no se podra
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

// Captura de las variables necesarias que vienen de "muestra_encuesta.php"
$cuantas_Preguntas = $_POST['cuantas_Preguntas'];
$que_encuesta = $_POST['que_encuesta'];

// Creacion de la sentencia SQL para actualizar la tabla 'Contestaciones'. Al realizarse se
// efectua el hecho de votar.
$sentencia_sql = "UPDATE Contestaciones SET Cantidad_Votos=Cantidad_Votos+1 WHERE (Codigo_Encuesta=".$que_encuesta.") AND (";

for ($i=1; $i<=$cuantas_Preguntas; $i++)
{
	$sentencia_sql .= "((Codigo_Pregunta=".$i.") AND (Codigo_Opcion=".$_POST['pregunta'.$i]."))";
	if ($i < $cuantas_Preguntas)
	{
		$sentencia_sql .= " OR ";
	}
	else
	{
		$sentencia_sql .= ")";
	}
}

// 1 ------------------------------------------------------------------------------------------------
$link1=conecta("fjmarkez_es_db"); 	
$sql1 = mysql_query($sentencia_sql);
desconecta($link1);
if (!$sql1) 
{
	echo "<P>Consulta SQL erronea (UPDATE)</P>";
}
else
{
	
// 2 ------------------------------------------------------------------------------------------------
	// Sentencia SQL para dejar constancia que el votante ha votado, hecho, la encuesta,
	// para ello se introduce en la tabla 'Vota' su codigo y el codigo de la encuesta
	// realizada.
	$sentencia_sql = "INSERT INTO Vota VALUES (".$id.",".$que_encuesta.")";
	$link2=conecta("fjmarkez_es_db"); 	
	$sql2 = mysql_query($sentencia_sql);
	desconecta($link2);
	if (!$sql2) 
	{
		echo "<P>Consulta SQL erronea (INSERT) o ha sido ejecutada con anterioridad</P>";
	}
	else
	{	
		echo "<h4>GRACIAS<br>por votar</h4>";
	}
	
// 2 ------------------------------------------------------------------------------------------------

}
// 1 ------------------------------------------------------------------------------------------------

echo "<br>\n";
echo "<a href='./index.php'>salir</a> | <a href='./encuestas.php'>Encuestas</a><br>\n";	
?>
<?php 
// Inclusion del pie de la pagina html.
include('./includes/pie.inc');
?>