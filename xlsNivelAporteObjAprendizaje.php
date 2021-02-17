<?php

header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
header('Content-Transfer-Encoding: none');
header('Content-type: application/x-msexcel'); // This should work for the rest
header('Content-Disposition: attachment; filename=ReporteNivelAporteObjetivosGenerales.xls');

require_once ('connect.php');

$idCarrera  = $_REQUEST['idCarrera'];
$fechaMalla = $_REQUEST['fechaMalla'];
$idTipoComp = $_REQUEST['tipoCompetencia'];
$idObliga 	= $_REQUEST['obligatorio'];
$idComp     = $_REQUEST['idCompetencia']; 
$tipoaporte = $_REQUEST['nivelaporte'];

$sWhere     = "";
$otroWhere  = "";
if($idObliga==3){
  $sWhere = "AND dcn.idTipo='$idTipoComp'";
}

if($idTipoComp==3){
  $sWhere = "AND dm.obligatoriedad='$idObliga'";
}

if($idTipoComp==3 || $idObliga==3){
  $sWhere = "";
}


if ($idComp!=0) {
  $otroWhere = "AND dcn.idCompetencia='$idComp'";
}else {
  $otroWhere = "";
}


$sql = $conn->query("SELECT dcn.idCarrera, dcn.idCurso, c.nombreCurso, dm.ciclo, c.idDepartamento, d.descripcion AS nomDepto, d.nombreCorto,
                    dcn.idCompetencia, cc.descripcion AS nomCompetencia, tc.descripcion as nomTipoComp, dcn.fAprobacionPerfil, dcn.tipoaporte, dcn.idTipo, dcn.idObjgeneral, obg.definicion as nomObj
                    FROM detalle_curso_nivelaporte dcn LEFT JOIN
                    detalle_malla dm ON (dm.idCurso = dcn.idCurso) LEFT JOIN curso c ON (c.idCurso = dcn.idCurso)
                    LEFT JOIN departamento d ON (d.idDepartamento = c.idDepartamento)
                    LEFT JOIN competencia cc ON (cc.idCompetencia = dcn.idCompetencia)
                    LEFT JOIN tipocompetencia tc ON (tc.idTipo = cc.idTipo)
                    LEFT JOIN objgeneral obg ON (obg.idObjgeneral=dcn.idObjgeneral)
                    WHERE dcn.idCarrera='$idCarrera' AND tipoaporte IN ($tipoaporte)
                    $otroWhere $sWhere
                    GROUP BY dcn.idCarrera, dcn.idCurso, dcn.idCompetencia, dcn.idObjgeneral
                    ORDER BY dcn.idCurso , dcn.idCompetencia, dcn.idObjgeneral") or die(mysqli_error($conn));

$fechaNow = date('d-m-Y');

$qryCar = $conn->query("SELECT * FROM carrera WHERE idCarrera='$idCarrera'") or die(mysqli_error($conn));
$resCar = $qryCar->fetch_array();
$nomCar = $resCar['descripcion'];


if($idTipoComp==1){
  $nameCompe = 'Sello UP';
}else if($idTipoComp==2) {
  $nameCompe = 'Específicas';
}else {
  $nameCompe = 'Todos';
}

if($idObliga==1){
  $nameObliga = 'Si';
}else if($idObliga==2) {
  $nameObliga = 'No';
}else {
  $nameObliga = 'Todos';
}

if($idComp==0){
  $nomC = 'Todas las competencias';
}else {
  $qryC = $conn->query("SELECT * FROM competencia WHERE idCompetencia='$idComp'") or die(mysqli_error($conn));
  $resC = $qryC->fetch_array();
  $nomC = $resC['descripcion'];
}

$levels  = explode(",", $tipoaporte);
$longitud = count($levels);

$var = array();
for($i=0; $i<$longitud; $i++)
{
  if($levels[$i] == 1){
    $nameTipo = 'Contribuye';
  }else if($levels[$i] == 2){
    $nameTipo = 'Logra';
  }else if($levels[$i] == 3){
    $nameTipo = 'Sostiene';
  }else if($levels[$i] == 4){
    $nameTipo = 'No aplica';
  }

  $var[] = $nameTipo.', ';
}

// print_r($var1);

?>

<table>
  <tr>
    <th colspan="5">Reporte de según nivel de aporte a los objetivos generales</th>
  </tr>
  <tr>
    <th colspan="5">(Fecha de consulta: <?php echo $fechaNow ?>)</th>
  </tr>

  <tr>
    <th colspan="5"></th>
  </tr>

  <tr>
    <th align="left">Carrera:</th>
    <td align="left"><?php echo $nomCar ?></td>
    <th align="right">Tipo de competencias:</th>
    <td align="left"><?php echo $nameCompe ?></td>
    <td align="left"><b>Competencia:</b> <?php echo $nomC ?></td>
  </tr>
  <tr>
    <th align="left">Fecha de Malla curricular:</th>
    <td align="left"><?php echo $fechaMalla ?></td>
    <th align="right">¿Cursos obligatorios?:</th>
    <td align="left"><?php echo $nameObliga ?></td>
    <td align="left"><b>Nivel de  aporte:</b> <?php
      foreach ($var as $key => $value) {
        echo $value;
      }
    ?>
    </td>
  </tr>
</table>
<br>

<!-- <div class=""> -->
  <!-- <label>Descargar</label> -->
  <table border="1" style="width:100%;">
    <thead>
      <tr bgcolor="
        <?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
        ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
        ($idCarrera==21 ? '#1e9bd1' :
        ($idCarrera==31 ? '#f0a02b' :
        ($idCarrera==32 ? '#f9d126' :
        ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?>" style="color:#FFFFFF">
        <th align='center' style="width:30%;">Curso</th>
        <th align='center' style="width:5%;">Ciclo</th>
        <th align='center' style="width:10%;">Departamento <br>Académico </th>
        <th align='center' style="width:45%;">Objetivo general</th>
        <th align='center' style="width:10%;">Nivel de aporte</th>
      </tr>
    </thead>
    <tbody>
      <?php
        while ($row=mysqli_fetch_array($sql))
        {

          $idCarrera     = $row['idCarrera'];
    	    $idCurso       = $row['idCurso'];
    	    $nombreCurso   = $row['nombreCurso'];
    	    $ciclo         = $row['ciclo'];
    	    $depto         = $row['nomDepto'];
    	    $idCompetencia = $row['idCompetencia'];
    	    $competencia   = $row['nomCompetencia'];
    	    $tipoComp      = $row['nomTipoComp'];
    	    $idTipoComp    = $row['idTipo'];
    	    $fechaPerfil   = $row['fAprobacionPerfil'];
    	    $desObj        = $row['nomObj'];
    	    $nivelAporte   = $row['tipoaporte'];
    	    $nameCortoDepto = $row['nombreCorto'];

      ?>

      <tr>
        <td align="left"><?php echo $nombreCurso ?></td>
        <td align="center"><?php echo $ciclo ?></td>
        <td align="center"><?php echo $nameCortoDepto ?></td>
        <td align="justify"><?php echo $desObj ?></td>

        <?php
          if($nivelAporte=='1'){
        ?>
          <td align="center">Contribuye</td>
        <?php
          }else if($nivelAporte=='2') {
        ?>
          <td align="center">Logra</td>
        <?php
          }else if ($nivelAporte=='3') {
        ?>
          <td align="center">Sostiene</td>
        <?php
          }else if($nivelAporte=='4') {
        ?>
          <td align="center">No Aplica</td>
        <?php
          }

        }
      ?>
      </tr>
    </tbody>
  </table>
