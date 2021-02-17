<?php
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

<head>
	<!--<meta charset = "utf-8" />-->
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name = "viewport" content = "width=device-width, initial-scale=1" />
	<link rel = "stylesheet" type = "text/css" href = "css/bootstrap.css" />
  <link rel = "stylesheet" type = "text/css" href = "css/chosen.min.css" />
  <link rel = "stylesheet" type = "text/css" href = "css/main.css" />
</head>
<table style="width:100%">
  <tr>
    <th colspan="5" class="text-center">Reporte de según nivel de aporte a los objetivos generales</th>
  </tr>
  <tr>
    <th colspan="5" class="text-center">(Fecha de consulta: <?php echo $fechaNow ?>)</th>
  </tr>
</table>
<br>
<table style="width:100%">
  <tr>
    <th class="text-left">Carrera:</th>
    <td class="text-left"><?php echo $nomCar ?></td>
    <th class="text-right">Tipo de competencias:</th>
    <td class="text-left"><?php echo $nameCompe ?></td>
    <td class="text-left"><b>Competencia:</b> <?php echo $nomC ?></td>
  </tr>
  <tr>
    <th class="text-left">Fecha de Malla curricular:</th>
    <td class="text-left"><?php echo $fechaMalla ?></td>
    <th class="text-right">¿Cursos obligatorios?:</th>
    <td class="text-left"><?php echo $nameObliga ?></td>
    <td class="text-left"><b>Nivel de  aporte:</b> <?php
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
  <table class="table table-bordered" style="width:100%;">
    <thead>
      <tr class="bg-primary">
        <th class="text-center" style="width:30%;">Curso</th>
        <th class="text-center" style="width:7%;">Ciclo</th>
        <th class="text-center" style="width:7%;">Depto. <br>Acad. </th>
        <th class="text-center" style="width:45%;">Objetivo general</th>
        <th class="text-center" style="width:10%;">Nivel de aporte</th>
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
        <td class="text-left"><?php echo $nombreCurso ?></td>
        <td class="text-center"><?php echo $ciclo ?></td>
        <td class="text-center"><?php echo $nameCortoDepto ?></td>
        <td class="text-center"><?php echo $desObj ?></td>

        <?php
          if($nivelAporte=='1'){
        ?>
          <td class="text-center">Contribuye</td>
        <?php
          }else if($nivelAporte=='2') {
        ?>
          <td class="text-center">Logra</td>
        <?php
          }else if ($nivelAporte=='3') {
        ?>
          <td class="text-center">Sostiene</td>
        <?php
          }else if($nivelAporte=='4') {
        ?>
          <td class="text-center">No Aplica</td>
        <?php
          }
        }
        ?>
      </tr>
    </tbody>
  </table>
