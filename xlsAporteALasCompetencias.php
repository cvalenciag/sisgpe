<?php

header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
header('Content-Transfer-Encoding: none');
header('Content-type: application/x-msexcel'); // This should work for the rest
header('Content-Disposition: attachment; filename=ReporteSegunAporteCompetencias.xls');

require_once 'connect.php';


$idCarrera  = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$fechaMalla = (isset($_REQUEST['fechaMalla']) && !empty($_REQUEST['fechaMalla']))?$_REQUEST['fechaMalla']:'';
$tipoComp   = (isset($_REQUEST['tipoComp']) && !empty($_REQUEST['tipoComp']))?$_REQUEST['tipoComp']:'';
$idComps    = (isset($_REQUEST['idComp']) && !empty($_REQUEST['idComp']))?$_REQUEST['idComp']:'';
$idObliga   = (isset($_REQUEST['idObliga']) && !empty($_REQUEST['idObliga']))?$_REQUEST['idObliga']:'';


$sWhere = "";
if($idObliga==3){
  // echo 'obliga_'.$idObliga.'_tipo_'.$tipoComp;
  $sWhere = "AND dcna.idTipo='$tipoComp'";
}

if($tipoComp==3){
  // echo 'tipo_'.$tipoComp.'_obliga_'.$idObliga;
  $sWhere = "AND dm.obligatoriedad='$idObliga'";
  // $sWhere = "AND dcn.idTipo='$tipoComp'";
}

if($idComps != 0){
	$sWhere = "AND dcna.idCompetencia IN ($idComps)";
}

if($tipoComp==3 && $idObliga==3 && $idComps==0){
  $sWhere = "";
}


// Competencias
$qryComp1  = $conn->query("SELECT * FROM detalle_carrera_competencia LEFT JOIN competencia USING (idCompetencia) WHERE idTipo=1 AND idCarrera='$idCarrera'")
	or die(mysqli_error($conn));
$competencias1 = mysqli_fetch_all($qryComp1, MYSQLI_ASSOC);

$qryComp2  = $conn->query("SELECT * FROM detalle_carrera_competencia LEFT JOIN competencia USING (idCompetencia) WHERE idTipo=2 AND idCarrera='$idCarrera'")
	or die(mysqli_error($conn));
$competencias2 = mysqli_fetch_all($qryComp2, MYSQLI_ASSOC);



function dd($data) {
	var_dump($data); die;
}

// Cursos
$qryCursos = $conn->query("SELECT
		dcna.idCurso,
		c.nombreCurso
	FROM detalle_curso_nivelaporte dcna
	JOIN curso c ON c.idCurso = dcna.idCurso
	WHERE dcna.idCarrera='$idCarrera' AND dcna.tipoaporte IN (1,2,3) $sWhere
	GROUP BY dcna.idCurso")
or die(mysqli_error($conn));
$cursos = mysqli_fetch_all($qryCursos, MYSQLI_ASSOC);

// Matriz con todos los niveles de aporte (para evitar consultas continuas a la BD)
$qryNivel = $conn->query("SELECT
		dcna.idCurso,
		dcna.idCompetencia,
		MIN(dcna.tipoaporte) as tipoAporte,
		c.nombreCurso
	FROM detalle_curso_nivelaporte dcna
	JOIN curso c ON c.idCurso = dcna.idCurso
	WHERE dcna.idCarrera='$idCarrera'
		AND dcna.tipoaporte IN (1,2,3) $sWhere
	GROUP BY dcna.idCurso, dcna.idCompetencia")
or die(mysqli_error($conn));

$mtAportes = mysqli_fetch_all($qryNivel, MYSQLI_ASSOC);



function esTCA($idCurso, $idCompetencia, $mtAportes) {
	foreach ($mtAportes as $aporte) {
		if ($aporte['idCurso'] == $idCurso && $aporte['idCompetencia'] == $idCompetencia && $aporte['tipoAporte'] != '4')
			return true;
	}

	return false;
}

$totalCompetencias = sizeof($competencias1) + sizeof($competencias2);


// OTROS DATOS ==========================================================================
$fechaNow = date('d-m-Y');

$qryCar = $conn->query("SELECT * FROM carrera WHERE idCarrera='$idCarrera'") or die(mysqli_error($conn));
$resCar = $qryCar->fetch_array();
$nomCar = $resCar['descripcion'];

if($idObliga==1){
  $nameObliga = 'Si';
}else if($idObliga==2) {
  $nameObliga = 'No';
}else {
  $nameObliga = 'Todos';
}


if($tipoComp==1){
  $nameCompe = 'Sello UP';
}else if($tipoComp==2) {
  $nameCompe = 'Específicas';
}else {
  $nameCompe = 'Todos';
}


if($idComps==0){
  $nomC = 'Todas las competencias';
}else {
  $qryC = $conn->query("SELECT * FROM competencia WHERE idCompetencia='$idComps'") or die(mysqli_error($conn));
  $resC = $qryC->fetch_array();
  $nomC = $resC['descripcion'];
}

?>


<table>
  <tr>
    <th colspan="9">Reporte de cursos según aporte a las competencias</th>
  </tr>
  <tr>
    <th colspan="9">(Fecha de consulta: <?php echo $fechaNow ?>)</th>
  </tr>

  <tr>
    <th colspan="9"></th>
  </tr>

  <tr>
    <th align="left">Carrera:</th>
    <td align="left"><?php echo $nomCar ?></td>
    <th></th>
    <th align="right">Tipo de competencias:</th>
    <td align="left"><?php echo $nameCompe ?></td>
    <th colspan="2"></th>
    <th align="right">Competencias:</th>
    <td align="left"><?php echo $nomC ?></td>
  </tr>
  <tr>
    <th align="left">Fecha de Malla curricular:</th>
    <td align="left"><?php echo $fechaMalla ?></td>
    <th colspan="5"></th>
    <th align="right">¿Cursos obligatorios?:</th>
    <td align="left"><?php echo $nameObliga ?></td>
  </tr>
</table>
<br>
<table border="1">
  <thead>
  	<tr>
  		<th aling="center" bgcolor="#fcf8e3" rowspan="2" style="width:15%;">Curso</th>
  		<th aling="center" bgcolor="#fcf8e3" rowspan="2">Total de competencias <br> a las que aporta</th>
  		<!-- <th aling="center" rowspan="2">TCNA</th> -->
  		<th aling="center" bgcolor="#d9edf7" colspan="<?= sizeof($competencias1) ?>">Sello UP</th>
  		<th aling="center" bgcolor="#fcf8e3" colspan="<?= sizeof($competencias2) ?>">Especifica de la carrera</th>
  	</tr>
  	<tr>
  		<?php foreach ($competencias1 as $competencia): ?>
  		<th class="text-center" bgcolor="#d9edf7">
  		  	<?= $competencia['descripcion'] ?>
  		</th>
  		<?php endforeach; ?>

  		<?php foreach ($competencias2 as $competencia): ?>
  		<th align="center" bgcolor="#fcf8e3">
  			<?= $competencia['descripcion'] ?>
  		</th>
  		<?php endforeach; ?>
  	</tr>
  </thead>
  <tbody>
  <?php
      foreach ($cursos as $curso)
      {
  		$idCurso = $curso['idCurso'];

  		// TCA
  		$sqlCA = $conn->query("SELECT
      COUNT(DISTINCT dcna.idCompetencia) totalCA
  FROM
      detalle_curso_nivelaporte dcna
          LEFT JOIN
      detalle_malla dm ON (dm.idCurso = dcna.idCurso)
          LEFT JOIN
      curso c ON (c.idCurso = dcna.idCurso)
          LEFT JOIN
      departamento d ON (d.idDepartamento = c.idDepartamento)
          LEFT JOIN
      competencia cc ON (cc.idCompetencia = dcna.idCompetencia)
          LEFT JOIN
      tipocompetencia tc ON (tc.idTipo = cc.idTipo)
  WHERE
      dcna.idCarrera = '$idCarrera' AND dcna.idCurso=$idCurso
          AND tipoaporte IN (1,2,3) $sWhere
  GROUP BY dcna.idCurso
  ORDER BY dcna.idCurso , dcna.idCompetencia")
  		or die(mysqli_error($conn));
  		$resCA = $sqlCA->fetch_assoc();
  		// $sqlCA = $conn->query("SELECT COUNT(DISTINCT idCompetencia) totalCA FROM detalle_curso_nivelaporte
  		// 	WHERE idCarrera='$idCarrera' AND idCurso='$idCurso'
      //         AND tipoaporte IN (1,2,3) AND idCompetencia IN($idComp) GROUP BY idCurso")
  		// or die(mysqli_error($conn));
  		// $resCA = $sqlCA->fetch_assoc();

  		// TNCA = Total Competencias - TCA
  ?>

    <tr>
  		<td><?= $curso['nombreCurso'] ?></td>
  		<td align="center"><?= $resCA['totalCA'] ?></td>
  		<!-- <td align="center"><?= $totalCompetencias - $resCA['totalCA'] ?></td> -->

  		<?php foreach ($competencias1 as $competencia): ?>
  		<td align="center" bgcolor="#d9edf7">
  		  	<?= esTCA($idCurso, $competencia['idCompetencia'], $mtAportes) ? '&times;' : '' ?>
  		</td>
  		<?php endforeach; ?>

  		<?php foreach ($competencias2 as $competencia): ?>
  		<td align="center" bgcolor="#fcf8e3">
  			<?= esTCA($idCurso, $competencia['idCompetencia'], $mtAportes) ? '&times;' : '' ?>
  		</td>
  		<?php endforeach; ?>
    </tr>
  <?php
  	}
  ?>
  </tbody>
</table>
