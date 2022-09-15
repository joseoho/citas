<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html>
<HEAD>
<TITLE> Calendar </TITLE>
<script type="text/javascript" language="javascript">
//CALENDARIO DINAMICO by Mauricio Escobar
//
//Este script y otros muchos pueden
//descarse on-line de forma gratuita
//en El Código: www.elcodigo.com

var strParam = location.search.substr(1);	// string con parametros
var arrayParam = new Array();			// array almacena variable y valores
arrayParam["fecha"] = "";
returnParam();					// llama a la funcion que busca los parametros
var newFecha = arrayParam["fecha"];		// fecha que llega por parametro

//El Codigo - 26/03/2007 - Obtiene nombre de la pagina para que no tenga que ser fijo
var urlcomp = location.href;
var posint = urlcomp.indexOf("?");
var urlpag = '';
if ( posint != -1 )
	urlpag = urlcomp.substr(0, posint);
else
	urlpag = urlcomp;

if(newFecha == undefined || newFecha == "undefined")
	newFecha = "";

function returnParam(){
	var i = 0;		
	var largo = strParam.length;		// largo de los parametros

	while(largo){					// mientras no salga del ciclo
		posIgual = strParam.indexOf("=");	// busca la posicion del =
		posAmp = strParam.indexOf("&");		// busca la posicion del &

		if(posAmp == 0 || posAmp == -1)		// si no encuentra el & lo igual con el largo del string con parametros
			posAmp = strParam.length;			

		if(posIgual != 0 || posIgual != -1){	// si no encuentra el = sale del ciclo
			variable = strParam.substr(0,posIgual);				// nombre variable
			valor = strParam.substr(posIgual + 1,posAmp - posIgual - 1);	// valor variable
			arrayParam[variable] = valor;					// crea un elemento de la matriz en la posicion variable(nombre del parametro) con el valor de esa variable

			if(posAmp >= strParam.length)					// si no quedan parametro sale del ciclo
				break;
			else	
				strParam = strParam.substr(posAmp + 1);	// recorta el string desde donde encuentra el anterior &
		}
		else
			break;						// sale del ciclo si no encuentra el signo =
	}
}

function obtiene_fecha()
   {
   var fecha_actual = new Date()

   dia = fecha_actual.getDate()
   mes = fecha_actual.getMonth() + 1
   anio = fecha_actual.getYear()

   if (anio < 100)
      anio = '19' + anio
   else if ( ( anio > 100 ) && ( anio < 999 ) ) {
   
      var cadena_anio = new String(anio)
      anio = '20' + cadena_anio.substring(1,3)
   }      

   if (mes < 10)
      mes = '0' + mes

   if (dia < 10)
      dia = '0' + dia

   return (dia + "/" + mes + "/" + anio)
   }

function poneCero(strNum){
	var str = new String();
	str = strNum;
	if(strNum.length == 1)
		str = '0' + strNum;
	return strNum;
}

function poneAnio(anio){
   if (anio < 100)
      anio = '19' + anio
   else if ( ( anio >= 100 ) && ( anio < 999 ) ) {
      var cadena_anio = new String(anio)
      anio = '20' + cadena_anio.substring(1,3)
   }      
   return anio;
}

function poneMes(mes){
  var strMes;
	if(parseInt(mes) == 1) strMes = "Enero";
	if(parseInt(mes) == 2) strMes = "Febrero";
	if(parseInt(mes) == 3) strMes = "Marzo";
	if(parseInt(mes) == 4) strMes = "Abril";
	if(parseInt(mes) == 5) strMes = "Mayo";
	if(parseInt(mes) == 6) strMes = "Junio";
	if(parseInt(mes) == 7) strMes = "Julio";
	if(parseInt(mes) == 8) strMes = "Agosto";	
	if(parseInt(mes) == 9) strMes = "Septiembre";
	if(parseInt(mes) == 10) strMes = "Octubre";
	if(parseInt(mes) == 11) strMes = "Noviembre";
	if(parseInt(mes) == 12) strMes = "Diciembre";
  return strMes;
}

//***********************************
// Crea un fecha  a partir de una dada
// op  :
//		1 crea fecha mes anterior
//		2 crea fecha anio anterior
//		3 crea fecha mes siguiente
//		4 crea fecha anio siguiente
//*********************************

function creaFecha(mes,anio,op){
  var strFecha;
	if(op == 1){
		if(mes == 1){
			mes = 12;
			anio--;
		}
		else
			mes--;
		strFecha = mes + "/1/" + anio;
	}

	if(op == 2){
		anio--;
		strFecha = mes + "/1/" + anio;
	}

	if(op == 3){
		if(mes == 12){
			mes = 1;
			anio++;
		}
		else
			mes++;
		strFecha = mes + "/1/" + anio;
	}

	if(op == 4){
		anio++;
		strFecha = mes + "/1/" + anio;
	}
	return strFecha;
}

function calendario()
   	{

	if (newFecha != "")
		var fecha_actual = new Date(arrayParam["fecha"]);		
	else
		var fecha_actual = new Date(); 


	var dia_mes = fecha_actual.getDate()		//dia del mes
	var mes = fecha_actual.getMonth() + 1		//mes del año
	var anio = fecha_actual.getYear()		//año
	var dia_semana = fecha_actual.getDay() - 1	//dia de la semana (-1 para domingo, 0 para lunes, etc.)
	var x, y, fila, valor

	//array de dias que tiene cada mes
	dias_por_mes = new Array(12)
	dias_por_mes[0] = 31
	dias_por_mes[1] = 28
	dias_por_mes[2] = 31
	dias_por_mes[3] = 30
	dias_por_mes[4] = 31
	dias_por_mes[5] = 30
	dias_por_mes[6] = 31
	dias_por_mes[7] = 31
	dias_por_mes[8] = 30
	dias_por_mes[9] = 31
	dias_por_mes[10] = 30
	dias_por_mes[11] = 31

	//corrige dia de la semana
	if(dia_semana == -1) 
		dia_semana = 6

	//corrige dias de febrero si año bisiesto
	if((anio % 4) == 0) 
		dias_por_mes[1]++

	//crea matriz de datos
	matriz = new Array(6)
	for (fila = 0; fila < 6; fila++) 
		matriz[fila] = new Array(7)

	//obtiene posición día 1
	y = dia_semana + 1
	for (x = dia_mes; x > 0; x--) {
		y--	
		if (y < 0) 
			y = 6
	}
		
	//guarda valores en variable matriz
	valor = 1
	for (fila = 0; fila < 6; fila++) {
		for (x = 0; x < 7; x++) {
			if ((fila == 0) && (x < y)) {				//valores vacíos primera fila
				matriz[fila][x] = ""
			} else if (valor > dias_por_mes[mes - 1]) {		//valores vacíos última línea
				matriz[fila][x] = ""
			} else if (valor == dia_mes) {				//valor día actual
				matriz[fila][x] = valor 			// "<font color='#FF0000'><strong>" + valor + "</strong></font>"
				valor++
			} else {
				matriz[fila][x] = valor				//valores ocupados
				valor++
			}
		}
	}

	//impresion del calendario
	document.write("<div align='center'><center>")
	document.write("")
	document.write("<table border='0' width='50%' cellspacing='0' cellpadding='0' bgcolor=white>")
	document.write("  <tr>")
	document.write("    <td  align='center'><strong>" + poneMes(mes) + " " + poneAnio(anio) + "</strong></td>")
	document.write("  </tr>")
	document.write("</table>")
	document.write("</center></div>")

	document.write("<div align='center'><center>")
	document.write("")
	document.write("<table border='1' width='50%' cellspacing='0' cellpadding='0' bgcolor=white>")
	document.write("  <tr>")												//crea fila de nombres de días
	document.write("    <td width='1%' align='center'><font color=#444444 size=2 face=verdana>Lun</font></td>")
	document.write("    <td width='1%' align='center'><font color=#444444 size=2 face=verdana>Mar</font></td>")
	document.write("    <td width='1%' align='center'><font color=#444444 size=2 face=verdana>Mie</font></td>")
	document.write("    <td width='1%' align='center'><font color=#444444 size=2 face=verdana>Jue</font></td>")
	document.write("    <td width='1%' align='center'><font color=#444444 size=2 face=verdana>Vie</font></td>")
	document.write("    <td width='1%' align='center' bgcolor='#ffffff'><font color=#444444 size=2 face=verdana>Sab</font></td>")
	document.write("    <td width='1%' align='center' bgcolor='#ffffff'><font color=#444444 size=2 face=verdana>Dom</font></td>")
	document.write("  </tr>")

	for(fila = 0; fila < 6; fila++) {
		if ((matriz[fila][0] == "") && (matriz[fila][6] == "")) 		//no muestra ultima fila vacía
			break
		document.write("  <tr>")											//crea fila de tabla calendario
		document.write("    <td width='1%' align='right'><a href=JavaScript:AsignarValor('"+ poneCero(matriz[fila][0]) + "/" + poneCero(mes) + "/" + poneAnio(anio) + "');><font color=#444444 size=2 face=verdana>" + matriz[fila][0] + "</font></a>&nbsp;</td>");
		document.write("    <td width='1%' align='right'><a href=JavaScript:AsignarValor('"+ poneCero(matriz[fila][1]) + "/" + poneCero(mes) + "/" + poneAnio(anio) + "');><font color=#444444 size=2 face=verdana>" + matriz[fila][1] + "</font></a>&nbsp;</td>");
		document.write("    <td width='1%' align='right'><a href=JavaScript:AsignarValor('"+ poneCero(matriz[fila][2]) + "/" + poneCero(mes) + "/" + poneAnio(anio) + "');><font color=#444444 size=2 face=verdana>" + matriz[fila][2] + "</font></a>&nbsp;</td>");
		document.write("    <td width='1%' align='right'><a href=JavaScript:AsignarValor('"+ poneCero(matriz[fila][3]) + "/" + poneCero(mes) + "/" + poneAnio(anio) + "');><font color=#444444 size=2 face=verdana>" + matriz[fila][3] + "</font></a>&nbsp;</td>");
		document.write("    <td width='1%' align='right'><a href=JavaScript:AsignarValor('"+ poneCero(matriz[fila][4]) + "/" + poneCero(mes) + "/" + poneAnio(anio) + "');><font color=#444444 size=2 face=verdana>" + matriz[fila][4] + "</font></a>&nbsp;</td>");
		document.write("    <td width='1%' align='right'><a href=JavaScript:AsignarValor('"+ poneCero(matriz[fila][5]) + "/" + poneCero(mes) + "/" + poneAnio(anio) + "');><font color=#444444 size=2 face=verdana>" + matriz[fila][5] + "</font></a>&nbsp;</td>");
		document.write("    <td width='1%' align='right' bgcolor='#ee0000'><a href=JavaScript:AsignarValor('"+ poneCero(matriz[fila][6]) + "/" + poneCero(mes) + "/" + poneAnio(anio) + "');><font color=#ffffff size=2 face=verdana>" + matriz[fila][6] + "</font></a>&nbsp;</td>");
		document.write("  </tr>")
	}
	document.write("</table>")
	document.write("</center></div>")

	document.write("<div align='center'><center>")
	document.write("<form>")
	document.write("<table border='0' width='15%' cellspacing='0' cellpadding='0' bgcolor=white>")
	document.write("  <tr>")											//crea fila de tabla calendario
	document.write("    <td width='25%' align='center'><input type=button name=b value='<<' OnClick=\"location.href='" + urlpag + "?fecha=" + escape(creaFecha(mes,poneAnio(anio),2)) + "';\"></td>");
	document.write("    <td width='25%' align='center'><input type=button value=' < ' OnClick=\"location.href='" + urlpag + "?fecha=" + escape(creaFecha(mes,poneAnio(anio),1)) + "';\"></td>");
	document.write("    <td width='25%' align='center'><input type=button value=' > ' OnClick=\"location.href='" + urlpag + "?fecha=" + escape(creaFecha(mes,poneAnio(anio),3)) + "';\"></td>");
	document.write("    <td width='25%' align='center'><input type=button value='>>' OnClick=\"location.href='" + urlpag + "?fecha=" + escape(creaFecha(mes,poneAnio(anio),4)) + "';\"></td>");
	document.write("  </tr>")
//	document.write("<tr><td colspan=4 align=center><a href='JavaScript:window.close();'><font color=#444444 size=2 face=verdana>Cerrar Ventana</font></a></td></tr>")
	document.write("</table>")
	document.write("</form>")
	document.write("</center></div>")
}

function AsignarValor(fecSelect){
	opener.document.registro['fe_gravamen'].fecha.value = fecSelect	// aqui puede ser asignada a algun campo
}
</script>

</HEAD>

<BODY><!-- Para visualizar el calendario -->
<script type="text/javascript" language="javascript">
	calendario()
</script>



</BODY>
</HTML>
