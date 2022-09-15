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

</style>
<script language="javascript">


function recarga() {
	document.registro.submit 
}

function OnSubmitcateg(mode)
  {
	  this.document.registro.submit();
	}

</script>

</head>

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
$campos = array('fe_homol','paciente','especialidad','medico','sintoma','tratamiento');
$fe_reg = $_POST['fe_homol'];
$idpacien = $_POST['paciente'];
$coe = $_POST['especialidad'];
$idmedico = $_POST['medico'];
$sintoma = $_POST['sintoma'];
$trata = $_POST['tratamiento'];
	//******************************
			
 ?>
 <?php
 if(validarCamposRequeridos($campos) != 0){  
 ?>
 		<script>
		alert ("Los campos marcados con * son obligatorios !!!");
		document.location='RegistrarCitas.php';
		</script>
	
	
	<?php
	}else{
	$sqlI = "INSERT INTO lacita (FECHA,ID_PACIENTE,CO_ESPECIALIDAD,ID_MEDICO,SINTOMA,TRATA) 
		VALUES ('$fe_reg','$idpacien','$coe','$idmedico','$sintoma','$trata')";
	$resulta = mysql_query($sqlI, $cn);

	?>	
  		<script>
		alert ("Se almaceno su Cita correctamente !!!");
		document.location='RegistrarCitas.php';
		</script>
      <?php 
  }}else
  {
  ?>
      <form name="cita" method="post" action="RegistrarCitas.php">
        <table width="600" cellspacing="2" cellpadding="1" bgcolor="#8F8F8F" align="center">
          <tr> 
            <td class="titulotabla">REGISTRO DE CITAS</td>
          </tr>
          <tr> 
            <td> <table width="600" cellspacing="3" cellpadding="2" align="center" bgcolor="#FFFFFF">
                <tr> 
                  <td width="64" class="item">Registro 
                    <?php 
$sq="select ID_CITA from lacita order by ID_CITA desc";
$resul = mysql_query($sq, $cn);	
$num_reg = mysql_num_rows($resul);
if($num_reg <=0){
$correlativo = "1";
}else{
$row = mysql_fetch_array($resul);
$correlativo = $row['ID_CITA']+1;
}
?>
                    <input name="idmed" type="text" class="input" value="<?php echo $correlativo; ?>" size="3" readonly="true" /> 
                  </td>
                  <td width="155" class="item">Entidad 
                    <?php 
					
$sq="select co_entidad, descripcion from entidad order by co_entidad desc";
$resul = mysql_query($sq, $cn);					
$row = mysql_fetch_array($resul);
$entidad = $row['co_entidad'];
$des = $row['descripcion'];
?>
                    <input name="coent" type="text" class="input" value="<?php echo $row['descripcion']; ?>" size="25" readonly="true" /> 
                    <input name="coent1" type="HIDDEN" value="<?php echo $entidad; ?>" /> 
                  </td>
                  <td width="156" class="item">Fecha Registro <span class="Estilo2">*</span>
                    <input size="13" type="text" name="fe_homol" id="calendar5" readonly="1" class="input"/> 
                    <img src="../libreria/jscalendar-1.0/img.gif" width="18" height="14" id="f_trigger_g" style="cursor: pointer; border: 1px solid blue;" title="Date selector"onmouseover="this.style.background='blue';" onmouseout="this.style.background=''" /> 
                  </td>
                  <td width="192" class="item">&nbsp; </tr>
                <tr>
                  <td height="29" colspan="4" class="item"><hr /></tr>
                <tr> 
                  <td height="29" colspan="4" class="item">Elegir Paciente * 
                    <?php 
						
						$sql = "select * from pacientes order by ID_PACIENTE DESC ";
						$rs = mysql_query($sql, $cn);
						?>
                    <select id="paciente" class="form-control" name="paciente" >
                      <option value = "0">Elegir</option>
                      <?php 
		while ($rows=mysql_fetch_array($rs)) {
		$idpacien = $rows['ID_PACIENTE'];
		$nombre = $rows['NOMP1']." ".$rows['NOMP2']." ".$rows['APEP1']." ".$rows['APEP2'];

				?>
                      <option value="<?php echo $idpacien; ?>" selected="selected"><?php echo $nombre ;?></option>
                      <?php
			 ?>
                      <?php 
		}
		
				
		?>
                    </select> </p></tr>
                <tr> 
                  <td height="25" colspan="4" class="item"> <hr /> </tr>
                <tr> 
                  <td height="42" colspan="2" class="item">Especialidad * 
                    <?php 
						
						$sql = "select ID_ESPECIALIDAD,CO_ESPECIALIDAD,DESCRIPCION from especialidad  ";
						$rs = mysql_query($sql, $cn);
						?>
                    <select id="especialidad" class="form-control" name="especialidad" requiered ="requiered" >
                      <option value = "">Especialidad</option>
                      <?php 
		while ($rows=mysql_fetch_array($rs)) {
		$idespecial = $rows['ID_ESPECIALIDAD'];
		$coe = $rows['CO_ESPECIALIDAD'];
		$desc = $rows['DESCRIPCION'];
		$_POST['especialidad']=$coe;
				?>
                      <option value="<?php echo $_POST['especialidad']; ?>" selected="selected"><?php echo $desc ;?></option>
                      <?php
			 ?>
                      <?php 
		}
		
				
		?>
                    </select> </br></td>
                  <td colspan="2" class="item">Medico * 
                    <select id="medico" name="medico" class="form-control"  requiered ="required" disabled ="disabled"style="width:140px" >
                      <option value="">Elegir el Medico....</option>
                    </select> <br /> </tr>
                <tr> 
                  <td colspan="2" class="item">Sintomas * 
                    <textarea name="sintoma" id="sintoma" onblur="cambiaMayuscula('cita','sintoma')"></textarea></td>
                  <td colspan="2" class="item">Tratamiento *<br /> <textarea name="tratamiento" id="tratamiento" onblur="cambiaMayuscula('cita','tratamiento')"></textarea> 
                  </td>
                </tr>
                <tr> 
                  <td colspan="2" class="item">Calle/avenida/plaza/esquina<br /> 
                    <input name="aven" type="text" class="input" onchange="cambiaMayuscula('medico', 'aven')" size="40" maxlength="30" /></td>
                  <td colspan="2" class="item">Urbanizaci&oacute;n o barrio <br /> 
                    <input name="urba" type="text" class="input" onchange="cambiaMayuscula('medico', 'urba')" size="40" maxlength="30" /></td>
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
                <tr> 
                  <td colspan="6" ><span class="item Estilo2">Los campos marcados 
                    con * son obligatorios</span></td>
                </tr>
              </table></td>
          </tr>
        </table>
		<?php
 ?>

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
}
?>
      <!-- Fin Contenido -->
    </td>
  </tr>
</table>
<script type="text/javascript" src="../libreria/combo/jquery-3.4.1.min.js"></script>
<script language="javascript">
$(document).ready(function(){
    $("#especialidad").on('change', function () {
						$('#medico').removeAttr('disabled', 'disabled');
        				$("#especialidad option:selected").each(function () {
            			var especialidad = $(this).val();
            			$.post("traemedicos.php", { especialidad: especialidad}, function(data) {
                		$("#medico").html(data);
            });			
        });
   });
});


</script>

</body>
</html>