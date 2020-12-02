<!--
function abrir (URL,width,height) {
	hnd = window.open (URL, 'ventana','toolbar=no,location=no,directories=no,menubar=no,scrollbars=yes,status=no,resizable=no,width='+width+',height='+height);
	hnd.focus();
}

function Item(){
	this.length = Item.arguments.length
	for (var i = 0; i < this.length; i++)
		this[i] = Item.arguments[i]
}

// Funcion que comprueba que 'valor' es un numero entero, devuelve TRUE si lo es o FALSE
// si no lo es.
function es_entero(valor)
{
	ok = "1234567890";
	for(i=0; i < valor.length ;i++)
	{
		if(ok.indexOf(valor.charAt(i))<0)
		{ 
			return (false);
		}	
	}
	return (true);
}

// Funcion que al pasarle un mes y un año dice cuantos dias tiene.
function cuantosDias(mes, anyo)
{
	var cuantosDias = 31;
    if (mes == "Abril" || mes == "Junio" || mes == "Septiembre" || mes == "Noviembre")
    {
		cuantosDias = 30;
	}
	if (mes == "Febrero" && (anyo/4) != Math.floor(anyo/4))
	{
		cuantosDias = 28;
	}
	if (mes == "Febrero" && (anyo/4) == Math.floor(anyo/4))
	{
		cuantosDias = 29;
	}
    return cuantosDias;
}

// Funcion que en los formularios donde aparece la eleccion de fechas hace que el numero
// de dias varie segun el mes y el año.
function asignaDias(cuando)
{
	comboDias = eval("document.Formulario.Dia"+cuando);
	comboMeses = eval("document.Formulario.Mes"+cuando);
	comboAnyos = eval("document.Formulario.Anyo"+cuando);

	Month = comboMeses[comboMeses.selectedIndex].text;
	Year = comboAnyos[comboAnyos.selectedIndex].text;

	diasEnMes = cuantosDias(Month, Year);
	diasAhora = comboDias.length;
	
	if (diasAhora > diasEnMes)
	{
		for (i=0; i<(diasAhora-diasEnMes); i++)
		{
			comboDias.options[comboDias.options.length - 1] = null
		}
    }
    if (diasEnMes > diasAhora)
    {
        for (i=0; i<(diasEnMes-diasAhora); i++)
        {
            sumaOpcion = new Option(comboDias.options.length + 1);
            comboDias.options[comboDias.options.length]=sumaOpcion;
        }
    }
    if (comboDias.selectedIndex < 0)
    {
		comboDias.selectedIndex = 0;
	}
}

// Funcion que valida los campos el formulario de entrada de la pagina "index.php".
function valida_entrada(form)
{
	str = "AVISOS:\n";
	flag = false;
	
	// Verificacion del campo 'login_entrada'.
	if (form.login_entrada.value == '')
	{
		flag = true;
		str = str + '- Falta login\n';
	}
	
	// Verificacion del campo 'password_entrada'.
	if (form.password_entrada.value == '')
	{
		flag = true;
		str = str + '- Falta password\n';
	}
	
	if (flag)
	{
		alert(str);
		return;
	}  

	form.submit();
}

// Funcion que valida los campos del formulario usuarios en la pagina "administracion.php".
function valida_adm_usuarios(form)
{
	str = "AVISOS:\n";
	flag = false;
	
	// Verificacion del campo 'tabla'.
	if (form.tabla.value < 1)
	{
		flag = true;
		str = str + '- Elige una tabla\n';
	}
	
	// Verificacion del campo 'accion'.
	if (form.accion.value < 1)
	{
		flag = true;
		str = str + '- Elige una acción\n';
	}
	
	if (flag)
	{
		alert(str);
		return;
	}
	
	form.submit();
}

// Funcion que valida los campos del formulario Encuestas en la pagina "administracion.php".
function valida_adm_Encuestas(form)
{
	str = "AVISOS:\n";
	flag = false;
	
	// Verificacion del campo 'accion'.
	if (form.accion.value < 1)
	{
		flag = true;
		str = str + '- Elige una acción\n';
	}
	
	if (flag)
	{
		alert(str);
		return;
	}
	
	form.submit();
}

// Funcion que valida los campos del formulario añadir Votantes en la pagina
// "adm_usuarios.php".
function valida_1_Votantes(form)
{
	str = "AVISOS:\n";
	flag = false;
	
	// Verificacion del campo 'Login_Votante'.
	if (form.Login_Votante.value == "")
	{
		flag = true;
		str = str + '- Falta el login\n';
	}
	else
	{
		if (form.Login_Votante.value.length < 3)
		{
			flag = true;
			str = str + '- El login ha de tener al menos 3 caracteres\n';
		}
		if (form.Login_Votante.value.length > 16)
		{
			flag = true;
			str = str + '- El login ha de tener menos de 16 caracteres\n';
		}
	}
	
	// Verificacion del campo 'Password_Votante'.
	if (form.Password_Votante.value == "")
	{
		flag = true;
		str = str + '- Falta el password (campo PASSWORD)\n';
	}
	else
	{
		if (form.Password_Votante.value.length < 6)
		{
			flag = true;
			str = str + '- El password ha de tener al menos 6 caracteres (campo PASSWORD)\n';
		}
		if (form.Password_Votante.value.length > 16)
		{
			flag = true;
			str = str + '- El password ha de tener menos de 16 caracteres (campo PASSWORD)\n';
		}
	}
	
	// Verificacion del campo 'Password_Votante2'.
	if (form.Password_Votante2.value == "")
	{
		flag = true;
		str = str + '- Falta repetir el password (campo PASSWORD 2)\n';
	}
	else
	{
		if (form.Password_Votante2.value.length < 6)
		{
			flag = true;
			str = str + '- El password ha de tener al menos 6 caracteres (campo PASSWORD 2)\n';
		}
		if (form.Password_Votante2.value.length > 16)
		{
			flag = true;
			str = str + '- El password ha de tener menos de 16 caracteres (campo PASSWORD 2)\n';
		}
	}
	
	// Verificacion de coincidencia entre el campo 'Password_Votante' y el campo
	// 'Password_Votante2'.
	if ((form.Password_Votante.value != "") && (form.Password_Votante2.value != ""))
	{
		if (form.Password_Votante.value != form.Password_Votante2.value)
		{
			flag = true;
			str = str + '- Los campos PASSWORD y PASSWORD 2 no coinciden\n';
		}
	}
	
	// Verificacion del campo 'Nombre'.
	if (form.Nombre.value == "")
	{
		flag = true;
		str = str + '- Falta el nombre\n';
	}
	else
	{
		if (form.Nombre.value.length >= 25)
		{
			flag = true;
			str = str + '- El nombre ha de tener menos caracteres\n';
		}
	}
	
	// Verificacion del campo 'Apellidos'.
	if (form.Apellidos.value == "")
	{
		flag = true;
		str = str + '- Falta los apellidos\n';
	}
	else
	{
		if (form.Apellidos.value.length >= 25)
		{
			flag = true;
			str = str + '- Los apellidos han de tener menos caracteres\n';
		}
	}
		
	if (flag)
	{
		alert(str);
		return;
	}
	
	form.submit();
}

// Funcion que valida los campos del formulario añadir Administradores en la pagina
// 'adm_usuarios.php'.
function valida_1_Administradores(form)
{
	str = "AVISOS:\n";
	flag = false;
	
	// Verificacion del campo 'Login_Administrador'.
	if (form.Login_Administrador.value == "")
	{
		flag = true;
		str = str + '- Falta el login\n';
	}
	else
	{
		if (form.Login_Administrador.value.length < 3)
		{
			flag = true;
			str = str + '- El login ha de tener al menos 3 caracteres\n';
		}
		if (form.Login_Administrador.value.length > 16)
		{
			flag = true;
			str = str + '- El login ha de tener menos de 16 caracteres\n';
		}
	}
	
	// Verificacion del campo 'Password_Administrador'.
	if (form.Password_Administrador.value == "")
	{
		flag = true;
		str = str + '- Falta el password (campo PASSWORD)\n';
	}
	else
	{
		if (form.Password_Administrador.value.length < 6)
		{
			flag = true;
			str = str + '- El password ha de tener al menos 6 caracteres (campo PASSWORD)\n';
		}
		if (form.Password_Administrador.value.length > 16)
		{
			flag = true;
			str = str + '- El password ha de tener menos de 16 caracteres (campo PASSWORD)\n';
		}
	}
	
	// Verificacion del campo 'Password_Adminstrador2'.
	if (form.Password_Administrador2.value == "")
	{
		flag = true;
		str = str + '- Falta repetir el password (campo PASSWORD 2)\n';
	}
	else
	{
		if (form.Password_Administrador2.value.length < 6)
		{
			flag = true;
			str = str + '- El password ha de tener al menos 6 caracteres (campo PASSWORD 2)\n';
		}
		if (form.Password_Administrador2.value.length > 16)
		{
			flag = true;
			str = str + '- El password ha de tener menos de 16 caracteres (campo PASSWORD 2)\n';
		}
	}
	
	// Verificacion de coincidencia entre el campo 'Password_Administrador' y el campo
	// 'Password_Administrador2'.
	if ((form.Password_Administrador.value != "") && (form.Password_Administrador2.value != ""))
	{
		if (form.Password_Administrador.value != form.Password_Administrador2.value)
		{
			flag = true;
			str = str + '- Los campos PASSWORD y PASSWORD 2 no coinciden\n';
		}
	}
		
	if (flag)
	{
		alert(str);
		return;
	}
	
	form.submit();
}

// Funcion que valida los campos del formulario modificar Votantes en la pagina
// 'adm_usuarios.php'.
function valida_buscador(form)
{
	str = "AVISOS:\n";
	flag = false;
	
	// Verificacion del campo 'buscar'.
	if (form.buscar.value == "")
	{
		flag = true;
		str = str + '- Falta el criterio a buscar\n';
	}
	// Verificacion del campo 'campo'.
	// La condicion de esta sentencia if dara siempre FALSE porque siempre la variable
	// 'campo' tendra un valor.
	if (form.campo.value == "")
	{
		flag = true;
		str = str + '- Falta elegir campo\n';
	}
			
	if (flag)
	{
		alert(str);
		return;
	}
	
	form.submit();
}

function valida_2_5_Votantes(form)
{
	form.submit();
}

function valida_2_5_Administradores(form)
{
	form.submit();
}

function valida_3_7_Votantes(form)
{
	form.submit();
}

function valida_3_7_Administradores(form)
{
	form.submit();
}

function valida_3_8_Encuestas(form)
{
	form.submit();
}

// Funcion que valida los campos del formulario modificar Votantes en la pagina
// "adm_usuarios2.php".
function valida_5_6_Votantes(form)
{
	numero_usuarios = form.numero_usuarios.value;
	str = "AVISOS:\n";
	flag = false;
	
	for (i=1;i<=numero_usuarios;i++)
	{
		// Verificacion del campo 'Login_Votante'.
		if (eval("form.Login_Votante_"+i+".value") == "")
		{
			flag = true;
			str = str + '- Falta el login para el usuario nº '+i+'\n';
		}
		else
		{
			if (eval("form.Login_Votante_"+i+".value.length") < 3)
			{
				flag = true;
				str = str + '- El login para el usuario nº '+i+' ha de tener al menos 3 caracteres\n';
			}
			if (eval("form.Login_Votante_"+i+".value.length") > 16)
			{
				flag = true;
				str = str + '- El login para el usuario nº '+i+' ha de tener menos de 16 caracteres\n';
			}
		}
		
		// Verificacion del campo 'Password_Votante'.
		if (eval("form.Password_Votante_"+i+".value") == "")
		{
			flag = true;
			str = str + '- Falta el password para el usuario nº '+i+'\n';
		}
		else
		{
			if (eval("form.Password_Votante_"+i+".value.length") < 6)
			{
				flag = true;
				str = str + '- El password para el usuario nº '+i+' ha de tener al menos 6 caracteres (campo PASSWORD)\n';
			}
			if (eval("form.Password_Votante_"+i+".value.length") > 16)
			{
				flag = true;
				str = str + '- El password para el usuario nº '+i+' ha de tener menos de 16 caracteres (campo PASSWORD)\n';
			}
		}
		
		// Verificacion del campo 'Nombre'.
		if (eval("form.Nombre_"+i+".value") == "")
		{
			flag = true;
			str = str + '- Falta el nombre para el usuario nº '+i+'\n';
		}
		else
		{
			if (eval("form.Nombre_"+i+".value.length") >= 25)
			{
				flag = true;
				str = str + '- El nombre para el usuario nº '+i+' ha de tener menos caracteres\n';
			}
		}
		
		// Verificacion del campo 'Apellidos'.
		if (eval("form.Apellidos_"+i+".value") == "")
		{
			flag = true;
			str = str + '- Falta los apellidos para el usuario nº '+i+'\n';
		}
		else
		{
			if (eval("form.Apellidos_"+i+".value.length") >= 25)
			{
				flag = true;
				str = str + '- Los apellidos para el usuario nº '+i+' han de tener menos caracteres\n';
			}
		}
	}
			
	if (flag)
	{
		alert(str);
		return;
	}
	
	form.submit();
}

// Funcion que valida los campos del formulario modificar Administradores en la pagina
// "adm_usuarios2.php".
function valida_5_6_Administradores(form)
{
	numero_usuarios = form.numero_usuarios.value;
	str = "AVISOS:\n";
	flag = false;
	
	for (i=1;i<=numero_usuarios;i++)
	{
		// Verificacion del campo 'Login_Administrador'.
		if (eval("form.Login_Administrador_"+i+".value") == "")
		{
			flag = true;
			str = str + '- Falta el login para el usuario nº '+i+'\n';
		}
		else
		{
			if (eval("form.Login_Administrador_"+i+".value.length") < 3)
			{
				flag = true;
				str = str + '- El login para el usuario nº '+i+' ha de tener al menos 3 caracteres\n';
			}
			if (eval("form.Login_Administrador_"+i+".value.length") > 16)
			{
				flag = true;
				str = str + '- El login para el usuario nº '+i+' ha de tener menos de 16 caracteres\n';
			}
		}
		
		// Verificacion del campo 'Password_Administrador'.
		if (eval("form.Password_Administrador_"+i+".value") == "")
		{
			flag = true;
			str = str + '- Falta el password para el usuario nº '+i+'\n';
		}
		else
		{
			if (eval("form.Password_Administrador_"+i+".value.length") < 6)
			{
				flag = true;
				str = str + '- El password para el usuario nº '+i+' ha de tener al menos 6 caracteres (campo PASSWORD)\n';
			}
			if (eval("form.Password_Administrador_"+i+".value.length") > 16)
			{
				flag = true;
				str = str + '- El password para el usuario nº '+i+' ha de tener menos de 16 caracteres (campo PASSWORD)\n';
			}
		}
	}
			
	if (flag)
	{
		alert(str);
		return;
	}
	
	form.submit();
}

function valida_5_6_Encuestas(form)
{
	form.submit();
}

// Funcion que valida los campos de primer formulario de añadir una encuesta en la pagina
// "adm_encuestas3.php"
function valida_1_Encuestas(form)
{
	str = "";
	str = "AVISOS:\n";
	flag = false;

	// Verificacion del campo 'Titulo_Encuesta'.
	if (form.Titulo_Encuesta.value == '')
	{
		flag = true;
		str = str + '- Falta el titulo de la encuesta\n';
	}
	else
	{
		if (form.Titulo_Encuesta.value.length < 5)
		{
			flag = true;
			str = str + '- El titulo de la encuesta ha de tener al menos 5 caracteres\n';
		}
	}
	
	
	dia1 = form.Dia_Inicio.value;
	mes1 = form.Mes_Inicio.value;
	anyo1 = form.Anyo_Inicio.value;
	dia2 = form.Dia_Fin.value;
	mes2 = form.Mes_Fin.value;
	anyo2 = form.Anyo_Fin.value;
	
	// Verificacion que el año del campo 'Fecha_Inicio' no es mayor que el del campo
	// 'Fecha_Fin'.
	if (anyo1 > anyo2)
	{
		flag = true;
		str = str + '- La Fecha de Inicio ha de ser\nmenor a la Fecha de Fin,\ncambie el AÑO\n';
	}
	
	// Verificacion que el mes del campo 'Fecha_Inicio' no es mayor que el del campo
	// 'Fecha_Fin', siempre que coincidan los años.
	if ((anyo1 == anyo2) && (mes1 > mes2))
	{
		flag = true;
		str = str + '- La Fecha de Inicio ha de ser\nmenor a la Fecha de Fin,\ncambie el MES\n';
	}
	
	// Verificacion que el dia del campo 'Fecha_Inicio' no es mayor que el del campo
	// 'Fecha_Fin', siempre que coincidan los años y los meses.
	if ((anyo1 == anyo2) && (mes1 == mes2) && (dia1 > dia2))
	{
		flag = true;
		str = str + '- La Fecha de Inicio ha de ser\nmenor a la Fecha de Fin,\ncambie el DIA\n';
	}
	
	form.Fecha_Inicio.value = anyo1+"/"+mes1+"/"+dia1;
	form.Fecha_Fin.value = anyo2+"/"+mes2+"/"+dia2;
	
	if (flag)
	{
		alert(str);
		return;
	}  

	form.submit();
}

// Funcion que valida los datos de añadir una pregunta en "adm_encuestas2.php".
function valida_5_Encuestas(form)
{
	str = "AVISOS:\n";
	flag = false;
	// Verificacion del campo 'Titulo_Pregunta'.
	if (form.Titulo_Pregunta.value == '')
	{
		flag = true;
		str = str + '- Falta titulo de la pregunta\n';
	}
	else
	{
		if (form.Titulo_Pregunta.value.length < 5)
		{
			flag = true;
			str = str + '- El titulo de la pregunta ha de tener al menos 5 caracteres\n';
		}
	}
	
	// Verificacion del campo 'Numero_Contestaciones'.
	if (form.Numero_Contestaciones.value == '')
	{
		flag = true;
		str = str + '- Falta nº posible Contestaciones\n';
	}
	else if (!es_entero(form.Numero_Contestaciones.value))
	{
		flag = true;
		str = str + '- No es un nº entero\n';
	}
	else if (form.Numero_Contestaciones.value < 2)
	{
		flag = true;
		str = str + '- El nº de Contestaciones ha de ser mayor o igual a 2 \n';
	}
	
	if (flag)
	{
		alert(str);
		return;
	}  

	form.submit();	
}

// Funcion que valida las opciones a añadir a una pregunta en la pagina "adm_encuestas2.php".
function valida_6_Encuestas(form)
{
	numero_Contestaciones = form.Numero_Contestaciones.value;
	str = "AVISOS:\n";
	flag = false;
	
	// Verificacion del campo 'Opcion'.
	for (i=1; i<=numero_Contestaciones; i++)
	{
		if (eval("form.Opcion_"+i+".value") == '')
		{
			flag = true;
			str = str + '- Falta contestacion '+i+'\n';
		}
	}
	
	if (flag)
	{
		alert(str);
		return;
	}  

	form.submit();	
}

// Funcion que valida las opciones a añadir a una pregunta en la pagina "adm_encuestas2.php".
function valida_encuesta(form)
{
	cuantas_Preguntas = form.cuantas_Preguntas.value;
	str = "AVISOS:\n";
	flag1 = false;
	
	// Recorrido de todas las Preguntas.
	for (i=1; i<=cuantas_Preguntas; i++)
	{
		// Esta variable indica si hay una contestacion seleccionada o no dentro de la
		// pregunta.
		// 		false => no hay seleccinada ninguna contestacion.
		//		true => si hay una contestacion seleccionada.
		flag2 = false;
		// Averigua cuantas Contestaciones tiene la pregunta i.
		cuantas_Contestaciones = eval("form.pregunta"+i+".length");
		
		for (j=0; j< cuantas_Contestaciones; j++)
		{	
			// Se mira todas las Contestaciones posibles que tiene la pregunta.
			if (eval("form.pregunta"+i+"["+j+"].checked") == false)
			{
				// La contestacion j no esta seleccionada.
				flag2 = false;
			}
			else
			{
				// La contestacion j esta seleccionada, entonces se sale del if.
				flag2 = true;
				break;
			}
		}
		// Si no hay ninguna contestacion seleccionada se activa la variable flag1 a
		// true para que muestre mensaje de por pantalla.
		if (!flag2)
		{
			flag1 = true;
			str = str + '- Falta contestar la pregunta '+i+'\n';
		}
	}
	
	if (flag1)
	{
		alert(str);
		return;
	}  

	form.submit();	
}

//-->