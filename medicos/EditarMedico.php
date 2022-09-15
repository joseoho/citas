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
    <td valign="top"><?php include('../plantillas/opc_marco.php'); ?></td>
    <td valign="top">
	<!-- Inicio Contenido -->
  <script type="text/javascript" src="../libreria/validaciones.js"></script>
  <link rel="stylesheet" type="text/css" media="all" href="../libreria/jscalendar-1.0/calendar-blue.css" title="win2k-cold-1" />
  <script type="text/javascript" src="../libreria/jscalendar-1.0/calendar.js"></script>
  <script type="text/javascript" src="../libreria/jscalendar-1.0/lang/calendar-es.js"></script>
  <script type="text/javascript" src="../libreria/jscalendar-1.0/calendar-setup.js"></script>

<?php 
if($_POST['enviar']=="Actualizar"){
$campos = array('coesp','digna','cedula','digr','nomb1','apell1','coda1','tele1','coda2','tele2','mail');
$entidad = $_POST['coent1'];
$coe = $_POST['coesp'];
$cod_rif = $_POST['digna'];
$numero_rif = $_POST['cedula'];
$digito_rif = $_POST['digr'];
$nombre1 = $_POST['nomb1'];   
$nombre2 = $_POST['nomb2'];
$apellido1 = $_POST['apel1'];
$apellido2 = $_POST['apel2'];
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
$idmed = $_POST['idmed'];


$sqlU = "UPDATE medico SET CO_ESPECIALIDAD='$coe',DIG_NAC='$cod_rif',CEDULA='$numero_rif',
		DIG_RIF='$digito_rif',NOM1='$nombre1',NOM2='$nombre2',APE1='$apellido1',APE2='$apellido2',AVENIDA='$av',URB='$urb',
		EDIFICIO='$edificio',PISO='$piso',APTO='$apto',CO_EDO='$coes',CIUDAD='$ciudad',PARROQUIA='$parroquia',
		COD_AREA1='$cod1',TEL1='$tel1',COD_AREA2='$cod2',TEL2='$tel2',CORREO='$correo',FECHA_NACIMIENTO='$fe_naci',POSTAL='$postal' WHERE ID_MEDICO = '$idmed'";
$rs2 = mysql_query($sqlU, $cn);
 ?>
  		<script>
		alert ("Se actualizo el Medico correctamente !!!");
		document.location='EditarMedico.php';
		</script>
<?php 

}else if(isset($_GET['med'])){
$id_med=$_GET['med'];
//SELECT medico.*,especialidad.DESCRIPCION from medico, especialidad where medico.ID_MEDICO='31' AND medico.CO_ESPECIALIDAD=especialidad.CO_ESPECIALIDAD
$sq="SELECT medico.*,especialidad.DESCRIPCION FROM medico, especialidad WHERE medico.ID_MEDICO='$id_med' AND medico.CO_ESPECIALIDAD=especialidad.CO_ESPECIALIDAD ";
//$sq="SELECT medico.DIG_NAC, medico.CEDULA,medico.DIG_RIF, medico.NOM1, medico.NOM2, medico.APE1, medico.APE2, medico.AVENIDA, medico.URB,medico.EDIFICIO, medico.PISO, medico.APTO, medico.CO_EDO, medico.CIUDAD, medico.PARROQUIA, medico.COD_AREA1, medico.TEL1, medico.COD_AREA2,medico.TEL2,medico.FECHA_NACIMIENTO, medico.POSTAL,especialidad.co_especialidad FROM medico WHERE medico.ID_MEDICO=$id_pro and medico.co_especialidad=especialidad.co_especialidad";
//$sq="select medico.CEDULA,medico.NOM1,medico.APE1 FROM medico where medico.ID_MEDICO='$id_med'";

$resul = mysql_query($sq, $cn);	
$roww= mysql_fetch_array($resul);

?>
<form name="editar" method="post" action="EditarMedico.php">
<table width="600" cellspacing="2" cellpadding="1" bgcolor="#8F8F8F" align="center">
  <tr>
            <td class="titulotabla">REGISTRO DE MEDICO</td>
  </tr>
  <tr>
    <td>
	
<table width="600" cellspacing="3" cellpadding="2" align="center" bgcolor="#FFFFFF">
<tr> 
                  <td width="208" class="item">Entidad 
                    <?php 
					
$sq="select co_entidad, descripcion from entidad order by co_entidad desc";
$resul = mysql_query($sq, $cn);					
$row = mysql_fetch_array($resul);
$entidad = $row['co_entidad'];
$des = $row['descripcion'];
?>
                    <input name="coent" type="text" class="input" value="<?php echo $row['descripcion']; ?>" size="30" readonly="true" /> 
                    <input name="coent1" type="hidden" value="<?php echo $entidad; ?>" /></td>
                  <td width="16" class="item">&nbsp; 
                  <td width="179" class="item">Especialidad *<br>
                    <?php 
						$sql = "select * from especialidad";
						$rs = mysql_query($sql, $cn);	
?>
                    <select name="coesp" class="input" >
                      <?php 
		while ($rows=mysql_fetch_array($rs)) {
		$idespecial = $rows['ID_ESPECIALIDAD'];
		$coe = $rows['CO_ESPECIALIDAD'];
		$desc = $rows['DESCRIPCION'];
		if ($coe == $roww['CO_ESPECIALIDAD']){
				?>	
                      <option value="<?php echo $coe; ?>" selected="selected"><?php echo $desc;?></option>
	
		<?php
		}else{
			 ?>	<option value="<?php echo $coe; ?>"><?php echo $desc;?></option>
        <?php 
		}
		}
		
				?>
                    </select>
                  </td>
                  <td width="164" class="item"><input name="idmed" type="HIDDEN" value="<?php echo $id_med; ?>" />
                </tr>
                <tr> 
                  <td colspan="4" class="item">	<span class="item">
	<hr />
                    Cedula de Identidad / R.I.F. *<br> 
                    <select name="digna" class="input" id="digna">
                      <option value="J" <?php if($roww['DIG_NAC']=='J') echo "selected"; ?>>J</option>
                      <option value="G" <?php if($roww['DIG_NAC']=='G') echo "selected"; ?>>G</option>
                      <option value="V" <?php if($roww['DIG_NAC']=='V') echo "selected"; ?>>V</option>
                      <option value="E" <?php if($roww['DIG_NAC']=='E') echo "selected"; ?>>E</option>
                      <option value="P" <?php if($roww['DIG_NAC']=='P') echo "selected"; ?>>P</option>
                    </select> &nbsp; <input name="cedula" type="text" class="input" id="cedula" onblur="javascript:justnumber('editar','cedula')" value="<?php echo $roww['CEDULA']; ?>" size="10" maxlength="8"> 
                    &nbsp; <input name="digr" type="text" class="input" id="digr" onblur="javascript:justnumber('editar','digr')" value="<?php echo $roww['DIG_RIF']; ?>" size="1" maxlength="1"></td>
                </tr>
                <tr> 
                  <td colspan="2" class="item">Primer Nombre *<br> <input name="nomb1" type="text" class="input" id="nomb1" onChange="cambiaMayuscula('editar', 'nomb1')" value="<?php echo $roww['NOM1']; ?>" size="40" maxlength="30"></td>
                  <td colspan="2" class="item">Segundo Nombre <br> <input name="nomb2" type="text" class="input" id="nomb2" onChange="cambiaMayuscula('editar', 'nomb2')" value="<?php echo $roww['NOM2']; ?>" size="40" maxlength="30"></td>
                </tr>
                <tr> 
                  <td colspan="2" class="item">Primer Apellido *<br> <input name="apel1" type="text" class="input" id="apel1" onChange="cambiaMayuscula('editar', 'apel1')" value="<?php echo $roww['APE1']; ?>" size="40" maxlength="30"></td>
                  <td colspan="2" class="item">Segundo Apellido<br> <input name="apel2" type="text" class="input" id="apel2" onChange="cambiaMayuscula('editar', 'apel2')" value="<?php echo $roww['APE2']; ?>" size="40" maxlength="30"></td>
                </tr>
                <tr> 
                  <td colspan="2" class="item">Calle/avenida/plaza/esquina<br> 
                    <input name="aven" type="text" class="input" id="aven" onChange="cambiaMayuscula('editar', 'aven')" value="<?php echo $roww['AVENIDA']; ?>" size="40" maxlength="30"></td>
                  <td colspan="2" class="item">Urbanizaci&oacute;n o barrio <br> 
                    <input name="urba" type="text" class="input" id="urba" onChange="cambiaMayuscula('editar', 'urba')" value="<?php echo $roww['URB']; ?>" size="40" maxlength="30"></td>
                </tr>
                <tr> 
                  <td colspan="2" class="item">Nombre del Edificio/casa/quinta<br> 
                    <input name="edif" type="text" class="input" id="edif" onChange="cambiaMayuscula('editar', 'edif')" value="<?php echo $roww['EDIFICIO']; ?>" size="40" maxlength="30"> 
                  </td>
                  <td width="179" class="item">Numero de piso<br> <input name="piso" type="text" size="10" maxlength="6" value="<?php echo $roww['PISO']; ?>" class="input" onChange="cambiaMayuscula('editar', 'piso')"> 
                  </td>
                  <td width="164" class="item">Numero de apartamento<br> <input name="numapto" type="text" class="input" id="numapto" onChange="cambiaMayuscula('editar', 'numapto')" value="<?php echo $roww['APTO']; ?>" size="10" maxlength="4"></td>
                </tr>
                <tr> 
                  <td colspan="2" class="item">Estado 
                    <?php 
$sql = "SELECT * FROM estados ";
$rs = mysql_query($sql, $cn);	
?>
                                 <select name="coedo" class="input" >
                      <?php 
		while ($rows=mysql_fetch_array($rs)) {
		$co = $rows['CO_ESTADOS'];
		$desc = $rows['DESCRIPCION'];
		if ($co == $roww['CO_EDO']){
		?>
				<option value="<?php echo $co; ?>" selected="selected"><?php echo $desc;?></option>
		<?php
		}else{
			 ?>	<option value="<?php echo $co; ?>"><?php echo $desc;?></option>
        <?php 
		}
		}
		
	
		?>
                    </select>
          </td>
                  <td class="item">Ciudad<br>
                    <input name="ciudad" type="text" size="30" maxlength="30" value="<?php echo $roww['CIUDAD']; ?>" class="input" onchange="cambiaMayuscula('editar', 'ciudad')" /></td>
                  <td class="item">Municipio/parroquia<br>
                    <input name="muni" type="text" class="input" id="muni2" onchange="cambiaMayuscula('editar', 'muni')" value="<?php echo $roww['PARROQUIA']; ?>" size="30" maxlength="25" /></td>
                </tr>
                <tr> 
                  <td width="208" class="item">Telefono/celular *<br> <input name="coda1" type="text" class="input" id="coda1" onblur="javascript:justnumber('editar','coda1')" value="<?php echo $roww['COD_AREA1']; ?>" size="6" maxlength="4" /> 
                    <input name="tele1" type="text" class="input" id="tele1" onblur="javascript:justnumber('editar','tele1')" value="<?php echo $roww['TEL1']; ?>" size="12" maxlength="8" /> 
                  </td>
                  <td colspan="2" class="item">Telefono/celular *<br>
					<input name="coda2" type="text" class="input" id="coda2" onblur="javascript:justnumber('editar','coda2')" value="<?php echo $roww['COD_AREA2']; ?>" size="6" maxlength="4" />
                      <input name="tele2" type="text" class="input" id="tele2" onblur="javascript:justnumber('editar','tele2')" value="<?php echo $roww['TEL2']; ?>" size="12" maxlength="8" />
                   
                  <td class="item">Correo Electronico *<br /> <input name="mail" type="text" class="input" id="mail" onblur="emailValido(mail,mail)" value="<?php echo $roww['CORREO']; ?>" size="30" maxlength="30" /></td>
                <tr> 
                  <td colspan="2" class="item">Fecha <input size="13" type="text" name="fe_homol" value="<?php echo $roww['FECHA_NACIMIENTO']; ?>" id="calendar5" readonly="1" class="input"/> 
                    <img src="../libreria/jscalendar-1.0/img.gif" width="16" height="12" id="f_trigger_g" style="cursor: pointer; border: 1px solid blue;" title="Date selector"onmouseover="this.style.background='blue';" onmouseout="this.style.background=''" /></td>
                  <td class="item">Codigo Postal <input name="postal" type="text" size="10" maxlength="6" value="<?php echo $roww['POSTAL']; ?>" class="input" onchange="javascript:justnumber('editar','postal')" /> 
                    <br> </td>
                  <td class="item"></td>
                </tr>
                <tr> 
                  <td colspan="4" align="center"><input name="volver" type="button" value="Volver" class="subtitulo" onclick="history.go(-1)" />
                    <input name="enviar" type="submit" value="Actualizar" class="subtitulo"></td>
                </tr>
              </table>
	</td>
  </tr>
</table>

</form>
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
}else{
  	$sqlp="SELECT medico.ID_MEDICO,medico.CO_ESPECIALIDAD,medico.DIG_NAC,medico.CEDULA,medico.DIG_RIF,medico.NOM1,medico.NOM2,medico.APE1,medico.APE2,especialidad.DESCRIPCION FROM medico,especialidad where medico.CO_ESPECIALIDAD=especialidad.CO_ESPECIALIDAD order by medico.ID_MEDICO DESC";
	$rsp = mysql_query($sqlp, $cn);	
?>
<form action="EditarMedico.php" method="post" name="medicos">
<table width="600" cellspacing="3" cellpadding="2" bgcolor="#FFFFFF" align="center">
  <tr>
    <td colspan="4" class="titulotabla">EDITAR MEDICOS </td>
  </tr>
  <tr>
    <td width="120" class="subtitulo">CEDULA</td>
            <td width="250" class="subtitulo">NOMBRE </td>
    <td width="150" class="subtitulo">ESPECIALIDAD</td>
  </tr>
 	<?php 
	while ($row=mysql_fetch_array($rsp)) {
	$ide = $row['ID_MEDICO'];
	$cedu = $row['DIGNA']." ".$row['CEDULA']." ".$row['DIGR'];
	$nombre = $row['NOM1']." ".$row['NOM2']." ".$row['APE1']." ".$row['APE2'];
	$de = $row['DESCRIPCION'];
	
	?>
  <tr>
    <td class="item"><a href="EditarMedico.php?med=<?php echo $ide ?>"><?php echo  $cedu ?></a></td>
	 <td class="item"><?php echo $nombre ?></td>
    <td class="item"><?php echo $de ?></td>
  </tr>
  <?php 
  }
  ?>
  <tr>
    <td colspan="4" align="center"></td>
  </tr>
</table>
</form>
<?php
}
?>
	<!-- Fin Contenido -->
	</td>
  </tr>
</table>
</body>
</html>