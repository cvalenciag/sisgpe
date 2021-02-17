<?php
require_once '../valid.php';
$session_id = $_SESSION['session_id'];

$idCurso      = (isset($_REQUEST['idCurso']) && !empty($_REQUEST['idCurso']))?$_REQUEST['idCurso']:'';
$editCriterio = (isset($_REQUEST['editar']) && !empty($_REQUEST['editar']))?$_REQUEST['editar']:'';

if($editCriterio == 2){
  $idRubrica = $_GET['idRubrica'];
}

$qryNameCurso = $conn->query("SELECT * FROM curso WHERE idCurso='$idCurso' AND estado=1") or die(mysqli_error($conn));
$resNameCurso = $qryNameCurso->fetch_array();
$nameCurso		= $resNameCurso['nombreCurso'];
?>

<div class="modal-dialog modal-md" style="width:80%;" backdrop="true">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4>Agregar Criterios</h4>
    </div>

    <div class="modal-body">

      <div class="admin_eval">
        <label>Curso: </label> <?php echo $nameCurso ?>

        <br><br>

        <table id="tableCriterios" class="table table-bordered table-hover" style="width:100%;">
          <thead>
            <tr class="alert-info">
              <th class="text-center">Descripción del <br> Criterio</th>
              <th class="text-center">Orden de <br> Criterio</th>
              <th class="text-center">Tipo de <br> Competencia</th>
              <th class="text-center">Competencia</th>
              <th class="text-center">Objetivo General</th>
              <th class="text-center">Agregar</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $qryCriterios = $conn->query("SELECT * FROM criterio WHERE estado=1") or die(mysqli_error($conn));

              foreach ($qryCriterios as $criterios)
              {
                $idCriterio = $criterios['idCriterio'];

                if($editCriterio==2){
                  $qryTemporal = $conn->query("SELECT * FROM detalle_rubrica t LEFT JOIN criterio c USING (idCriterio) WHERE idCurso='$idCurso' AND t.idCriterio='$idCriterio' AND idRubrica='$idRubrica' AND eliminado=1") or die(mysqli_error($conn));
                }else {
                  $qryTemporal = $conn->query("SELECT * FROM tmp t LEFT JOIN criterio c USING (idCriterio) WHERE idCurso='$idCurso' AND t.idCriterio='$idCriterio' AND idSession='$session_id'") or die(mysqli_error($conn));
                }

                $resTemporal = $qryTemporal->fetch_assoc();

      					if ($qryTemporal->num_rows>0){
      						$var = "btn btn-sm btn-danger glyphicon glyphicon-ok";

      						$ordenamiento       = $resTemporal["ordenamiento"];
      						$idTipoCompetencia  = ($editCriterio==2 ? $resTemporal["idTipoCompetencia"] : $resTemporal["obligatorio"]);
      						$idCompetencia      = $resTemporal["idCompetencia"];
      						$idObjetivoGeneral  = ($editCriterio==2 ? $resTemporal["idObjetivoGeneral"] : $resTemporal["idObjgeneral"]);

      					} else {
      						$var ="btn btn-sm btn-success glyphicon glyphicon-plus";

                  $ordenamiento       = $resTemporal["ordenamiento"];
      						$idTipoCompetencia  = ($editCriterio==2 ? $resTemporal["idTipoCompetencia"] : $resTemporal["obligatorio"]);
      						$idCompetencia      = $resTemporal["idCompetencia"];
      						$idObjetivoGeneral  = ($editCriterio==2 ? $resTemporal["idObjetivoGeneral"] : $resTemporal["idObjgeneral"]);
      					}
            ?>
            <tr>
              <td style="width:250px;">
                <?php echo $criterios['descripcion'] ?>
                <input type="hidden" id="idCriterio" name="" value="<?php echo $criterios['idCriterio'] ?>">
              </td>
              <td class="text-center">
                <input class="form-control" id="ordenamiento_<?php echo $criterios['idCriterio'] ?>" type="text" name="" value="<?php echo $ordenamiento ?>" style="width:70px;">
              </td>

              <td class="text-center">
                <?php
                  if ($qryTemporal->num_rows>0)
                  {
                ?>
                    <select name="idTipoComp" id="idTipoComp_<?php echo $criterios['idCriterio'] ?>" class="form-control" onchange="changeTipoComp(this.id);" style="width:200px;">
                      <option value="" selected="selected">Seleccione una opción</option>
                      <option value="-1" selected='<?php $idTipoCompetencia=='-1' ? "selected" : "" ?>'>No aplica</option>
                <?php
                      $qryTipoComp = $conn->query("SELECT * FROM tipocompetencia WHERE estado=1") or die(mysqli_error($conn));

                      foreach ($qryTipoComp as $tipoComp)
                      {
                        $selected="";
                        if($tipoComp['idTipo'] == $idTipoCompetencia)
                          $selected = "selected=selected";
                ?>
                        <option value="<?php echo $tipoComp['idTipo']?>" <?php echo $selected ?> ><?php echo $tipoComp['descripcion']?></option>
                <?php
                      }
                ?>
                    </select>
                <?php
                  }else {
                ?>
                  <select name="idTipoComp" id="idTipoComp_<?php echo $criterios['idCriterio'] ?>" class="form-control" onchange="changeTipoComp(this.id);" style="width:200px;">
                    <option value="" selected="selected">Seleccione una opción</option>
                    <option value="-1">No aplica</option>

                <?php
                    $qryTipoComp = $conn->query("SELECT * FROM tipocompetencia WHERE estado=1") or die(mysqli_error($conn));

                    foreach ($qryTipoComp as $tipoComp)
                    {
                ?>
                      <option value="<?php echo $tipoComp['idTipo']?>"><?php echo $tipoComp['descripcion']?></option>
                <?php
                    }
                  }
                ?>
              </td>

              <!-- INICIO DEL COMBO DE COMPETENCIAS -->
              <td class="text-center">
                <?php
                  if ($qryTemporal->num_rows>0)
                  {
                ?>
                    <select class="form-control" name="idCompetencia" id="idCompetencia_<?php echo $criterios['idCriterio'] ?>" onchange="changeCompetencia(this.id);" style="width:200px;">
                      <option value="" selected="selected">Seleccione una opción</option>
                      <option value="-1" selected='<?php echo $idCompetencia == '-1' ? "selected" : "" ?>'>No aplica</option>
                <?php
                    $qryCompetencias = $conn->query("SELECT * FROM competencia WHERE idTipo='$idTipoCompetencia' AND estado=1") or die(mysqli_error($conn));

                    foreach ($qryCompetencias as $competencias)
                    {
                      $selected="";
                      if($competencias['idCompetencia'] == $idCompetencia)
                        $selected = "selected=selected";
                ?>
                      <option value="<?php echo $competencias['idCompetencia']?>" <?php echo $selected ?> ><?php echo $competencias['descripcion']?></option>
                <?php
                    }
                ?>
                    </select>
                <?php
                  }else{
                ?>
                    <select class="form-control" name="idCompetencia" id="idCompetencia_<?php echo $criterios['idCriterio'] ?>" onchange="changeCompetencia(this.id);" style="width:200px;">
                      <option value="" selected="selected">Seleccione una opción</option>
                      <option value="-1">No aplica</option>
                    </select>
                <?php
                  }
                ?>
              </td>
              <!-- FIN DEL COMBO DE COMPETENCIAS -->

              <!-- INICIO DEL COMBO DE OBJETIVOS -->
              <td class="text-center">
                <?php
                  if ($qryTemporal->num_rows>0)
                  {
                ?>
                    <select class="form-control" name="idObjGral" id="idObjGral_<?php echo $criterios['idCriterio'] ?>" style="width:200px;">
                      <option value="" selected="selected">Seleccione una opción</option>
                      <option value="-1" selected='<?php echo $idObjetivoGeneral == '-1' ? "selected" : "" ?>'>No aplica</option>
                <?php
                    $qryObjetivos = $conn->query("SELECT * FROM objgeneral WHERE idCompetencia='$idCompetencia' AND estado=1") or die(mysqli_error($conn));

                    foreach ($qryObjetivos as $objetivos)
                    {
                      $selected="";
                      if($objetivos['idObjgeneral'] == $idObjetivoGeneral)
                        $selected = "selected=selected";
                ?>
                      <option value="<?php echo $objetivos['idObjgeneral']?>" <?php echo $selected ?> ><?php echo $objetivos['definicion']?></option>
                <?php
                    }
                ?>
                    </select>
                <?php
                  }else{
                ?>
                    <select class="form-control" name="idObjGral" id="idObjGral_<?php echo $criterios['idCriterio'] ?>" style="width:200px;">
                      <option value="" selected="selected">Seleccione una opción</option>
                      <option value="-1">No aplica</option>
                    </select>
                <?php
                  }
                ?>
              </td>
              <!-- FIN DEL COMBO DE OBJETIVOS -->

              <td class="text-center">
                <button type="button" name="button" class="<?php echo $var ?>"
                  id="bntSave_<?php echo $idCurso.'_'.$criterios['idCriterio'] ?>" onclick="saveCriterio(this.id)">
                  <input type="hidden" name="" id="idRubrica" value="<?php echo $idRubrica ?>">
                  <input type="hidden" name="" id="editaCriterio" value="<?php echo $editCriterio ?>">
                </button>
              </td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  $('#tableCriterios').DataTable( {
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
    },
    "ordering": false,
    });
});


function changeTipoComp(id){

  arr         = id.split('_');
  xName       = arr[0];
  xIdCriterio = arr[1];
  xValue      = $('#idTipoComp_'+xIdCriterio).val();

  $('#idCompetencia_'+xIdCriterio).empty();

  if(xValue == '-1'){
    $('#idCompetencia_'+xIdCriterio).append('<option value="-1">No aplica</option>');
  }

  $.ajax({
      type: "POST",
      url: './modal/modalAddCriterios2.php',
      data: 'idCriterio='+xIdCriterio+'&idTipoComp='+xValue+'&tipo=t',

      success: function(data){

        var obj = JSON.parse(data);

        xCriterio     = obj.idCriterio;
        xCompetencias = obj.competencias;

        $.each(xCompetencias, function (i, item) {
          $('#idCompetencia_'+xCriterio).append($('<option >', {
            value: item.idCompetencia,
            text : item.descripcion,
          }));
        });
      }
  });

}

function changeCompetencia(id){

  arr         = id.split('_');
  xName       = arr[0];
  xIdCriterio = arr[1];
  xValue      = $('#idCompetencia_'+xIdCriterio).val();

  $('#idObjGral_'+xIdCriterio).empty();

  if(xValue == '-1'){
    $('#idObjGral_'+xIdCriterio).append('<option value="-1">No aplica</option>');
  }

  $.ajax({
      type: "POST",
      url: './modal/modalAddCriterios2.php',
      data: 'idCriterio='+xIdCriterio+'&idCompetencia='+xValue+'&comp=cc',

      success: function(data){
        var obj = JSON.parse(data);

        xCriterio   = obj.idCriterio;
        xObjetivos  = obj.objetivos;

        $('#idObjGral_'+xIdCriterio).append('<option value="-1">No aplica</option>');
        $.each(xObjetivos, function (i, item) {
          $('#idObjGral_'+xCriterio).append($('<option >', {
            value: item.idObjgeneral,
            text : item.definicion,
          }));
        });
      }
  });
}


function saveCriterio(id){

  arr         = id.split('_');
  xName       = arr[0];
  xIdCurso    = arr[1];
  xIdCriterio = arr[2];

  xOrdenCriterio  = $('#ordenamiento_'+xIdCriterio).val();
  xTipoComp       = $('#idTipoComp_'+xIdCriterio).val();
  xIdCompetencia  = $('#idCompetencia_'+xIdCriterio).val();
  xIdObjgeneral   = $('#idObjGral_'+xIdCriterio).val();

  xIdRubrica    = $('#idRubrica').val();
  xEditCriterio = $('#editaCriterio').val();

  if(xOrdenCriterio=="" || xTipoComp=="" || xIdCompetencia=="" || xIdObjgeneral==""){
    alert("Es necesario capturar los valores antes de agregar el registro.");
    return false;
  }

  if(xEditCriterio == 2){
    datos = 'idRubrica='+xIdRubrica+'&idCurso='+xIdCurso+'&idCriterio='+xIdCriterio+'&orden='+xOrdenCriterio+'&tipoComp='+xTipoComp+'&competencia='+xIdCompetencia+'&objgral='+xIdObjgeneral+'&saveDetalle=sd';
  }else {
    datos = 'idCurso='+xIdCurso+'&idCriterio='+xIdCriterio+'&orden='+xOrdenCriterio+'&tipoComp='+xTipoComp+'&competencia='+xIdCompetencia+'&objgral='+xIdObjgeneral+'&save=s';
  }


  $.ajax({
      type: "POST",
      url: 'rubricasGrabar.php',
      data: datos,

      beforeSend: function(objeto){
        $("#resultados").html("Mensaje: Cargando...");
      },

      success: function(datos){

        $("#resultados").html(datos);
      }
  });
}

</script>
