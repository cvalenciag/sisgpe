<?php
require_once '../valid.php';

$idCarrera  = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$fechaMalla = (isset($_REQUEST['fechaMalla']) && !empty($_REQUEST['fechaMalla']))?$_REQUEST['fechaMalla']:'';
$idTipoComp = (isset($_REQUEST['idTipoComp']) && !empty($_REQUEST['idTipoComp']))?$_REQUEST['idTipoComp']:'';
$idObliga   = (isset($_REQUEST['idObliga']) && !empty($_REQUEST['idObliga']))?$_REQUEST['idObliga']:'';
$idComp     = (isset($_REQUEST['idCompetencia']) && !empty($_REQUEST['idCompetencia']))?$_REQUEST['idCompetencia']:'';
$tipoaporte = (isset($_REQUEST['tipoaporte']) && !empty($_REQUEST['tipoaporte']))?$_REQUEST['tipoaporte']:'';


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

if ($sql->num_rows>0)
{
?>

<!-- <div class=""> -->
  <!-- <label>Descargar</label> -->
  <table id="tablaResultado" class="table table-bordered" style="width:100%;"> 
    <thead>
      <tr class="bg-primary">
        <th class='text-center' style="width:30%;">Curso</th>
        <th class='text-center' style="width:5%;">Ciclo</th>
        <th class='text-center' style="width:10%;">Departamento <br>Académico </th>
        <th class='text-center' style="width:45%;">Objetivo general</th>
        <th class='text-center' style="width:10%;">Nivel de aporte</th>
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
<!-- </div> -->
<?php
}else{
?>

<table style="width:100%;">
  <tr>
    <td class="text-center">
      <b>No existen datos para mostrar...</b>
      <input type="hidden" name="" id="idResultadoNivel" value="1">
    </td>
  </tr>
</table>

<?php
}
?>
