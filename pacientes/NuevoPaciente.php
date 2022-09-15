<?php 
session_start();
error_reporting(0);
$id_usu = $_SESSION['id_usu'];
$usuario = $_SESSION['usuario'];
include('../libreria/validaciones.php');
$fecha = time();
$cn = conectarse();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SISTEMA  E-MAREG</title>
<link href="../libreria/sistema.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<table width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="2"><img src="../images/BANNER.jpg" width="850" height="110" /></td>
  </tr>
  <tr>
    <td height="30" width="200" class="item">&nbsp;<?php echo $usuario; ?></td>
    <td width="650" align="right" class="item"><?php echo FechaFormateada($fecha);?></td>
  </tr>
  <tr>
    <td height="753" valign="top"><?php include('../plantillas/opc_marco.php'); ?></td>
    <td valign="top"> 
      <!-- Inicio Contenido -->
      <script type="text/javascript" src="../libreria/validaciones.js"></script>
  <link rel="stylesheet" type="text/css" media="all" href="../libreria/jscalendar-1.0/calendar-blue.css" title="win2k-cold-1" />
  <script type="text/javascript" src="../libreria/jscalendar-1.0/calendar.js"></script>
  <script type="text/javascript" src="../libreria/jscalendar-1.0/lang/calendar-es.js"></script>
  <script type="text/javascript" src="../libreria/jscalendar-1.0/calendar-setup.js"></script>

<?php 
if($_POST['enviar']=="Enviar"){
$campos = array('medico','digna','cedula','digr','nomb1','apell1','coda1','tele1','coda2','tele2','mail');
$idmedico = $_POST['medico'];
$fecharegistro = $_POST['fe_homol2'];
$cod_rif = $_POST['digna'];
$numero_rif = $_POST['cedula'];
$digito_rif = $_POST['digr'];
$nombre1 = $_POST['nomb1'];   
$nombre2 = $_POST['nomb2'];
$apellido1 = $_POST['apell1'];
$apellido2 = $_POST['apell2'];
$av = $_POST['aven'];
$urb = $_POST['urba'];
$edificio = $_POST['edif'];
$piso = $_POST['piso'];
$apto = $_POST['numapto'];
$coes = $_POST['coedo'];
$ciudad = $_POST['ciudad'];
$parroquia = $_POST['muni'];
$cod1 = $_POST['coda1']; 
$tel1 = $_POST['tele1'];          
$cod2 = $_POST['coda2'];
$tel2 = $_POST['tele2'];
$correo = $_POST['mail'];
$fe_naci = $_POST['fe_homol'];
$postal = $_POST['postal'];

?>
 <?php
 if(validarCamposRequeridos($campos) != 0){  
 ?>
 		<script>
		alert ("Los campos marcados con * son obligatorios !!!");
		document.location='NuevoPaciente.php';
		</script>
	
	
	<?php
	}else{

$sqlI = "INSERT INTO pacientes (ID_MEDICO,FECHA_REGISTO,DIG_NAC,CEDULA,DIG_RIF,NOMP1,NOMP2,APEP1,APEP2,AVENIDA,URB,EDIFICIO,PISO,APTO,CO_EDO,CIUDAD,PARROQUIA,COD_AREA1,TEL1,COD_AREA2,TEL2,CORREO,FECHA_NACIMIENTO,POSTAL) 
		VALUES ('$idmedico','$fecharegistro','$cod_rif','$numero_rif','$digito_rif','$nombre1','$nombre2','$apellido1','$apellido2','$av','$urb','$edificio','$piso','$apto','$coes,','$ciudad','$parroquia','$cod1','$tel1','$cod2','$tel2','$correo','$fe_naci','$postal')";
		//******************************
			
$resulta = mysql_query($sqlI, $cn);
 ?>
  		<script>
		alert ("Se almaceno el Paciente correctamente !!!");
		document.location='NuevoPaciente.php';
		</script>
      <?php 
  }}else
  {
  ?>
      <form name="pacientes" method="post" action="NuevoPaciente.php">
        <table width="600" cellspacing="2" cellpadding="1" bgcolor="#8F8F8F" align="center">
          <tr> 
            <td class="titulotabla">REGISTRO DE PACIENTES</td>
          </tr>
          <tr> 
            <td> <table width="594" cellspacing="3" cellpadding="2" align="center" bgcolor="#FFFFFF">
                <tr> 
                  <td width="83" height="37" class="item"> <p>Registro 
                      <?php 
$sq="select id_paciente from pacientes order by id_paciente desc";
$resul = mysql_query($sq, $cn);	
$num_reg = mysql_num_rows($resul);
if($num_reg <=0){
$correlativo = "1";
}else{
$row = mysql_fetch_array($resul);
$correlativo = $row['id_paciente']+1;
}
?>
                      <input name="idmed" type="text" class="input" value="<?php echo $correlativo; ?>" size="3" readonly="true" />
                      <br />
                    </p></td>
                  <td width="126" class="item"><p>&nbsp; </p></td>
                  <td width="200" class="item"><p>Fecha Registro 
                      <input size="13" type="text" name="fe_homol2" id="calendar4" readonly="1" class="input"/>
                      <img src="../libreria/jscalendar-1.0/img.gif" width="18" height="14" id="f_trigger_f" style="cursor: pointer; border: 1px solid blue;" title="Date selector"onmouseover="this.style.background='blue';" onmouseout="this.style.background=''" /> 
                    </p></td>
                  <td width="152" class="item">&nbsp;</td>
                </tr>
                <tr> 
                  <td colspan="4" class="item">Medico<span class="Estilo2">*</span>
                    <?php 
						$sql = "select * from medico ";
						$rs = mysql_query($sql, $cn);	
?>
                    <select name="medico" class="input">
                      <option value = "">Elegir</option>
                      <?php 
		while ($roww=mysql_fetch_array($rs)) {
		$idmedico = $roww['ID_MEDICO'];
		$nombre = $roww['NOM1']." ".$roww['NOM2']." ".$roww['APE1']." ".$roww['APE2'];
		?>
                      <option value="<?php  echo $idmedico;?>"><?php echo $nombre;?></option>
                      <?php 
		}
		?>
                    </select></td>
                </tr>
                <tr> 
                  <td colspan="4" class="item"> <span class="item"> 
                    <hr />
                    Cedula de Identidad / R.I.F.<span class="Estilo2">*</span>  
                    <select name="digna" class="input">
                      <option value="J">J</option>
                      <option value="G">G</option>
                      <option value="V">V</option>
                      <option value="E">E</option>
                      <option value="P">P</option>
                    </select>
                    <input name="cedula" type="text"  size="10" maxlength="8" class="input" onblur="javascript:justnumber('pacientes','cedula')" />
                    <input name="digr" type="text"  size="1" maxlength="1" class="input" onblur="javascript:justnumber('pacientes','digr')" />
                    </span></td>
                </tr>
                <tr> 
                  <td colspan="2" class="item">Primer Nombre <span class="Estilo2">*</span><input name="nomb1" type="text" class="input" onchange="cambiaMayuscula('pacientes', 'nomb1')" size="40" maxlength="30" /></td>
                  <td colspan="2" class="item">Segundo Nombre <br /> <input name="nomb2" type="text" class="input" onchange="cambiaMayuscula('pacientes', 'nomb2')" size="40" maxlength="30" /></td>
                </tr>
                <tr> 
                  <td colspan="2" class="item">Primer Apellido <span class="Estilo2">*</span><input name="apell1" type="text" class="input" onchange="cambiaMayuscula('pacientes', 'apell1')" size="40" maxlength="30" /></td>
                  <td colspan="2" class="item">Segundo Apellido<br /> <input name="apell2" type="text" class="input" onchange="cambiaMayuscula('pacientes', 'apell2')" size="40" maxlength="30" /></td>
                </tr>
                <tr> 
                  <td colspan="2" class="item">Calle/avenida/plaza/esquina<br /> 
                    <input name="aven" type="text" class="input" onchange="cambiaMayuscula('pacientes', 'aven')" size="40" maxlength="30" /></td>
                  <td colspan="2" class="item">Urbanizaci&oacute;n o barrio <br /> 
                    <input name="urba" type="text" class="input" onchange="cambiaMayuscula('pacientes', 'urba')" size="40" maxlength="30" /></td>
                </tr>
                <tr> 
                  <td height="35" colspan="2" class="item">Nombre del Edificio/casa/quinta<br /> 
                    <input name="edif" type="text" class="input" onchange="cambiaMayuscula('pacientes', 'edif')" size="40" maxlength="30" /> 
                  </td>
                  <td class="item">Numero de piso<br /> <input name="piso" type="text" class="input" onchange="cambiaMayuscula('pacientes', 'piso')" size="10" maxlength="6" /> 
                  </td>
                  <td class="item">Numero de apartamento <br /> <input name="numapto" type="text" class="input" onchange="cambiaMayuscula('pacientes', 'numapto')" size="10" maxlength="4" /></td>
                </tr>
                <tr> 
                  <td height="38" colspan="2" class="item">Estado<br /> 
                    <?php 
						$sql = "select ID_ESTADOS,CO_ESTADOS,DESCRIPCION from estados ";
						$rs = mysql_query($sql, $cn);	
?>
                    <select name="coedo" class="input" >
                      <?php 
		while ($row=mysql_fetch_array($rs)) {
		$coes = $row['CO_ESTADOS'];
		$desc = $row['DESCRIPCION'];
		?>
                      <option value="<?php echo $coes; ?>"><?php echo $desc;?></option>
                      <?php 
		}
		?>
                    </select> </td>
                  <td class="item"> Ciudad<br /> <input name="ciudad" type="text" class="input" onchange="cambiaMayuscula('pacientes', 'ciudad')" size="40" maxlength="30" /> 
                  </td>
                  <td class="item">Municipio/parroquia<br /> <input name="muni" type="text" class="input" onchange="cambiaMayuscula('pacientes', 'muni')" size="30" maxlength="25" /> 
                  </td>
                </tr>
                <tr> 
                  <td colspan="2" class="item">Telefono/Celular <span class="Estilo2">*</span><br /> <input name="coda1" type="text" class="input" onblur="javascript:justnumber('pacientes','coda1')" size="6" maxlength="4" /> 
                    <input name="tele1" type="text" class="input" onblur="javascript:justnumber('pacientes','tele1')" size="12" maxlength="8" /> 
                  </td>
                  <td class="item">Telefono/Celular <span class="Estilo2">*</span><br /> <input name="coda2" type="text" class="input" onblur="javascript:justnumber('pacientes','coda2')" size="6" maxlength="4" /> 
                    <input name="tele2" type="text" class="input" onblur="javascript:justnumber('pacientes','tele2')" size="12" maxlength="8" /> 
                  </td>
				  <td class="item">Correo Electronico <span class="Estilo2">*</span><br /> <input name="mail" type="text" class="input" id="mail" onblur="emailValido(mail,mail)" size="30" maxlength="30" /> 
                  </td>
                  <tr> 
                  <td height="40" colspan="2" class="item"><p>Fecha Nacimiento 
                      <input size="13" type="text" name="fe_homol" id="calendar5" readonly="1" class="input"/>
                      <img src="../libreria/jscalendar-1.0/img.gif" width="18" height="14" id="f_trigger_g" style="cursor: pointer; border: 1px solid blue;" title="Date selector"onmouseover="this.style.background='blue';" onmouseout="this.style.background=''" /><br />
                    </p></td>
                  <td class="item">Codigo Postal <br /> <input name="postal" type="text" class="input" onblur="javascript:justnumber('pacientes','postal')" size="12" maxlength="8" /></td>
                  <td class="item">&nbsp; </td>
                </tr>
                <tr> 
                  <td colspan="2" class="item"></td>
                  <td class="item"></td>
                  <td class="item"></td>
                </tr>
                <tr> 
                  <td colspan="4" align="center"><input name="volver" type="button" value="Volver" class="subtitulo" onclick="history.go(-1)" />
                    <input name="enviar" type="submit" value="Enviar" class="subtitulo" /></td>
				  
                </tr>
				    <td colspan="6" ><span class="item Estilo2">Los campos marcados con * son obligatorios</span></td>

              </table></td>
          </tr>
        </table>
		<?php
 ?>

         </form>
		 <script type="text/javascript">
    Calendar.setup({
        inputField     :    "calendar4",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "f_trigger_f",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });
</script>

	  <script type="text/javascript">
    Calendar.setup({
        inputField     :    "calendar5",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "f_trigger_g",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });
</script>
	  <?php
}
?>
      <!-- Fin Contenido -->
    </td>
  </tr>
</table>
</body>
</html>