<?php

require_once '../valid.php';

$idCarrera  = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$semestre1 	= (isset($_REQUEST['semestre1']) && !empty($_REQUEST['semestre1']))?$_REQUEST['semestre1']:'';
$semestre2  = (isset($_REQUEST['semestre2']) && !empty($_REQUEST['semestre2']))?$_REQUEST['semestre2']:'';

// $sWhere='';
// if($obligaCurso == 1){
// 	$sWhere = "AND dm.obligatoriedad=1";
// }
//
// if($obligaCurso == 0){
// 	$sWhere = "AND dm.obligatoriedad=0";
// }
//
// if($obligaCurso == '-1'){
// 	$sWhere = "";
// }

// $sql = $conn->query("SELECT dm.ciclo, c.codUpCurso, c.nombreCurso, d.nombreCorto, c.cantHorasTeorica, c.cantHorasPractica,
// 										 c.credito FROM carrera ca LEFT JOIN facultad f ON (ca.idFacultad = f.idFacultad) LEFT JOIN malla m ON (ca.idCarrera = m.idCarrera) LEFT JOIN detalle_malla dm ON (m.idmalla = dm.idMalla) LEFT JOIN curso c ON (dm.idCurso = c.idCurso) LEFT JOIN departamento d ON (c.idDepartamento = d.idDepartamento)
// 										 WHERE f.idFacultad='$idFacultad' AND m.idCarrera='$idCarrera' AND fAprobacion = '$fechaMalla'
//         		 				 $sWhere ORDER BY dm.ciclo , d.nombreCorto") or die(mysqli_error($conn));
//
// if ($sql->num_rows>0)
// {
?>


<table class="table table-bordered" style="width:100%;">
	<thead>
		<tr class="bg-primary">
	 		<th class="text-center"></th>
	 		<th class="text-center" colspan="2"><?php echo $semestre1 ?></th>
	 		<th class="text-center" colspan="2"><?php echo $semestre2 ?></th>
	 		<th class="text-center" colspan="2">% Total</th>
	 	</tr>
		<tr class="alert-info">
      <th class="text-center">Competencias</th>
	 		<th class="text-center">Total de <br> evaluaciones</th>
	 		<th class="text-center">Total de <br> logros</th>
	 		<th class="text-center">Total de <br> evaluaciones</th>
	 		<th class="text-center">Total de <br> logros</th>
	 		<th class="text-center"><?php echo $semestre1 ?></th>
	 		<th class="text-center"><?php echo $semestre2 ?></th>
	 	</tr>
 	</thead>
 	<tbody>
    <?php
      $qryComp = $conn->query("SELECT dr.idCompetencia, descripcion FROM rubrica r
			LEFT JOIN detalle_rubrica dr ON (dr.idRubrica=r.idRubrica)
      LEFT JOIN competencia c ON (c.idCompetencia = dr.idCompetencia) GROUP BY dr.idCompetencia") or die(mysqli_error($conn));

      foreach ($qryComp as $comp)
      {
				$idCompetencia = $comp['idCompetencia'];

				$qryEvaluaciones1 = $conn->query("SELECT * FROM detalle_evaluacion de
					LEFT JOIN evaluacion e ON (e.idEvaluacion = de.idEvaluacion)
					LEFT JOIN rubrica r ON (r.idRubrica = de.idRubrica)
					LEFT JOIN detalle_rubrica dr ON(dr.idRubrica=de.idRubrica)
					WHERE de.idCarrera=$idCarrera AND dr.idCompetencia=$idCompetencia AND e.semestre='$semestre1'
					GROUP BY de.idRubrica") or die(mysqli_error($conn));
				$totalEvaluaciones1 = $qryEvaluaciones1->num_rows;

				$qryEvaluaciones2 = $conn->query("SELECT * FROM detalle_evaluacion de
					LEFT JOIN evaluacion e ON (e.idEvaluacion = de.idEvaluacion)
					LEFT JOIN rubrica r ON (r.idRubrica = de.idRubrica)
					LEFT JOIN detalle_rubrica dr ON(dr.idRubrica=de.idRubrica)
					WHERE de.idCarrera=$idCarrera AND dr.idCompetencia=$idCompetencia AND e.semestre='$semestre2'
					GROUP BY de.idRubrica") or die(mysqli_error($conn));
				$totalEvaluaciones2 = $qryEvaluaciones2->num_rows;

				?>
    <tr>
      <td class="text-justify"><?php echo $comp['descripcion'] ?></td>
      <td class="text-center"><?php echo $totalEvaluaciones1 ?></td>
      <td class="text-center"></td>
      <td class="text-center"><?php echo $totalEvaluaciones2 ?></td>
			<td class="text-center"></td>
			<td class="text-center"></td>
			<td class="text-center"></td>
    </tr>

    <?php

      }
    ?>
 	</tbody>
	</table>
