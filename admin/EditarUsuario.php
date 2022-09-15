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
if($_POST['enviar']=="Actualizar"){
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$mail = $_POST['mail'];
$cedula = $_POST['cedula'];
$co = $_POST['co'];
$aplicacion = $_POST['aplicacion'];
$sts = $_POST['sts'];


$sqlI = "UPDATE usuarios SET nombre='$nombre',apellido='$apellido',cedula='$cedula',email='$mail',estatus='$sts' WHERE id_usuario=$co";

echo $sqlI;
$rs2 = mysql_query($sqlI, $cn);
$ult= mysql_insert_id($cn);

$sqlD = "DELETE  from acceso WHERE id_usuario=$co";
$rsD = mysql_query($sqlD, $cn);

foreach($aplicacion as $apl){
$sqlI2 = "insert into acceso   
		(id_aplicacion,id_usuario)
		VALUES ('$apl','$co')";
$rsI2 = mysql_query($sqlI2, $cn);
}
 ?>
  		<script>
		alert ("Se Actualizo correctamente !!!");
		document.location='EditarUsuario.php';
		</script>
<?php 

}elseif(isset($_GET['co'])){
$id=$_GET['co'];
$sql2="SELECT * FROM usuarios WHERE id_usuario=$id";
$rs2 = mysql_query($sql2, $cn);
$row2=mysql_fetch_array($rs2)

?>
<form name="editar" method="post" action="EditarUsuario.php">
<table width="504" cellspacing="2" cellpadding="1" bgcolor="#8F8F8F" align="center">
  <tr>
    <td class="titulotabla">EDITAR USUARIO </td>
  </tr>
  <tr>
    <td>
<table width="500" cellspacing="3" cellpadding="2" align="center" bgcolor="#FFFFFF">
    
  <tr>
    <td width="250" class="item">Nombres<br>
	<input name="nombre" type="text" size="40" value="<?php echo $row2['nombre']; ?>" maxlength="150" class="input" onChange="cambiaMayuscula('editar', 'nombre')">
	<input type="hidden" name="co" value="<?php echo $row2['id_usuario']; ?>" /></td>
    <td width="250" class="item">Apellidos  <br>
	<input name="apellido" type="text" size="40" value="<?php echo $row2['apellido']; ?>" maxlength="150" class="input" onChange="cambiaMayuscula('editar', 'apellido')"></td>
  </tr>
  <tr>
    <td class="item">Correo Electronico   <br>
	<input name="mail" type="text" size="40" value="<?php echo $row2['email']; ?>" maxlength="150" class="input" onBlur="emailValido(mail,mail)"></td>
  <td class="item">Cedula de Identidad <br>
	<input name="cedula" type="text" size="20" value="<?php echo $row2['cedula']; ?>" maxlength="8" class="input" onBlur="javascript:justnumber('editar','cedula')"></td>
	  </tr>
  <tr>
    <td class="item">Usuario<br>
                    <input name="user" type="text" size="20" value="<?php echo $row2['usuario']; ?>" maxlength="10" class="input" readonly="1" /></td>
	<td class="item"><br>
	<input type="radio" value="a"  name="sts" <?php if($row2['estatus']=='a') echo "checked"; ?>/>Activo&nbsp;&nbsp;
	<input type="radio" value="i" name="sts" <?php if($row2['estatus']=='i') echo "checked"; ?>/>Inactivo&nbsp;&nbsp;</td>

  </tr>
  <tr>
    <td colspan="2" class="item">Modulos Disponibles
</td>
  </tr>
<?php

$sql="SELECT a.*,b.id_usuario FROM aplicacion a LEFT JOIN acceso b ON a.id_aplicacion=b.id_aplicacion AND b.id_usuario=$id "; 
//$sql = "SELECT * FROM aplicacion WHERE tipo!='a'";
//echo $sql;
$rs = mysql_query($sql, $cn);
while ($row=mysql_fetch_array($rs)) {
		$co = $row['id_aplicacion'];
		$nombre = $row['nombre'];

?>
  <tr>
    <td colspan="2" class="input">
	<input type="checkbox" name="aplicacion[]" value="<?php echo $co; ?>" <?php if($row['id_usuario']==$id) echo "checked"; ?>/>&nbsp;<?php echo $nombre; ?>
</td>
  </tr>
  <?php 
  }
  ?>
  <tr>
    <td align="center" colspan="2"><input name="volver" type="button" value="Volver" class="subtitulo" onclick="history.go(-1)">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="enviar" type="submit" value="Actualizar" class="subtitulo"></td>
  </tr>
</table>
	</td>
  </tr>
</table>

</form>
<?php 
}
else{
$sql="SELECT * FROM usuarios WHERE tipo='u'";
$rs = mysql_query($sql, $cn);
 ?>	
 
 <table width="400" align="center">
 	<tr>
		<td colspan="4" class="titulotabla">EDITAR USUARIO</td>
	</tr>
 	<tr>
		<td class="subtitulo">Codigo</td>
		<td class="subtitulo">Nombre</td>
		<td class="subtitulo">Apellido</td>
		<td class="subtitulo">Estatus</td>
	</tr>
<?php 
while ($row=mysql_fetch_array($rs)) {
		$co = $row['id_usuario'];
		$nombre = $row['nombre'];
		$apellido = $row['apellido'];
		$estatus= $row['estatus'];

?>	
 	<tr>
		<td width="40" class="input"><a href="EditarUsuario.php?co=<?php echo $co; ?>"><?php echo $co; ?></a></td>
		<td width="150" class="input"><?php echo $nombre; ?></td>
		<td width="150" class="input"><?php echo $apellido ?></td>
		  <td width="60" class="input">
            <?php if($estatus=='a') echo "Activo"; else "Inactivo"; ?>
          </td>
	</tr>
<?php 
}
?>
 </table>	
<?php		
}
?>
	<!-- Fin Contenido -->
	</td>
  </tr>
</table>
</body>
</html>