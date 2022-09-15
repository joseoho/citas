<?php 
session_start();
error_reporting(0);
$id_usu = $_SESSION['id_usu'];
$usuario = $_SESSION['usuario'];
include('../libreria/validaciones.php');
$fecha = time();
/*$cn = conectarse();*/
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
if($_POST['enviar']=="Guardar"){
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$mail = $_POST['mail'];
$cedula = $_POST['cedula'];
$clave = $_POST['clave'];
$user = $_POST['user'];
$aplicacion = $_POST['aplicacion'];


$sqlI = "insert into usuarios   
		(nombre,apellido,cedula,usuario,email,clave,estatus,fe_creacion,tipo,acceso)
		VALUES ('$nombre','$apellido','$cedula','$user','$mail','$clave','a',now(),'a',2)";
		//echo $sqlI;
$rs2 = mysql_query($sqlI, $cn);
$ult= mysql_insert_id($cn);

foreach($aplicacion as $apl){
$sqlI2 = "insert into acceso   
		(id_aplicacion,id_usuario)
		VALUES ('$apl','$ult')";
$rsI2 = mysql_query($sqlI2, $cn);
}
 ?>
  		<script>
		alert ("Se almaceno correctamente !!!");
		document.location='NuevoUsuario.php';
		</script>
<?php 

}else
{
?>
<form name="agregar" method="post" action="NuevoUsuario.php">
<table width="504" cellspacing="2" cellpadding="1" bgcolor="#8F8F8F" align="center">
  <tr>
    <td class="titulotabla">CREAR USUARIO </td>
  </tr>
  <tr>
    <td>
<table width="500" cellspacing="3" cellpadding="2" align="center" bgcolor="#FFFFFF">
    
  <tr>
    <td width="250" class="item">Nombres<br>
	<input name="nombre" type="text" size="40" maxlength="150" class="input" onChange="cambiaMayuscula('agregar', 'nombre')"></td>
    <td width="250" class="item">Apellidos  <br>
	<input name="apellido" type="text" size="40" maxlength="150" class="input" onChange="cambiaMayuscula('agregar', 'apellido')"></td>
  </tr>
  <tr>
    <td class="item">Correo Electronico   <br>
	<input name="mail" type="text" size="40" maxlength="150" class="input" onBlur="emailValido(mail,mail)"></td>
  <td class="item">Cedula de Identidad <br>
	<input name="cedula" type="text" size="20" maxlength="8" class="input" onBlur="javascript:justnumber('agregar','cedula')"></td>
	  </tr>
  <tr>
    <td class="item">Usuario<br>
	<input name="user" type="text" size="20" maxlength="10" class="input"></td>
	<td class="item">Clave<br>
	<input name="clave" type="text" size="20" maxlength="8" class="input">
	<span class="style4"> Max. 8 caracteres</span></td>

  </tr>
  <tr>
    <td colspan="2" class="item">Modulos disponibles
</td>
  </tr>
<?php 
$sql = "SELECT * FROM aplicacion WHERE tipo!='a'";
$rs = mysql_query($sql, $cn);
while ($row=mysql_fetch_array($rs)) {
		$co = $row['id_aplicacion'];
		$nombre = $row['nombre'];

?>
  <tr>
    <td colspan="2" class="input">
	<input type="checkbox" name="aplicacion[]" value="<?php echo $co; ?>" />&nbsp;<?php echo $nombre; ?>
</td>
  </tr>
  <?php 
  }
  ?>
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