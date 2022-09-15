<?php 
include('conexion.php');
//// Funcion para colocar la fecha en español
function FechaFormateada2($FechaStamp)
{ 
  $ano = date('Y',$FechaStamp);
  $mes = date('n',$FechaStamp);
  $dia = date('d',$FechaStamp);
  $diasemana = date('w',$FechaStamp);

  $diassemanaN= array("Domingo","Lunes","Martes","Miercoles",
                      "Jueves","Viernes","Sábado"); $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
                 "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  return $diassemanaN[$diasemana].", $dia de ". $mesesN[$mes] ." de $ano";
}


function generaSelect(){
	$cn = conectarse();
	$sql="SELECT * FROM marca WHERE estatus='1' ORDER BY descripcion";
	$rs = mysql_query($sql, $cn);	

	// Voy imprimiendo el primer select compuesto por los estados
	echo "<select name='select1' id='select1' onChange='cargaContenido(this.id)' style='width:350px' class='item'>";
	echo "<option value='0'>Selecciona el Estado</option>";
		while ($row=mysql_fetch_array($rs)) {
		$co = $row['id_marca'];
		$nombre = $row['descripcion'];
		echo "<option value='".$co."'>".$nombre."</option>";
	}
	echo "</select>";
}
?>