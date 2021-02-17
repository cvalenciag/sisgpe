<?php
require_once '../valid.php';
$session_id = $_SESSION['session_id'];


  $idCurso      = $_GET['idCurso'];
  $idTipoEval   = $_GET['idTipoEval'];
  $idModalidad  = $_GET['idModalidad'];

  $editEval     = (isset($_GET['editaEval']) && !empty($_GET['editaEval']))?$_GET['editaEval']:'';
  // $idEvaluacion = (isset($_GET['idEvaluacion']) && !empty($_GET['idEvaluacion']))?$_GET['idEvaluacion']:'';
  $idRubrica    = (isset($_GET['idRubrica']) && !empty($_GET['idRubrica']))?$_GET['idRubrica']:'';
  $idGrupoAlum  = (isset($_GET['idGrupoAlum']) && !empty($_GET['idGrupoAlum']))?$_GET['idGrupoAlum']:'';


  $qryNomCurso = $conn->query("SELECT * FROM curso WHERE idCurso='$idCurso'") or die(mysqli_error($conn));
  $resNomCurso = $qryNomCurso->fetch_array();

  $qryTipoEval = $conn->query("SELECT * FROM tipo_evaluacion WHERE idTipoEval='$idTipoEval'") or die(mysqli_error($conn));
  $resTipoEval = $qryTipoEval->fetch_array();


  if($editEval == 1){
    $idEvaluacion = $_GET['idEvaluacion'];
  }
  // else {
  //   $qryMax = $conn->query("SELECT MAX(idEvaluacion) as maxId FROM evaluacion WHERE estado=1") or die (mysqli_error($conn));
  //   $resMax = $qryMax->fetch_array();
  //   $maxID  = $resMax['maxId'] + 1;
  // }

?>
<div class="modal-dialog modal-md" style="width:70%;" backdrop="true">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4>Agregar Evaluadores</h4>
    </div>

    <div class="modal-body">
      <label><b>Curso: &nbsp;</b></label><?php echo $resNomCurso['nombreCurso']; ?> <br>
      <label><b>Tipo de evaluación: &nbsp;</b></label><?php echo $resTipoEval['descripcion']; ?> <br>
      <label><b>Modalidad de evaluación: &nbsp;</b></label><?php echo $idModalidad==1 ? 'Escrito' : 'Oral' ?>
 
      <br><br><br>
      <input type="hidden" name="" id="idCursoMod" value="<?php echo $idCurso ?>">
      <input type="hidden" name="" id="idEvaluacionMod" value="<?php echo $idEvaluacion ?>">
      <input type="hidden" name="" id="editEvalMod" value="<?php echo $editEval ?>">
      <input type="hidden" name="" id="idRubricaMod" value="<?php echo $idRubrica ?>">
      <input type="hidden" name="" id="idGrupoAlumMod" value="<?php echo $idGrupoAlum ?>">

      <div class="admin_eval">
        <!-- <label>Descargar</label> -->
        <table id="tableEvaluadores" class="table table-bordered table-hover" style="width:100%;">
          <thead>
            <tr class="alert-info">
              <th class="text-center">Nombre</th>
              <th class="text-center">Apellido</th>
              <th class="text-center">Relación UP</th>
              <th class="text-center">Organización</th>
              <th class="text-center">Cargo</th>
              <th class="text-center">Agregar</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $qryEvaluadores = $conn->query("SELECT * FROM evaluador e LEFT JOIN detalle_evaluador_curso de ON (de.idEvaluador=e.idEvaluador) LEFT JOIN cargo c ON (c.idCargo=e.idCargo) WHERE idCurso='$idCurso' AND estado=1") or die(mysqli_error($conn));

            foreach ($qryEvaluadores as $qryEvals)
            {
            ?>
            <tr>

              <td class="text-justify"><?php echo $qryEvals['nomEvaluador'] ?></td>
              <td class="text-justify"><?php echo $qryEvals['apeEvaluador'] ?></td>
              <td class="text-center"><?php echo $qryEvals['relUpEvaluador'] == 1 ? 'Colaborador' : 'Externo' ?></td>
              <td class="text-center"><?php echo $qryEvals['orgaEvaluador'] ?></td>
              <td class="text-center"><?php echo $qryEvals['descripcion'] ?></td>
              <td class="text-center">

              <?php
                $idEvaluador = $qryEvals['idEvaluador'];

                if($editEval == 1){
                  $qryEvalTemp = $conn->query("SELECT * FROM detalle_evaluacion WHERE idEvaluacion='$idEvaluacion' AND idEvaluador='$idEvaluador' AND eliminado=1") or die(mysqli_error($conn));
                }else {
                  $qryEvalTemp = $conn->query("SELECT * FROM tmp WHERE idEvaluador='$idEvaluador' AND idSession='$session_id'");
                }


                if ($qryEvalTemp->num_rows>0){
                  $var = "btn btn-danger btn-sm glyphicon glyphicon-ok";
                }else {
                  $var = "btn btn-success btn-sm glyphicon glyphicon-plus";
                }
              ?>

              <button type="button" name="button" class="<?php echo $var ?>"
                id="btnAddEval_<?php echo $idEvaluador ?>" onclick="saveEvaluador(this.id)">
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
  $('#tableEvaluadores').DataTable( {
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
    },

    // dom: 'Bfrtip',
      // buttons: [
      // {
      //   extend: 'pdf',
      //   text: '<img src="images/pdf.png" width=20 height=20/>',
      //   titleAttr: 'Exportar a pdf'
      // },
      // {
      //   extend: 'excel',
      //   text: '<img src="images/xls.png" width=20 height=20/>',
      //   titleAttr: 'Exportar a excel'
      // },
      // {
      //   extend: 'csv',
      //   text: '<img src="images/csv.png" width=20 height=20/>',
      //   titleAttr: 'Exportar a csv'
      // },
      // {
      //   extend: 'print',
      //   text: '<img src="images/print.png" width=20 height=20/>',
      //   titleAttr: 'Imprimir'
      // }],
      columnDefs: [
        { width: "20%", targets: 0 },
        { width: "20%", targets: 1 },
        { width: "10%", targets: 2 },
        { width: "20%", targets: 3 },
        { width: "20%", targets: 4 },
        { width: "10%", targets: 5 },
      ],
    });
});


function saveEvaluador(id){

  arr           = id.split('_');
  xIdEvaluador  = arr[1];
  xIdCursoMod   = $('#idCursoMod').val();

  xEditEval     = $('#editEvalMod').val();
  xIdEvaluacion = $('#idEvaluacionMod').val();
  xIdRubrica    = $('#idRubricaMod').val();
  xIdGrupoAlum  = $('#idGrupoAlumMod').val();

  $('#btnAddEval_'+xIdEvaluador).addClass("btn btn-danger glyphicon glyphicon-ok");


  if(xEditEval==1){
    datos = "idEvaluador="+xIdEvaluador+'&editaEval='+xEditEval+'&xIdEvaluacion='+xIdEvaluacion+'&xIdRubrica='+xIdRubrica+'&xIdGrupoAlum='+xIdGrupoAlum;
  }else {
    datos = "idEvaluador="+xIdEvaluador+'&xIdRubrica='+xIdRubrica+'&xIdGrupoAlum='+xIdGrupoAlum+'&tempEval=t';
  }

  $.ajax({
    type: 'POST',
  	url: 'gEvaluacionGrabar.php',
    // data: "idEvaluador="+xIdEvaluador+'&idCursoMod='+xIdCursoMod+'&tempEval=t',
    data: datos,

    beforeSend: function(objeto){
      $("#resultEvaluadores").html("Mensaje: Cargando...");
    },

    success: function(datos){
      $("#resultEvaluadores").html(datos);
    }

  }); //LLAVE AJAX

}
</script>
