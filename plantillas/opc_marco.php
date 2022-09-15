<?php 
//session_start();
error_reporting(0);
$id_u = $_SESSION['id_usu'];
?>
<style>
.habilinkmenu{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: normal;
	color: #333333;
	text-decoration: none;
}
A:hover{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	color: #333333;
	text-decoration: none;
}
A:link, A:visited {
	text-decoration: none;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #333333;
}

</style>


<?php
$cn = conectarse();
$sql = "select b.nombre, b.url  from acceso a, aplicacion b where a.id_aplicacion = b.id_aplicacion and id_usuario = $id_u order by b.orden";
$rs = mysql_query($sql, $cn);
?>
<table width="180" cellspacing="2">
  <tr>
    <td><img src="../images/pestania.jpg" width="180" height="23"></td>
  </tr>
  <tr>
    <td><a href="../plantillas/Bienvenida.php" class="subtitulo">Inicio</a></td>
  </tr>
   	<?php 
	$cont = 0;
	while ($row=mysql_fetch_array($rs)) {
	if($cont % 2 == 0)$color ='bgcolor="#DBDBDB"'; else $color = 'bgcolor="#FFFFFF"';
	$nombre = $row['nombre'];
	$url = $row['url'];
	$modelo = $row['modelo'];
	?>
  <tr <?php echo $color; ?>>
    <td><a href="../<?php echo $url; ?>"  class="habilinkmenu"><?php echo $nombre; ?></a></td>
  </tr>
<?php 
$cont++;
}
?>

  <tr>
    <td><a href="../"  class="subtitulo">SALIR</a></td>
  </tr>
  <tr>
    <td><img src="../images/pestania2.jpg" width="180" height="23"></td>
  </tr>
</table>

