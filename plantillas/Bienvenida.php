<?php 
session_start();
error_reporting(0);
$id_usu = $_SESSION['id_usu'];
$usuario = $_SESSION['usuario'];
include('../libreria/validaciones.php');
$fecha = time();
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
    <td align="center"><br>
      <!-- Inicio Contenido -->
      <img src="../images/LOGO.jpg" width="469" height="129" /> 
      <!-- Fin Contenido -->
    </td>
  </tr>
</table>
</body>
</html>
