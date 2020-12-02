</center>
<hr noshade size="1">
<table border=0 width=100% cellpadding=5 cellspacing=0>
	<tr>
		<td align=left valign=middle>
	fjmarkez@hotmail.com
		</td>
		<td align=right valign=middle>
		<?php 
		// Obtencion de la fecha actual, para ello se usa la funcion "date" que devuelve la
		// fecha y la hora formateada, en este caso solo se le pide que de el año, el mes y
		// dia del mes, como lo devuelve en una cadena de caracteres para separar cada dato
		// se utiliza la funcion "split" que divide una cadena de caracteres segun una
		// expresion regular y se pasa a variables con "list".
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		
		list($anyo, $mes, $dia) = split('[/.-]', date("Y-n-j"));
		echo "Malaga, ".$dia." de ".$meses[$mes-1]." de ".$anyo;
		?>
		</td>
	</tr>
</table>

</body>
</html>
