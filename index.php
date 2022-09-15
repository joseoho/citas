<?php session_start();
$fecha = time();
error_reporting(0);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Ingreso Sistema</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="libreria/sistema.css" rel="stylesheet" type="text/css">
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
<?php 
include('libreria/validaciones.php');
$cn = conectarse();
if(($_POST['ingresar'] == 'INGRESAR')and($_POST['usuario']!="")and($_POST['clave']!=""))
{
$usuario = $_POST['usuario'];
$clave = $_POST['clave'];
$sql="SELECT id_usuario, usuario, nombre, apellido, acceso FROM usuarios WHERE usuario ='$usuario' and clave = '$clave'";
$rs = mysql_query( $sql, $cn);
$filas = mysql_num_rows($rs);
if($filas == 0)
{
 ?>
  		<script>
		alert ("El usuario no existe!! Por favor verifique su informaci�n");
		document.location='index.php';
		</script>
<?php 
}
else
{
$row = mysql_fetch_array ($rs);
$_SESSION['id_usu'] = $row['id_usuario'];
$_SESSION['usuario'] = $row['nombre']." ".$row['apellido'];
$_SESSION['tipo'] = $row['acceso'];
 ?>
  		<script>
		document.location='plantillas/Bienvenida.php';
		</script>
<?php 
}
}else{
?>
<table width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><img src="images/BANNER.jpg" width="850" height="110"></td>
  </tr>
</table>


<table width="850" align="center">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="center">
<form name="ingresar" method="post" action="index.php">
<table width="300" cellspacing="2" cellpadding="1" align="center">
  <tr>
    <td colspan="2" align="center"><img src="images/ingreso.jpg" width="300" height="30"></td>
  </tr>
  <tr>
    <td class="item" align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="100" class="item" align="right">USUARIO&nbsp;</td>
    <td width="200"><input class="input" name="usuario" type="text" size="15"></td>
  </tr>
  <tr>
    <td class="item" align="right">CLAVE&nbsp;</td>
    <td><input class="input" name="clave" type="password" size="15"></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><br><input class="subtitulo" name="ingresar" type="submit" value="INGRESAR"></td>
  </tr>
</table>
</form>
		</td>
	</tr>
</table>
<?php 
}
?>
</body>
</html>
