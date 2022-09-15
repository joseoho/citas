<?php 
session_start();
error_reporting(0);

include('../libreria/validaciones.php');

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
.style4 {
	text-decoration: none;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #990000;
	font-size: 10px;
	font-style: normal;
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
      <form class ="form-inline" method="post" action="">
	  
<table width="643" cellspacing="2" cellpadding="1" bgcolor="" align="center">
  <tr>
            <td width="1127" class="titulotabla">GENERAR CITAS</td>
  </tr>
  <tr>
            <td>
<table width="459" cellspacing="3" cellpadding="2" align="center" bgcolor="#FFFFFF">
                <tr> 
                  <td width="68" class="item">Especialidad</td>
                  <td width="108" class="item">
		
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
			     
  </select>
  
                  </td>
                  <td width="40" class="item"> Medico<br> </td>
                  <td width="179" class="item"><select id="medico" name="medico" class="form-control"  requiered ="required" disabled ="disabled"style="width:140px" >
                      <option value="">Elegir el Medico....</option>
                    </select></td>
                </tr>
                <tr> 
                  <td align="center" colspan="4"><input name="enviar" type="submit" value="Guardar" class="subtitulo">
                  </td>
                </tr>
              </table>
	</td>
  </tr>
</table>

</form>

      <!-- Fin Contenido -->
      <p>&nbsp;</p></td>
	 
  </tr>
</table>
</body>
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
</html>