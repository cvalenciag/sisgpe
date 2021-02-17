<?php
require_once 'valid.php';

$idCarrera    = (isset($_REQUEST['carrera']) && !empty($_REQUEST['carrera']))?$_REQUEST['carrera']:'';
$fechaPerfil  = (isset($_REQUEST['fechaPerfil']) && !empty($_REQUEST['fechaPerfil']))?$_REQUEST['fechaPerfil']:'';
$idCurso      = (isset($_REQUEST['idCurso']) && !empty($_REQUEST['idCurso']))?$_REQUEST['idCurso']:'';
$idCiclo      = (isset($_REQUEST['ciclo']) && !empty($_REQUEST['ciclo']))?$_REQUEST['ciclo']:'';

$qfila  = $conn->query("SELECT descripcion FROM carrera where estado=1 and idCarrera='$idCarrera'") or die(mysqli_error($conn));
$fcarre = $qfila->fetch_assoc();

$qfila2 = $conn->query("SELECT nombreCurso FROM curso WHERE estado=1 AND idCurso='$idCurso'") or die(mysqli_error($conn));
$fcurso = $qfila2->fetch_assoc();
?>

<!-- <!DOCTYPE html> -->
<!-- <html lang = "eng">
  <php require("head.php"); ?>
	 <div class = "container-fluid">
    <php require("menu.php"); ?>
      <div class = "col-lg-1"></div>
        <div class = "col-lg-9 well" style = "margin-top:110px;background-color:fefefe;">
          <div class = "alert alert-jcr">Diseño curricular / Nivel de Aporte</div>

          <button id="btnVolver" type = "button" style = "float:right;" class = "btn btn-primary"><span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver</button> -->

          <!-- <br> -->

          <div class = "form-group">
            <label>Malla curricular de la carrera: </label>  <?php echo $fcarre['descripcion'];?>
          </div>

          <div class = "form-group">
            <label>Curso: </label>  <?php echo $fcurso['nombreCurso'];?>
          </div>

					<div class="form-group">
            <label>Ciclo: </label>  <?php echo $idCiclo ?>
          </div>

					<div class = "form-group">
            <label>Fecha del Perfil de egreso: </label> <?php echo $fechaPerfil ?>
					</div>

					<div id="admin_table"> 
              <table id="tableObjs" class="table table-bordered table-hover" style="width:100%;">
                <thead class="alert-info">
                  <tr>
                    <th class="text-center" width="10%">Tipo de competencia</th>
                    <th class="text-center" width="5%">No. de competencia</th>
                    <th class="text-center" width="10%">Competencia</th>
  									<th class="text-center" width="15%">Tipo de objetivo de aprendizaje</th>
  									<th class="text-center" width="15%">No. obj. <br> de aprendizaje</th>
  									<th class="text-center" width="35%">Objetivos de <br> aprendizaje</th>
  									<th class="text-center" width="10%">Tipo de aporte</th>
  								</tr>
                </thead>
                <tbody>

                <?php
                // $qryRegistros = $conn->query("SELECT * FROM detalle_curso_nivelaporte WHERE idCarrera='$idCarrera' AND idCurso='$idCurso' ") or die(mysqli_error($conn));
                //
                // if($qryRegistros->num_rows==0)
                // {
                //
                //   $qryObjetivosGenerales = $conn->query("INSERT INTO detalle_curso_nivelaporte (idCarrera, idCurso, idTipo, idCompetencia, tipoobj, idObjgeneral, idObjespecifico, tipoaporte, eliminado) SELECT $idCarrera, $idCurso, c.idTipo, c.idCompetencia, 1, dco.idObjgeneral, 0, 0, 0 FROM detalle_carrera_og dco LEFT JOIN objgeneral obg ON (obg.idObjgeneral = dco.idObjgeneral)
                //                           LEFT JOIN competencia c ON (c.idCompetencia = obg.idCompetencia)
                //                           LEFT JOIN detalle_carrera_competencia dcc ON (dcc.idCompetencia = c.idCompetencia)
                //                           LEFT JOIN tipocompetencia tc ON (tc.idTipo = c.idTipo)
                //                           LEFT JOIN carrera_og cog ON (cog.idCarreraOg = dco.idCarreraOg AND cog.idCarrera = dco.idCarrera)
                //                           WHERE cog.fAprobacion='$fechaPerfil'") or die(mysqli_error($conn));
                //
                //   $qryNivelAporte = $conn->query("SELECT * FROM detalle_curso_nivelaporte WHERE idCarrera='$idCarrera' AND idCurso='$idCurso'") or die(mysqli_error($conn));
                //
                //   while($resNivelAporte = $qryNivelAporte->fetch_array())
                //   {
                //     $idObjGeneral   = $resNivelAporte['idObjgeneral'];
                //
                //     $qryObjetivosEspecificos = $conn->query("INSERT INTO detalle_curso_nivelaporte (idCarrera, idCurso, idTipo, idCompetencia, tipoobj, idObjgeneral, idObjespecifico, tipoaporte, eliminado) SELECT $idCarrera, $idCurso, c.idTipo, og.idCompetencia, 2, doge.idObjgeneral, doge.idObjespecifico, 0, 0 FROM detalle_og_oe doge
                //     LEFT JOIN objespecifico obje ON (obje.idObjespecifico = doge.idObjespecifico) LEFT JOIN og_oe og ON (og.idObjgeneral=doge.idObjgeneral) LEFT JOIN competencia c ON (c.idCompetencia=og.idCompetencia) WHERE doge.idObjgeneral='$idObjGeneral'") or die(mysqli_error($conn));
                //   }
                //
                // }

                $qryRegistros = $conn->query("SELECT * FROM detalle_curso_nivelaporte WHERE idCarrera='$idCarrera' AND idCurso='$idCurso' ") or die(mysqli_error($conn));

                if($qryRegistros->num_rows==0)
                {

                  // $qryObjetivosGenerales = $conn->query("INSERT INTO detalle_curso_nivelaporte (idCarrera, idCurso, idTipo, idCompetencia, tipoobj, idObjgeneral, idObjespecifico, tipoaporte, eliminado) SELECT $idCarrera, $idCurso, c.idTipo, c.idCompetencia, 1, dco.idObjgeneral, 0, 0, 0 FROM detalle_carrera_og dco LEFT JOIN objgeneral obg ON (obg.idObjgeneral = dco.idObjgeneral)
                  // LEFT JOIN competencia c ON (c.idCompetencia = obg.idCompetencia)
                  // LEFT JOIN detalle_carrera_competencia dcc ON (dcc.idCompetencia = c.idCompetencia)
                  // LEFT JOIN tipocompetencia tc ON (tc.idTipo = c.idTipo)
                  // LEFT JOIN carrera_og cog ON (cog.idCarreraOg = dco.idCarreraOg AND cog.idCarrera = dco.idCarrera)
                  // WHERE cog.fAprobacion='$fechaPerfil'") or die(mysqli_error($conn));
                  $qryObjetivosGenerales = $conn->query("INSERT INTO detalle_curso_nivelaporte
                  (idCarrera, idCurso, idTipo, idCompetencia, tipoobj, idObjgeneral, idObjespecifico, tipoaporte, fAprobacionPerfil, eliminado)
                  SELECT DISTINCT dco.idCarrera, idCurso, c.idTipo, c.idCompetencia, 1, dco.idObjgeneral, 0, 0, '$fechaPerfil', 0
                  FROM detalle_carrera_og dco LEFT JOIN objgeneral obg ON (obg.idObjgeneral = dco.idObjgeneral)
                  LEFT JOIN competencia c ON (c.idCompetencia = obg.idCompetencia)
                  LEFT JOIN detalle_carrera_competencia dcc ON (dcc.idCompetencia = c.idCompetencia)
                  LEFT JOIN tipocompetencia tc ON (tc.idTipo = c.idTipo)
                  LEFT JOIN carrera_og cog ON (cog.idCarreraOg = dco.idCarreraOg AND cog.idCarrera = dco.idCarrera)
                  LEFT JOIN detalle_malla dm ON (dm.idCarrera = dco.idCarrera)
                  WHERE cog.fAprobacion = '$fechaPerfil' AND dco.idCarrera = '$idCarrera' AND idCurso = '$idCurso'") or die(mysqli_error($conn));

                  $qryNivelAporte = $conn->query("SELECT * FROM detalle_curso_nivelaporte WHERE idCarrera='$idCarrera' AND idCurso='$idCurso'") or die(mysqli_error($conn));

                  while($resNivelAporte = $qryNivelAporte->fetch_array())
                  {
                    $idObjGeneral   = $resNivelAporte['idObjgeneral'];

                    $qryObjetivosEspecificos = $conn->query("INSERT INTO detalle_curso_nivelaporte (idCarrera, idCurso, idTipo, idCompetencia, tipoobj, idObjgeneral, idObjespecifico, tipoaporte, fAprobacionPerfil, eliminado) SELECT DISTINCT $idCarrera, $idCurso, c.idTipo, og.idCompetencia, 2, doge.idObjgeneral, doge.idObjespecifico, 0, '$fechaPerfil', 0 FROM detalle_og_oe doge
                    LEFT JOIN objespecifico obje ON (obje.idObjespecifico = doge.idObjespecifico) LEFT JOIN og_oe og ON (og.idObjgeneral=doge.idObjgeneral) LEFT JOIN competencia c ON (c.idCompetencia=og.idCompetencia) WHERE doge.idObjgeneral='$idObjGeneral'") or die(mysqli_error($conn));
                  }

                }


                // $q_admin = $conn->query("SELECT dcn.idCarrera, dcn.idCurso, dcn.idTipo, dcc.ordenamiento AS ordenTipoC, tc.descripcion AS descTipo, dcn.idCompetencia, c.descripcion AS descCompetencia, dcn.tipoobj, dco.ordenamiento AS ordenObjGral, dcn.idObjgeneral, obg.definicion AS descObGral, dcn.idObjespecifico, obe.definicion AS descObEsp,
                // dcn.tipoaporte FROM detalle_curso_nivelaporte dcn LEFT JOIN tipocompetencia tc ON (tc.idTipo = dcn.idTipo)
                // LEFT JOIN competencia c ON (c.idCompetencia = dcn.idCompetencia) LEFT JOIN objgeneral obg ON (obg.idObjgeneral = dcn.idObjgeneral) LEFT JOIN objespecifico obe ON (obe.idObjespecifico = dcn.idObjespecifico)
                // LEFT JOIN detalle_carrera_og dco ON (dco.idObjgeneral = dcn.idObjgeneral AND dco.idCarrera=dcn.idCarrera) LEFT JOIN
                // detalle_carrera_competencia dcc ON (dcc.idCompetencia = dcn.idCompetencia AND dcc.idCarrera=dcn.idCarrera) WHERE dcn.idCarrera='$idCarrera' AND idCurso='$idCurso' ORDER BY dcn.idCarrera, dcn.idCurso, dcn.idCompetencia, dcn.idObjgeneral , dcn.idObjespecifico") or die(mysqli_error($conn));

                $q_admin = $conn->query("SELECT
    dcn.idCarrera,
    dcn.idCurso,
    dcn.tipoobj,
    dcn.idTipo,
    tc.descripcion AS descTipo,
    dcc.ordenamiento AS ordenTipoC,
    dcn.idCompetencia,
    c.descripcion AS descCompetencia,
    dcn.idObjgeneral,
    obg.definicion AS descObjGral,
    dco.ordenamiento AS ordenObjG,
    dcn.idObjespecifico,
    obje.definicion AS descObjEsp,
    IFNULL(doo.ordenamiento, '') AS ordenObjE, dcn.tipoaporte
FROM
    detalle_curso_nivelaporte dcn
        LEFT JOIN
    tipocompetencia tc ON (tc.idTipo = dcn.idTipo)
        LEFT JOIN
    competencia c ON (c.idCompetencia = dcn.idCompetencia)
        LEFT JOIN
    detalle_carrera_competencia dcc ON (dcc.idCompetencia = dcn.idCompetencia
        AND dcc.idCarrera = dcn.idCarrera)
        LEFT JOIN
    objgeneral obg ON (obg.idObjgeneral = dcn.idObjgeneral)
        LEFT JOIN
    objespecifico obje ON (obje.idObjespecifico = dcn.idObjespecifico)
        LEFT JOIN
    detalle_carrera_og dco ON (dco.idCarrera = dcn.idCarrera
        AND dco.idObjgeneral = dcn.idObjgeneral)
        LEFT JOIN
    detalle_og_oe doo ON (doo.idObjgeneral = dcn.idObjgeneral
        AND dcn.idObjespecifico = doo.idObjespecifico)
WHERE
    dcn.idCarrera = '$idCarrera'
        AND idCurso = '$idCurso'
ORDER BY dcn.idCarrera , dcn.idCurso , dcn.idCompetencia , ordenObjG , ordenObjE") or die(mysqli_error($conn));

                while($f_admin = $q_admin->fetch_array())
                {
                  $idTipoC        = $f_admin['idTipo'];
                  $descTipo       = $f_admin['descTipo'];
                  $ordenTipoComp  = $f_admin['ordenTipoC'];
                  $idCompetencia  = $f_admin['idCompetencia'];
                  $desCompetencia = $f_admin['descCompetencia'];
                  $tipoDeObjetivo = $f_admin['tipoobj'];
                  $idObjGeneral   = $f_admin['idObjgeneral'];
                  $descObjGral    = $f_admin['descObjGral'];
                  $ordenObGral    = $f_admin['ordenObjG'];
                  $idObjEspecifico  = $f_admin['idObjespecifico'];
                  $descObjEspe    = $f_admin['descObjEsp'];
                  $ordenObEsp     = $f_admin['ordenObjE'];
                  $nivelAporte    = $f_admin['tipoaporte'];


                  $idObGral1 = substr($ordenObGral,0,-2);
                  $idObGral2 = substr($ordenObGral,1,-1);
                  $idObGral3 = substr($ordenObGral,2);

                  $posOE1 = substr($ordenObEsp,0,-2);
                  $posOE2 = substr($ordenObEsp,1,-1);
                  $posOE3 = substr($ordenObEsp,2);

                  $resIdObjGral = '0'.$idObGral1.'.0'.$idObGral2.'.0'.$idObGral3;
                  $resIdObjEsp  = '0'.$posOE1.'.0'.$posOE2.'.0'.$posOE3;

                ?>
                  <tr class="<?php echo $tipoDeObjetivo == 1 ? 'bg-info' : '' ?>">

                    <td class="text-center <?php echo $tipoDeObjetivo == 1 ? 'bg-negrita' : '' ?>"><?php echo $descTipo ?></td>
                    <td class="text-center <?php echo $tipoDeObjetivo == 1 ? 'bg-negrita' : '' ?>"><?php echo '0'.$ordenTipoComp ?></td>
                    <td class="text-center <?php echo $tipoDeObjetivo == 1 ? 'bg-negrita' : '' ?>"><?php echo $desCompetencia ?></td>
                    <td class="text-center <?php echo $tipoDeObjetivo == 1 ? 'bg-negrita' : '' ?>"><?php echo $tipoDeObjetivo == 1 ? 'General' : 'Específico' ?></td>
                    <td class="text-center <?php echo $tipoDeObjetivo == 1 ? 'bg-negrita' : '' ?>">
                      <?php echo $tipoDeObjetivo == 1 ? $resIdObjGral : $resIdObjEsp ?>
                    </td>
                    <td class="text-center"><?php echo $tipoDeObjetivo == 1 ? $descObjGral : $descObjEspe ?></td>

          <?php
          $common = $idCarrera.'_'.$idCurso.'_'.$idTipoC.'_'.$idCompetencia.'_'.$tipoDeObjetivo.'_'.$idObjGeneral.'_'.$idObjEspecifico;
          ?>

                    <td class="text-justify">
                      <div class="form-group">
                        <select class="target" id="nivel_<?php echo $common ?>" style="width:175px;" onchange="actualizaTipo(this.id, this.value);">

                        <?php

                        if($nivelAporte==1)
                        {
                          echo "<option value = '1' selected='selected'>Contribuye</option>";
                          echo "<option value = '2'>Logra</option>";
                          echo "<option value = '3'>Sostiene</option>";
                          echo "<option value = '4'>No aplica</option>";
                        }
                        if ($nivelAporte==2) {
                          echo "<option value = '1'>Contribuye</option>";
                          echo "<option value = '2' selected='selected'>Logra</option>";
                          echo "<option value = '3'>Sostiene</option>";
                          echo "<option value = '4'>No aplica</option>";
                        }
                        if ($nivelAporte==3) {
                          echo "<option value = '1'>Contribuye</option>";
                          echo "<option value = '2'>Logra</option>";
                          echo "<option value = '3' selected='selected'>Sostiene</option>";
                          echo "<option value = '4'>No aplica</option>";
                        }
                        if ($nivelAporte==4) {
                          echo "<option value = '1'>Contribuye</option>";
                          echo "<option value = '2'>Logra</option>";
                          echo "<option value = '3'>Sostiene</option>";
                          echo "<option value = '4' selected='selected'>No aplica</option>";
                        }
                        if($nivelAporte==0){
                          echo "<option value = '' selected='selected'>Elige un tipo de aporte</option>";
                          echo "<option value = '1'>Contribuye</option>";
                          echo "<option value = '2'>Logra</option>";
                          echo "<option value = '3'>Sostiene</option>";
                          echo "<option value = '4'>No aplica</option>";
                        }
                        ?>

                        </select>
                      </div>
                    </td>

                  </tr>
                <?php
                    // }
                  }
                ?>

                <input type="hidden" name="" id="idCarreraMod" value="<?php echo $idCarrera?>"/>
                <input type="hidden" name="" id="idCursoMod" value="<?php echo $idCurso?>"/>

                </tbody>
              </table>
          </div>


<script type="text/javascript">


function actualizaTipo(id, value)
{
  var arr       = id.split('_');
  var xName     = arr[0];
  var xCarrera  = arr[1];
  var xCurso    = arr[2];
  var xTipo     = arr[3];
  var xComp     = arr[4];
  var xTipoObj  = arr[5];
  var xObjGral  = arr[6];
  var xObjEspc  = arr[7];

  $.ajax({
      type: "POST",
      url: "tipoAporteGrabar.php",
      data: '&op=U'+'&idTipoAporte='+value+'&idCompetencia='+xComp+'&idObGral='+xObjGral+'&idObjEspe='+xObjEspc+'&tipoCompetencia='+xTipo+'&idTipoObj='+xTipoObj+'&idCarrera='+xCarrera+'&idCurso='+xCurso,

      beforeSend: function(objeto){
	    },

	    success: function(datos){
        alert("Registro actualizado.");
		  }

  });

}
</script>
