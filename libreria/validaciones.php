<?php 
include('conexion.php');


//// Funcion para colocar la fecha en español
function FechaFormateada($FechaStamp)
{ 
  $ano = date('Y',$FechaStamp);
  $mes = date('n',$FechaStamp);
  $dia = date('d',$FechaStamp);
  $diasemana = date('w',$FechaStamp);

  $diassemanaN= array("Domingo","Lunes","Martes","Miércoles",
                      "Jueves","Viernes","Sábado"); $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
                 "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  return $diassemanaN[$diasemana].", $dia de ". $mesesN[$mes] ." de $ano";
}


function ValorConvertidoVin($letra){
	if(is_numeric($letra)){
		$valor = $letra;
		}
		else{
			switch($letra){
				case A:
					$valor = 1;
					break;
				case B:
					$valor = 2;
					break;
				case C:
					$valor = 3;
					break;
				case D:
					$valor = 4;
					break;
				case E:
					$valor = 5;
					break;
				case F:
					$valor = 6;
					break;
				case G:
					$valor = 7;
					break;
				case H:
					$valor = 8;
					break;
				case J:
					$valor = 1;
					break;
				case K:
					$valor = 2;
					break;
				case L:
					$valor = 3;
					break;
				case M:
					$valor = 4;
					break;
				case N:
					$valor = 5;
					break;
				case P:
					$valor = 7;
					break;
				case R:
					$valor = 9;
					break;
				case S:
					$valor = 2;
					break;
				case T:
					$valor = 3;
					break;
				case U:
					$valor = 4;
					break;
				case V:
					$valor = 5;
					break;
				case W:
					$valor = 6;
					break;
				case X:
					$valor = 7;
					break;
				case Y:
					$valor = 8;
					break;
				case Z:
					$valor = 9;
					break;
			}
		}
	return $valor;
}

function generaSelect(){
//llena el combo en DB OCCIDENTE
	/*$cn = conectarse();
	$sql="SELECT * FROM modelo WHERE estatus='1' ORDER BY descripcion";
	$rs = mysql_query($sql, $cn);	

	// Voy imprimiendo el primer select compuesto por los estados
	echo "<select name='select1' id='select1' onChange='cargaContenido(this.id)' style='width:140px'  class='input'>";
	echo "<option value='0'>Selecciona el modelo</option>";
		while ($row=mysql_fetch_array($rs)) {
		$co = $row['id_modelo'];
		$nombre = $row['descripcion'];
		echo "<option value='".$co."'>".$nombre."</option>";
	}
	echo "</select>";
}*/
$cn = conectarse();
	$sql="SELECT * FROM especialidad WHERE estatus='1' ORDER BY descripcion";
	$rs = mysql_query($sql, $cn);	

	// Voy imprimiendo el primer select compuesto por los estados
	echo "<select name='select1' id='select1' onChange='cargaContenido(this.id)' style='width:140px'  class='input'>";
	echo "<option value='0'>Selecciona Especialidad</option>";
		while ($row=mysql_fetch_array($rs)) {
		$co = $row['CO_ESPECIALIDAD'];
		$nombre = $row['DESCRIPCION'];
		echo "<option value='".$co."'>".$nombre."</option>";
	}
	echo "</select>";
	echo "<br>";
	echo "<div id='select2'></div>";
}


function validarCamposRequeridos($c, $e = 0){ 
    foreach($c as $k){if(!isset($_POST[$k]) OR trim(@$_POST[$k]) == null){$e = $e + 1;}} 
    return $e; 
} 

?>