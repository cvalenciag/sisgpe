<?php
require_once '../valid.php';

$idCarrera 			= (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$idCurso   			= (isset($_REQUEST['idCurso']) && !empty($_REQUEST['idCurso']))?$_REQUEST['idCurso']:'';
$fechaPerfil		= (isset($_REQUEST['fechaPerfil']) && !empty($_REQUEST['fechaPerfil']))?$_REQUEST['fechaPerfil']:'';
$tipoCompe			= (isset($_REQUEST['idTipoComp']) && !empty($_REQUEST['idTipoComp']))?$_REQUEST['idTipoComp']:'';
$idCompetencias	= (isset($_REQUEST['idComps']) && !empty($_REQUEST['idComps']))?$_REQUEST['idComps']:'';
$idObliga   		= (isset($_REQUEST['xIdObliga']) && !empty($_REQUEST['xIdObliga']))?$_REQUEST['xIdObliga']:'';


if ($tipoCompe!=3) {
  $sWhere = "AND c.idTipo='$tipoCompe'";
}else {
  $sWhere = '';
}
// echo $idCompetencias;
// echo 'tipocompe_'.$tipoCompe.'_obliga_'.$idObliga;

// $sWhere = "";
// if($tipoCompe!=3 && $idObliga==3){
//   $sWhere = "AND dcn.idTipo='$tipoCompe' AND dcn.idCompetencia IN ($idCompetencias)";
// }
//
// // if($idObliga!=3){
// //   $sWhere = "AND dm.obligatoriedad='$idObliga' AND dcn.idCompetencia IN ($idCompetencias)";
// // }
//
//
// //
// if($tipoCompe!=3 && $idObliga!=3){
//   $sWhere = "AND dm.obligatoriedad='$idObliga' AND dcn.idTipo='$tipoCompe' AND dcn.idCompetencia IN ($idCompetencias)";
// }
//
//
// if($tipoCompe==3 & $idObliga==3){
//   $sWhere = "";
// }

// $sql = $conn->query("SELECT dcn.idCarrera, dcn.idCurso, c.nombreCurso, dm.ciclo, c.idDepartamento, d.descripcion AS nomDepto,
//                     dcn.idCompetencia, cc.descripcion AS nomCompetencia, tc.descripcion as nomTipoComp, dcn.fAprobacionPerfil, dcn.tipoaporte, dcn.idTipo FROM detalle_curso_nivelaporte dcn LEFT JOIN
//                     detalle_malla dm ON (dm.idCurso = dcn.idCurso) LEFT JOIN curso c ON (c.idCurso = dcn.idCurso)
//                     LEFT JOIN departamento d ON (d.idDepartamento = c.idDepartamento)
//                     LEFT JOIN competencia cc ON (cc.idCompetencia = dcn.idCompetencia)
//                     LEFT JOIN tipocompetencia tc ON (tc.idTipo = cc.idTipo)
//                     WHERE dcn.idCarrera='$idCarrera' AND dcn.idCurso='$idCurso' AND (tipoaporte!=0 AND tipoaporte!=4)
// 										$sWhere
// 										GROUP BY dcn.idCurso, dcn.idCompetencia ORDER BY dcn.idCurso, dcn.idCompetencia") or die(mysqli_error($conn));

$sql = $conn->query("SELECT c.descripcion as nomCompetencia, tc.descripcion as nomTipoComp FROM competencia c
                     LEFT JOIN tipocompetencia tc ON(tc.idTIpo=c.idTipo) LEFT JOIN detalle_curso_nivelaporte dcn ON (dcn.idCompetencia=c.idCompetencia) WHERE dcn.idCarrera='$idCarrera' AND dcn.idCurso='$idCurso' AND c.idCompetencia IN ($idCompetencias) AND tipoaporte != 0 AND tipoaporte != 4 $sWhere
                     GROUP BY dcn.idCompetencia") or die(mysqli_error($conn));

$sqlCurso = $conn->query("SELECT * FROM curso WHERE idCurso='$idCurso'") or die(mysqli_error($conn));
$resultCurso = $sqlCurso->fetch_array();

if ($sql->num_rows>0)
{
?>
<div class = "form-group">
	<label>Curso: </label>  <?php echo $resultCurso['nombreCurso'];?>
</div>

<div class="">
	<table class="table table-bordered" style="width:100%;">
		<thead>
			<tr class="bg-primary">
				<th class="text-center">Competencia</th>
				<th class="text-center">Tipo de Competencia</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while ($row = mysqli_fetch_array($sql))
			{
			?>
				<tr>
					<td><?php echo $row['nomCompetencia'] ?></td>
					<td><?php echo $row['nomTipoComp'] ?></td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>

<?php
}
?>
