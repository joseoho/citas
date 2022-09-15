<?php
/***********************************************************************
 * Ejemplo:
 <?php 
 $anterior = "anterior.php";
 $siguiente = "siguiente.php";
 include("barra_imprimir_pie.php"); 
 
 ************************************************************************/
 ?>

<script language="JavaScript">
function printfun(){
IE = window.navigator.appName.toLowerCase().indexOf("micro") != -1; //se determina el tipo de  navegador
(IE)?sColl = "all.":sColl = "getElementById('";
(IE)?sStyle = ".style":sStyle = "').style";
eval("document." + sColl + "printf" + sStyle + ".display = 'none';"); //se ocultan los botones
print(); //se llama el dialogo de impresión
eval("document." + sColl + "printf" + sStyle + ".display = '';"); // se muestran los botones nuevamente
}
   document.onkeydown = function(){
    if(window.event && window.event.keyCode == 122){
     window.event.keyCode = 505;
    }
    if(window.event && window.event.keyCode == 505){ 
     return false;
    }
   }
</script>
<div id="printf" name="printf" style="display:'';" align="left">
  <?php
	if (!isset($N_numeroDePaginas)) 
		$N_numeroDePaginas = 0;
    echo "<form name='enviar' action='' method='POST'>";
	echo "<input type='hidden' name='pagina'>";
	if ($N_numeroDePaginas > 1){
		echo"<p class='InputDataTextPeq'><b>P&aacute;ginas Resultado de la Consulta</b></p>\n";
		echo "<table width='100%' align='center' border='0' bordercolor='#FFFFFF' cellspacing='0'>\n";		
		$a=0;
		for ($i=1;$i<=$N_numeroDePaginas;$i++){ 		
			if ($a==0)
				echo "<tr class='InputDataTextPeq' valign='top' bordercolordark='#FFFFFF' bordercolor='#000000' bgcolor='#CCCCCC'>\n
				<td align='center' bgcolor='#CCCCCC'>";
		    $a++;
			if ($N_pagina == $i)
	  			echo "<font size='-1'><b>&nbsp;$i&nbsp;</b></font>\n"; 
			else	
				echo "<font style='cursor:hand' size='-2' onClick='paginar($i)'>&nbsp;<u>$i</u>&nbsp;</font>";
		   if($a==25){echo "</td></tr>\n"; $a=0;}
		}
    	echo "</table> ";
	 }

	//echo"<br><br>\n";
	//Anterior Principal
	echo "<table align='left'>\n";
	echo "<tr>\n";
	if(isset($anterior))
	echo "<td><input name='regresar'  type='button'  value='<< Regresar' onclick=window.location='" . $anterior . "'></td>";
	else
	echo "<td><input name='regresar'  type='button'  disabled value='<< Regresar'></td>";
    if(isset($siguiente))
	echo "<td align='center'><input name='reg' type='button' value='Continuar >>' onClick=window.location='" . $siguiente . "'></td>\n";
	else
	echo "<td align='center'><input name='reg' type='button' disabled value='Continuar >>'></td>\n";
	echo "<td width='150'>&nbsp</td>";
	echo "<td><input type='button' name='impimir1' value='    Imprimir    ' onClick='javascript:printfun()'></td>";
	echo "<td><input name='cerrar1' type='button' id='cerrar12' onClick='javascript:window.close();' value='      Cerrar      '></td>";

	echo "</tr>\n";
	echo "</table>\n";
	echo "</form>\n";

?>

</div>