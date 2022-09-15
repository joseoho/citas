<?php 
session_start();
error_reporting(0);
include('../libreria/validaciones.php');
$cn = conectarse();
//$id_departamento=intval($_REQUEST['codespecialidad']);
//echo $id_departamento;
//echo $_POST['especialidad'];

?>

 
<?php
$html = '';

 $sq ="SELECT medico.ID_MEDICO,medico.CO_ESPECIALIDAD,medico.NOM1,medico.NOM2,medico.APE1,medico.APE2 FROM medico,especialidad
	 WHERE medico.CO_ESPECIALIDAD='".$_POST['especialidad']."' AND medico.CO_ESPECIALIDAD=especialidad.CO_ESPECIALIDAD";
	 $resul = mysql_query($sq, $cn);	
		while ($roww=mysql_fetch_array($resul)) {
		//$idmed = $roww['ID_MEDICO'];
		//$nombre = $roww['NOM1']." ".$roww['NOM2']." ".$roww['APE1']." ".$roww['APE2'];
        $html .='<option value="'.$roww['ID_MEDICO'].'">' .$roww['NOM1'].' '.$roww['NOM2'].' '.$roww['APE1'].' '.$roww['APE2'].'</option>';

}
echo $html;


		?>

