<?php 
// Clase referente a las opciones de las preguntas de las encuestas.
class COpcion
{
	var $codigo_opcion;
	var $titulo_opcion;
	var $cantidad_votos;
		
	// Constructor, funcion que se ejecuta automaticamente al crearse el objeto de clase
	// COpcion.
	function COpcion($cod,$tit)
	{
		$this->codigo_opcion = $cod;
		$this->titulo_opcion = $tit;
		$this->cantidad_votos = 0;
	}
	
	// Metodo que establece los valores en las variables del objeto de clase COpcion.
	function set_opcion($cod,$tit)
	{
		$this->codigo_opcion = $cod;
		$this->titulo_opcion = $tit;
	}
	
	// Metodo que muestra el contenido de la opcion.
	function view_opcion()
	{
		echo "$this->codigo_opcion $this->titulo_opcion = $this->cantidad_votos<br>";
	}
}

// Clase de las preguntas de las encuestas.
class CPregunta
{
	var $codigo_pregunta;
	var $titulo_pregunta;
	
	var $opciones;
	var $contador_opciones;
	
	var $i;
	
	// Constructor, funcion que se ejecuta automaticamente al crearse el objeto de clase
	// CPregunta.
	function CPregunta($cod,$tit)
	{
		$this->codigo_pregunta = $cod;
		$this->titulo_pregunta = $tit;
		
		$this->contador_opciones = 0;
	}
	
	// Metodo que establece los valores en las variables del objeto de clase CPregunta.
	function set_pregunta($cod,$tit)
	{
		$this->codigo_pregunta = $cod;
		$this->titulo_pregunta = $tit;
	}	

	// Metodo que muestra el contenido de la pregunta y de todas las opciones.
	function view_pregunta()
	{
		echo $this->codigo_pregunta.") ".$this->titulo_pregunta."<br>";
		
		if ($this->contador_opciones > 0)
		{
			for ($i=1;$i<=$this->contador_opciones;$i++)
			{
				$this->opciones[$i]->view_opcion();
			}
		}
		else
		{
			echo "[ no hay opciones ]<br>";
		}
	}
	
	// Metodo o funcion que crea una nueva opcion, para ello la asigna a en un array
	// ('opciones') donde indica su posicion en el objeto de clase CPregunta, la opcion
	// es un objeto de la clase COpcion. 
	function new_opcion($num_opcion,$titulo_opcion)
	{
		$this->opciones[$num_opcion]=new COpcion($num_opcion,$titulo_opcion);
		$this->contador_opciones++;
	}
}

// Clase de las encuestas.
class CEncuesta
{
	var $codigo_encuesta;
	var $titulo_encuesta;
	var $fecha_inicio;
	var $fecha_fin;
	var $codigo_administrador;
	
	var $preguntas;
	var $contador_preguntas;
	
	var $i;

	// Constructor, funcion que se ejecuta automaticamente al crearse el objeto de clase
	// CEncuesta.
	function CEncuesta($cod,$tit,$inicio,$fin,$cod_adm)
	{
		$this->codigo_encuesta = $cod;
		$this->titulo_encuesta = $tit;
		$this->fecha_inicio = $inicio;
		$this->fecha_fin = $fin;
		$this->codigo_administrador = $cod_adm;
		
		$this->contador_preguntas = 0;
	}
	
	// Metodo o funcion que muestra el contenido de las variables de la clase.
	function view_datos()
	{
		echo "codigo encuesta = ".$this->codigo_encuesta."<br>";
		echo "titulo encuesta = ".$this->titulo_encuesta."<br>";
		echo "fecha inicio = ".$this->fecha_inicio."<br>";
		echo "fecha fin = ".$this->fecha_fin."<br>";
		echo "codigo administrador = ".$this->codigo_administrador."<br>";
		
		echo "cuantas preguntas lleva? ".$this->contador_preguntas."<br>";
	}
	
	// Metodo o funcion que crea una nueva pregunta, para ello la asigna a en un array
	// ('preguntas') donde indica su posicion en el objeto de clase CEncuesta, la pregunta
	// es un objeto de la clase CPregunta. 
	function new_pregunta($num_pregunta,$titulo_pregunta)
	{
		$this->preguntas[$num_pregunta]=new CPregunta($num_pregunta,$titulo_pregunta);
		$this->contador_preguntas++;
	}
	
	// Metodo utilizado para variar el contenido del objeto de clase CPregunta.
	function set_pregunta($num_pregunta,$titulo_pregunta)
	{
		$this->preguntas[$num_pregunta]->set_pregunta($num_pregunta,$titulo_pregunta);
	}
	
	// Metodo que muestra el contenido de todas las preguntas.
	function view_preguntas()
	{
		if ($this->contador_preguntas > 0)
		{
			for ($i=1;$i<=$this->contador_preguntas;$i++)
			{
				$this->preguntas[$i]->view_pregunta();
			}
		}
	}

	// Metodo o funcion que crea una nueva opcion, se le pasa el numero de pregunta a la que
	// estara asignada esta nueva opcion y se llama al metodo 'new_opcion' del objeto
	// CPregunta pasandole el resto de parametros. 	
	function new_opcion($num_pregunta,$num_opcion,$titulo_opcion)
	{
		$this->preguntas[$num_pregunta]->new_opcion($num_opcion,$titulo_opcion);
	}
}
?>