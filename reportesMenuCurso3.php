<?php

require_once 'connect.php';

// $idCarrera = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera'])) ? $_REQUEST['idCarrera'] : '';
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


// Totales (No se necesitan queries aparte, porque se cuentan de las mismas competencias obtenidas previamente)
/* WHER
$totComp1 = $conn->query("SELECT COUNT(*) totalRow1 FROM detalle_carrera_competencia LEFT JOIN competencia USING (idCompetencia) WHERE idTipo=1 AND idCarrera='$idCarrera'")
	or die(mysqli_error($conn));
$row1 = $totComp1->fetch_assoc();

$totComp2 = $conn->query("SELECT COUNT(*) totalRow2 FROM detalle_carrera_competencia LEFT JOIN competencia USING (idCompetencia) WHERE idTipo=2 AND idCarrera='$idCarrera'")
	or die(mysqli_error($conn));
$row2 = $totComp2->fetch_assoc();
*/

// Función para debug
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
// dd($mtAportes);


function esTCA($idCurso, $idCompetencia, $mtAportes) {
	foreach ($mtAportes as $aporte) {
		if ($aporte['idCurso'] == $idCurso && $aporte['idCompetencia'] == $idCompetencia && $aporte['tipoAporte'] != '4')
			return true;
	}
 
	return false;
}

$totalCompetencias = sizeof($competencias1) + sizeof($competencias2);

// dd(esTCA(1202, 14, $mtAportes));
?>

<table class="table table-bordered" style="width:100%;" border="1">
<thead>
	<tr>
		<th class="text-center bg-warning" rowspan="2" style="width:15%;">Curso</th>
		<th class="text-center bg-warning" rowspan="2">Total de competencias <br> a las que aporta</th>
		<!-- <th class="text-center bg-warning" rowspan="2">TCNA</th> -->
		<th class="text-center bg-info" colspan="<?= sizeof($competencias1) ?>">Sello UP</th>
		<th class="text-center bg-warning" colspan="<?= sizeof($competencias2) ?>">Especifica de la carrera</th>
	</tr>
	<tr>
		<?php foreach ($competencias1 as $competencia): ?>
		<th class="text-center bg-info">
		  	<?= $competencia['descripcion'] ?>
		</th>
		<?php endforeach; ?>

		<?php foreach ($competencias2 as $competencia): ?>
		<th class="text-center bg-warning">
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
		<td class="text-center"><?= $resCA['totalCA'] ?></td>
		<!-- <td class="text-center"><?= $totalCompetencias - $resCA['totalCA'] ?></td> -->

		<?php foreach ($competencias1 as $competencia): ?>
		<td class="text-center bg-info">
		  	<?= esTCA($idCurso, $competencia['idCompetencia'], $mtAportes) ? '✓' : '' ?>
		</td>
		<?php endforeach; ?>

		<?php foreach ($competencias2 as $competencia): ?>
		<td class="text-center bg-warning">
			<?= esTCA($idCurso, $competencia['idCompetencia'], $mtAportes) ? '✓' : '' ?>
		</td>
		<?php endforeach; ?>

    </tr>


<?php
	}
?>
</tbody>
</table>
