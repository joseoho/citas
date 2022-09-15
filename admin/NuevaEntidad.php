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
	<!-- Inicio Contenido -->
  <script type="text/javascript" src="../libreria/validaciones.js"></script>
<?php 
if(($_POST['enviar']=="Guardar") and (isset($_POST['codigo'])) and (isset($_POST['descripcion']))){
$codigo = $_POST['codigo'];
$descripcion = $_POST['descripcion'];
$sqlI = "insert into entidad  
		(co_entidad,descripcion,estatus)
		VALUES ('$codigo','$descripcion','1')";
$rs2 = mysql_query($sqlI, $cn);
$ult= mysql_insert_id($cn);

 ?>
  		<script>
		alert ("Se almaceno correctamente !!!");
		document.location='NuevaEntidad.php';
		</script>
<?php 

}else
{
?>
<form name="agregar" method="post" action="NuevaEntidad.php">
<table width="504" cellspacing="2" cellpadding="1" bgcolor="#8F8F8F" align="center">
  <tr>
    <td class="titulotabla">CREAR ENTIDAD </td>
  </tr>
  <tr>
    <td>
<table width="500" cellspacing="3" cellpadding="2" align="center" bgcolor="#FFFFFF">
    
  <tr>
    <td width="350" class="item">Nombre de la Entidad <br>
	<input name="descripcion" type="text" size="60" maxlength="100" class="input" onChange="cambiaMayuscula('agregar', 'descripcion')"></td>
                  <td width="150" class="item">C&oacute;digo de la Entidad<br>
	<input name="codigo" type="text" size="20" maxlength="3" class="input" onChange="cambiaMayuscula('agregar', 'codigo')"></td>
  </tr>
  <tr>
    <td align="center" colspan="2"><input name="enviar" type="submit" value="Guardar" class="subtitulo"></td>
  </tr>
</table>
	</td>
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