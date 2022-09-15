<?php 
session_start();
error_reporting(0);
$id_u = $_SESSION['id_usu'];
?>


<?php
$cn = conectarse();
$sql = "select b.nombre, b.url  from acceso a, aplicacion b where a.id_aplicacion = b.id_aplicacion and id_usuario = $id_u order by a.id_aplicacion";
$rs = mysql_query($sql, $cn);
?>
<table width="155" cellpadding="4" cellspacing="0">
  <tr>
    <td class="titulotabla"><div align="center">MENU</div></td>
  </tr>
  <tr>
    <td><a href="../plantillas/Bienvenida.php" class="subtitulo">Inicio</a></td>
  </tr>
   	<?php 
	while ($row=mysql_fetch_array($rs)) {
	$nombre = $row['nombre'];
	$url = $row['url'];
	$modelo = $row['modelo'];
	$color = $row['descripcion'];
	?>
  <tr>
    <td><a href="../<?php echo $url; ?>"  class="subtitulo"><?php echo $nombre; ?></a></td>
  </tr>
<?php 
}
?>

  <tr>
    <td><a href="../"  class="subtitulo">SALIR</a></td>
  </tr>
</table>

