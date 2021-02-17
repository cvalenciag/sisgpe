<?php
require_once '../valid.php';

$idCarrera  = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$fechaMalla = (isset($_REQUEST['fechaMalla']) && !empty($_REQUEST['fechaMalla']))?$_REQUEST['fechaMalla']:'';
$tipoComp   = (isset($_REQUEST['tipoComp']) && !empty($_REQUEST['tipoComp']))?$_REQUEST['tipoComp']:'';
$idComp     = (isset($_REQUEST['idComp']) && !empty($_REQUEST['idComp']))?$_REQUEST['idComp']:'';
$idObliga   = (isset($_REQUEST['idObliga']) && !empty($_REQUEST['idObliga']))?$_REQUEST['idObliga']:'';


$sWhere = "";
if($idObliga==3){
  // echo 'obliga_'.$idObliga.'_tipo_'.$tipoComp;
  $sWhere = "AND dcn.idTipo='$tipoComp'";
}

if($tipoComp==3){
  // echo 'tipo_'.$tipoComp.'_obliga_'.$idObliga;
  $sWhere = "AND dm.obligatoriedad='$idObliga'";
  // $sWhere = "AND dcn.idTipo='$tipoComp'";
}

if($tipoComp==3 || $idObliga==3){
  $sWhere = "";
}

// ESTO ES LO ULTIMO QUE ESTA BIEN =============================================
// if($tipoComp!=3){
//   $sWhere = "AND dcn.idTipo='$tipoComp'";
// }
//
// if($tipoComp!=3 && $idObliga!=3){
//   $sWhere = "";
// }
//
// if($tipoComp!=3 && $idComp!=''){
//   $sWhere  = "AND dcn.idTipo='$tipoComp' AND dcn.idCompetencia IN ($idComp)";
// }



// if ($idComp!='') {
//   $sWhere = "AND dcn.idCompetencia IN ($idComp)";
// }

// if ($idCarrera!='' && $fechaMalla!='' && $idObliga!='') {
//   $sWhere = "WHERE dcn.idCarrera='$idCarrera' AND dcn.fAprobacionPerfil='$fechaMalla' AND dm.obligatoriedad='$idObliga' AND";
//   $groupBy = "dcn.idCurso";
// }
//
// if($idCarrera!='' && $fechaMalla!='' && $tipoComp!='') {
//   $sWhere = "WHERE dcn.idCarrera='$idCarrera' AND dcn.fAprobacionPerfil='$fechaMalla' AND dcn.idTipo='$tipoComp' AND";
//   $groupBy = "dcn.idCurso";
// }
//
// if ($idCarrera!='' && $fechaMalla!='' && $tipoComp!='' && $idComp!='') {
//   $sWhere = "WHERE dcn.idCarrera='$idCarrera' AND dcn.fAprobacionPerfil='$fechaMalla' AND dcn.idTipo='$tipoComp' AND dcn.idCompetencia IN ($idComp) AND";
//   $groupBy = "dcn.idCurso";
// }
//
// if ($idCarrera!='' && $fechaMalla!='' && $tipoComp!='' && $idComp!='' && $idObliga!='') {
//   $sWhere = "WHERE dcn.idCarrera='$idCarrera' AND dcn.fAprobacionPerfil='$fechaMalla' AND dcn.idTipo='$tipoComp' AND dm.obligatoriedad='$idObliga' AND dcn.idCompetencia IN($idComp) AND";
//   $groupBy = "dcn.idCurso";
// }
//
// if ($idCarrera!='' && $fechaMalla!='' && $tipoComp=='3' && $idComp!='' && $idObliga!='') {
//   $sWhere = "WHERE dcn.idCarrera='$idCarrera' AND dcn.fAprobacionPerfil='$fechaMalla' AND dm.obligatoriedad='$idObliga' AND dcn.idCompetencia IN($idComp) AND";
//   $groupBy = "dcn.idCurso";
// }
//
// if ($idCarrera!='' && $fechaMalla!='' && $tipoComp!='' && $idComp!='' && $idObliga=='3') {
//   $sWhere = "WHERE dcn.idCarrera='$idCarrera' AND dcn.fAprobacionPerfil='$fechaMalla' AND dcn.idTipo='$tipoComp' AND dcn.idCompetencia IN($idComp) AND";
//   $groupBy = "dcn.idCurso";
// }
//
// if ($idCarrera!='' && $fechaMalla!='' && $tipoComp!='' && $idObliga=='3' && $idComp=='') {
//   $sWhere = "WHERE dcn.idCarrera='$idCarrera' AND dcn.fAprobacionPerfil='$fechaMalla' AND dcn.idTipo='$tipoComp' AND";
//   $groupBy = "dcn.idCurso";
// }
//
//
// if ($tipoComp==3 && $idObliga==3) {
//   $sWhere = "WHERE dcn.idCarrera='$idCarrera' AND dcn.fAprobacionPerfil='$fechaMalla' AND dcn.idCompetencia IN($idComp) AND";
//   $groupBy = "dcn.idCompetencia";
// }



$sql = $conn->query("SELECT dcn.idCarrera, dcn.idCurso, c.nombreCurso, dm.ciclo, c.idDepartamento, d.descripcion AS nomDepto,
                    dcn.idCompetencia, cc.descripcion AS nomCompetencia, tc.descripcion as nomTipoComp, dcn.fAprobacionPerfil, dcn.tipoaporte, dcn.idTipo, dm.obligatoriedad FROM detalle_curso_nivelaporte dcn LEFT JOIN
                    detalle_malla dm ON (dm.idCurso = dcn.idCurso) LEFT JOIN curso c ON (c.idCurso = dcn.idCurso)
                    LEFT JOIN departamento d ON (d.idDepartamento = c.idDepartamento)
                    LEFT JOIN competencia cc ON (cc.idCompetencia = dcn.idCompetencia)
                    LEFT JOIN tipocompetencia tc ON (tc.idTipo = cc.idTipo)
                    WHERE dcn.idCarrera='$idCarrera'
                    -- WHERE dcn.idCarrera='$idCarrera' AND dcn.fAprobacionPerfil='$fechaMalla'
                    AND dcn.idCompetencia IN ($idComp) AND (tipoaporte!=0 AND tipoaporte!=4) $sWhere
                    GROUP BY dcn.idCurso ORDER BY dcn.idCurso, dcn.idCompetencia") or die(mysqli_error($conn));

if ($sql->num_rows>0)
{
?>
<div class="">
  <label>Descargar</label>
  <table id="tablaResult" class="table table-bordered" style="width:100%;">
    <thead>
      <tr class="bg-primary">
        <th class='text-center' style="width:22%;">Curso</th>
        <th class='text-center' style="width:10%;">Ciclo</th>
        <th class='text-center' style="width:28%;">Departamento <br>Académico </th>
        <th class='text-center' style="width:10%;">Obligatorio</th>
        <th class='text-center' style="width:17%;">Total de <br> Competencias</th>
        <!-- <th class='text-center' style="width:13%;">Tipo de <br>Competencia</th> -->
        <!-- <th class='text-center' style="width:10%;">Aporta?</th> -->
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
  	    $obligatorio   = $row['obligatoriedad'];

        $qryTotal = $conn->query("SELECT COUNT(*) totalComp FROM (SELECT idCompetencia FROM detalle_curso_nivelaporte dcn
                                  WHERE dcn.idCarrera='$idCarrera' AND dcn.idCurso='$idCurso' AND dcn.idCompetencia IN ($idComp)  AND (tipoaporte!=0 AND tipoaporte!=4) $sWhere
                                  GROUP BY dcn.idCurso, dcn.idCompetencia) total") or die(mysqli_error($conn));
        $numTotal = $qryTotal->fetch_assoc();

        // $qryCompetencias = $conn->query("SELECT idCompetencia FROM detalle_curso_nivelaporte dcn
        //                           WHERE dcn.idCarrera='$idCarrera' AND dcn.fAprobacionPerfil='$fechaMalla' AND dcn.idCurso='$idCurso' AND (tipoaporte!=0 AND tipoaporte!=4) $sWhere
        //                           GROUP BY dcn.idCurso, dcn.idCompetencia") or die(mysqli_error($conn));
        // $numeroCompe = $qryCompetencias->fetch_assoc();

        //
        // $resultHaveAporte = $conn->query("SELECT COUNT(*) total FROM detalle_curso_nivelaporte dcn WHERE idCarrera='$idCarrera' AND idCurso='$idCurso' AND dcn.idCompetencia IN ($idComp) AND (tipoaporte!=0 AND tipoaporte!=4) $sWhere ") or die(mysqli_error($conn));
        //
        // $numRegAporte = $resultHaveAporte->fetch_assoc();
    ?>

    <tr>
      <td class='text-center'><?php echo $nombreCurso;?></td>
      <td class='text-center'><?php echo $ciclo;?></td>
      <td class='text-center'><?php echo $depto;?></td>
      <!-- <td class='text-center'><?php echo $competencia;?></td> -->
      <td class='text-center'><?php echo $obligatorio==1 ? 'Si' : 'No' ?></td>
      <td class='text-center'>
        <a href="#" data-toggle="modal" data-target="#verCompetencias" onclick="verCompetencias(<?php echo $idCarrera ?>, <?php echo $idCurso ?>);"><?php echo $numTotal['totalComp'] ?></a>

        <input type="hidden" name="" value="<?php echo $fechaPerfil; ?>" id="fechaPerfil">
      </td>
      <!-- <td class='text-center'><?php echo $tipoComp;?></td> -->

    </tr>

    <?php
  	  }
    ?>
    </tbody>
  </table>
</div>

<?php
}else {
?>
  <br>
  <table style="width:100%;">
    <tr>
      <td class="text-center">
        <b>No existen datos para mostrar...</b>
        <input type="hidden" name="" id="idResult" value="1">
      </td>
    </tr>
  </table>

<?php
}
?>
